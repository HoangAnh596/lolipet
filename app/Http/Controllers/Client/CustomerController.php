<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Role;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Models\ModelHasRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\GeneralSetting;
use App\Models\Statistical;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function accountInfo()
    {
        $model = User::find(Auth::user()->id);
        $order = Order::where('user_id', Auth::user()->id)->get();
        $order->load('orderDetails');

        $orderDetail = OrderDetail::all();
        $generalSetting = GeneralSetting::first();
        return view('client.customer.account-info', compact('model', 'order', 'orderDetail', 'generalSetting'));
    }

    // public function updateinfo(){
    //     $model = User::find(Auth::user()->id);
    //     $generalSetting = GeneralSetting::first();

    //     return view('client.customer.updateinfo', [
    //         'model' => $model,
    //         'generalSetting' => $generalSetting
    //     ]);
    // }

    public function saveUpdateinfo(Request $request)
    {
        $user = Auth::user()->id;
        $model = User::find($user);
        if (!$model) {
            return redirect()->back();
        }
        $request->validate(
            [
                'name' => 'required|min:3|max:32',
                'email' => 'required|email',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg',
            ],
            [
                'name.required' => "Hãy nhập vào tên",
                'email.required' => "Hãy nhập email",
                'email.email' => "Không đúng định dạng email",
                'uploadfile.mimes' => 'File ảnh đại diện không đúng định dạng (jpg, bmp, png, jpeg)',
            ]
        );

        $model->fill($request->all());
        // upload ảnh
        if ($request->hasFile('uploadfile')) {
            $model->avatar = $request->file('uploadfile')->storeAs('uploads/users', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
        }
        $model->save();

        return redirect()->back()->with('success', "Cập nhật tài khoản thành công!");
    }

    public function orderHistory(){
        $user_id = Auth::user()->email;
        $order = Order::where('email', $user_id)->orderBy('created_at', 'DESC')->paginate(12);

        $generalSetting = GeneralSetting::first();
        $order->load('orderDetails');

        $orderDetail = OrderDetail::all();

        return view('client.customer.order-history', compact(
            'order',
            'orderDetail',
            'generalSetting'
        ));
    }

    public function order_history_detail($code){
        $order = Order::where('code', $code)->first();
        $generalSetting = GeneralSetting::first();
        $orderDetail = OrderDetail::where('order_id', $order->id)->get();

        return view('client.customer.order_history_detail', compact(
            'order',
            'orderDetail',
            'generalSetting'
        ));
    }

    public function cancel_order($id){
        $user_email = Auth::user()->email;
        $order = Order::find($id);
        if (!$order || ($order->delivery_status != 1)) {
            return redirect()->back();
        }

        if ($order->email == $user_email) {
            $order->delivery_status = '4';
            $order->cancel_order = $user_email;
        } else {
            dd('error');
        }
        $order->save();

        $orderDetail = OrderDetail::where('order_id', $order->id)->get();
        // dd($orderDetail);
        foreach ($orderDetail as $key => $value) {
            $save_or_detail = OrderDetail::find($value->id);
            $save_or_detail->delivery_status = "Đơn hàng bị hủy";
            $save_or_detail->save();

            if ($value->product_type == 1) {
                $product = Product::find($value->product_id);
            } else {
                $product = Accessory::find($value->product_id);
            }
            $cong = $product->quantity + $value->quantity;
            $product->quantity = $cong;
            $product->save();
        }

        return Redirect::to("tai-khoan/chi-tiet-don-hang" . "/" . $order->code)->with('success', "Bạn đã hủy đơn hàng này!");
    }

    public function review(){
        $user_id = Auth::user()->id;
        $review = Review::where('user_id', $user_id)->paginate(5);
        $review->load('product');

        $product = Product::all();
        $generalSetting = GeneralSetting::first();
        // $rating = Review::where('product_id', $id)->avg('rating');
        // $rating = (int)round($rating);
        return view('client.customer.review', compact(
            'review','product','generalSetting'
        ));
    }

    public function deleteReview($id){
        $review = Review::find($id);
        $review->delete();
        return redirect()->back();
    }

    public function favoriteProduct()
    {
        return view('client.customer.favorite-product');
    }
}