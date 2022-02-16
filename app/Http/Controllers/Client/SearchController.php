<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search_query(Request $request)
    {
        $generalSetting = GeneralSetting::first();
        $searchData = $request->except('page');
        if (!empty($request->keyword)) {
            // $query = Product::where('name', 'like', "%" .$request->keyword . "%");
            // $product = $query->paginate(5)->appends($searchData);
            // $category = Category::all();
            // return view('client.product.index', [
            //     'product' => $product,
            //     'category' => $category,
            //     'generalSetting' => $generalSetting,
            //     'searchData' => $searchData
            // ]);
            if ($request->search_type == 1) {
                $key = $request->keyword;
                $count = Order::where('code', $key)->get();
                if (count($count) > 0) {
                    $order = Order::where('code', $key)->first();
                    $order->load('orderDetails');
                    $orderDetail = OrderDetail::where('order_id', $order->id)->get();
                    dd('ss');
                } else {
                    return redirect()->back()->with('danger', "Không tìm thấy mã đơn hàng này. Vui lòng kiểm tra lại!");
                }
            } elseif ($request->search_type == 2) {
                $productQuery = Product::where('name', 'like', "%" . $request->keyword . "%");
                $products = $productQuery->paginate(5)->appends($searchData);

                $products->load('category');

                $categories = Category::all();
                $generalSetting = GeneralSetting::first();
                //trả về cho người dùng 1 giao diện + dữ liệu products vừa lấy đc 
                // return view('client.product.index', [
                //     'product' => $products,
                //     'category' => $categories,
                //     'searchData' => $searchData,
                //     'generalSetting' => $generalSetting
                // ]);
                // return Redirect::route('client.product.index', array(
                //     'searchData' => $searchData
                //  ));
                return redirect()->route('client.product.index', [
                    'product' => $products,
                    'searchData' => $searchData
                ]);
            }
        } else {
            return redirect()->back()->with('danger', "Vui lòng nhập vào nội dung tìm kiếm!");
        }
    }

    public function order_status($code)
    {
        $generalSetting = GeneralSetting::first();
        $count = Order::where('code', $code)->get();
        if (count($count) > 0) {
            $order = Order::where('code', $code)->first();
            $order->load('orderDetails');
            $orderDetail = OrderDetail::where('order_id', $order->id)->get();
            return view('client.search.index', [
                'order' => $order,
                'orderDetail' => $orderDetail,
                'generalSetting' => $generalSetting
            ]);
        } else {
            return redirect()->back()->with('danger', "Không tìm thấy mã đơn hàng này. Vui lòng kiểm tra lại!");
        }
    }
}