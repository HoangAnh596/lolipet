<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\OrderDetail;

class CancelOrderController extends Controller
{
    public function cancel_order_t($id, Request $request){
        $user_email = $request->email;
        $order = Order::find($id);
        if (!$request->email) {
            return redirect()->back()->with('danger', "Vui lòng nhập vào email dùng để dặt hàng nếu bạn muốn hủy đơn hàng này.");
        }
        if (!$order || ($order->delivery_status != 1)) {
            return redirect()->back();
        }
        if ($order->email == $user_email) {
            $order->delivery_status = '4';
            $order->cancel_order = $user_email;
        } else {
            return redirect()->back()->with('danger', "Email không chính xác, vui lòng kiểm tra lại.");
        }
        $order->save();
        $orderDetail = OrderDetail::where('order_id', $order->id)->get();
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

        return redirect()->back()->with('success', "Bạn đã hủy đơn hàng này!");
    }
}
