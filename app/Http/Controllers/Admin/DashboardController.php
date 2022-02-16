<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Review;
use App\Models\Statistical;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request){
        
        $userName = [];
        $userPhone = [];
        $countOrder = [];
        $sumOrder = [];
        $userMul = Order::join('users', 'users.phone', '=', 'orders.phone')
            ->select('users.name as nameUser', 'orders.phone as phoneUser', DB::raw('sum(orders.grand_total) as sumOrder'), DB::raw('COUNT(orders.id) as orderCount'))
            ->where('orders.created_at', 'like', '%' . Carbon::now()->format('Y-m') . '%')
            ->where('delivery_status', 3)->where('payment_status', 2)
            ->groupBy('orders.phone')
            ->orderBy('orderCount', 'desc')
            ->get();
        foreach ($userMul as $user) {
            array_push($userName, $user->nameUser);
            array_push($userPhone, $user->phoneUser);
            array_push($countOrder, $user->orderCount);
            array_push($sumOrder, $user->sumOrder);
        }
        
        $ss = Carbon::now()->daysInMonth;

        $order = Order::select(DB::raw('sum(grand_total) as sum'))
            ->where('payment_status', 2)
            ->where(function ($status) {
                $status->where('delivery_status', 2)
                    ->orWhere('delivery_status', 3);
            })
            ->where('updated_at', 'like', '%' . Carbon::now()->format('Y-m') . '%')
            ->groupBy(DB::raw("Month(updated_at)"))
            ->pluck('sum');

        $dataPet = [];
        $namePet = [];
        $userPet = [];

        $petPro = OrderDetail::join('products', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->select('order_details.product_id', 'products.name as name', DB::raw('sum(order_details.quantity) as sum'), DB::raw('COUNT(order_id) as orderCount'))
            ->where('orders.payment_status', 2)
            ->where(function ($status) {
                $status->where('orders.delivery_status', 2)
                    ->orWhere('orders.delivery_status', 3);
            })
            ->where('order_details.product_type', 1)
            ->where('order_details.updated_at', 'like', '%' . Carbon::now()->format('Y-m') . '%')
            ->groupBy('order_details.product_id')
            ->orderBy('sum', 'desc')
            ->get();
            
        foreach ($petPro as $sum) {
            if ($sum->sum > 0) {
                array_push($dataPet, $sum->sum);
                array_push($namePet, $sum->name);
                array_push($userPet, $sum->orderCount);
            }
        }
        $dataAcc = [];
        $nameAcc = [];
        $userAcc = [];

        $accPro = OrderDetail::join('accessories', 'accessories.id', '=', 'order_details.product_id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->select('order_details.product_id', 'accessories.name as name', DB::raw('sum(order_details.quantity) as sum'), DB::raw('COUNT(order_id) as orderCount'))
            ->where('orders.payment_status', 2)
            ->where(function ($status) {
                $status->where('orders.delivery_status', 2)
                    ->orWhere('orders.delivery_status', 3);
            })
            ->where('order_details.product_type', 2)
            ->where('order_details.updated_at', 'like', '%' . Carbon::now()->format('Y-m') . '%')
            ->groupBy('order_details.product_id')
            ->orderBy('sum', 'desc')
            ->get();

        foreach ($accPro as $sum) {
            if ($sum->sum > 0) {
                array_push($dataAcc, $sum->sum);
                array_push($nameAcc, $sum->name);
                array_push($userAcc, $sum->orderCount);
            }
        }

        // Tổng số doanh thu được trong tháng
        $count_all_monthly_orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->where('delivery_status', 3)->where('payment_status', 2)->get();
        $doanh_thu = 0;
        $tong = 0;
        $totail = 0;
        $thue = 0;
        
        foreach ($count_all_monthly_orders as $value) {
            $cong_thue = 0;
            $orderDTax = OrderDetail::where('order_id', $value->id)->get();
            foreach ($orderDTax as $odt) {
                $cong_thue += $odt->price;
            }
            $thue += ($cong_thue * 10 / 100);
            $totail = $value->grand_total;
            $tong += $totail;
        }
        $doanh_thu = $tong - $thue;
        // Đếm số lượng tất cả đơn hàng
        $count_all_orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->get();
        // Đếm số lượng đơn hàng đang chờ xử lý
        $count_all_delivery_orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->where('delivery_status', 1)->count();
        // Đếm số lượng đơn hàng giao thành công
        $count_all_delivery_orders_success = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->where('delivery_status', 3)->count();
        // Đếm số lượng đơn hàng bị hủy trong tháng
        $count_all_canceled_orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->where('delivery_status', 4)->get();

        $review = Review::where('status', 1)->count();
        $orderDetail = OrderDetail::all();
        $orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->get();

        /**
         * Thống kê đơn hàng (S
         */
        $count = [];
        $data = [];
        for ($i=0; $i < 5; $i++) { 
            if ($i == 0) {
                $value = 'Đơn hàng đã hủy';
            }elseif ($i == 1) {
                $value = 'Đơn hàng đang chờ xử lý';
            }elseif ($i == 2) {
                $value = 'Đơn hàng đang giao';
            }elseif ($i == 3) {
                $value = 'Đơn hàng giao thành công';
            }else{
                $value = 'Đơn hàng bị hủy';
            }
            array_push($data, $value);
        }
        $date = 0;
        for ($i=0; $i < 5; $i++) { 
            foreach ($orders as $order) {
                if ($order->delivery_status == $i) {
                    $date ++;
                }
            }
            array_push($count, $date);
            $date = 0;
        }
        /**
         * Thống kê đơn hàng E)
         */

        $review = Review::where('status', 1)->count();
        $orderDetail = OrderDetail::all();

        return view('admin.dashboard.index', compact(
            'orderDetail', 'review',
            'doanh_thu',
            'count_all_orders',
            'count_all_delivery_orders',
            'count_all_delivery_orders_success',
            'count_all_canceled_orders',
            'data',
            'count',
            
            'dataPet',
            'namePet',
            'userPet',
            'dataAcc',
            'nameAcc',
            'userAcc',
            'userName',
            'userPhone',
            'countOrder',
            'sumOrder'
        ));
    }

    public function test() {
        $orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->where('delivery_status', 2)->orWhere('delivery_status', 3)->get();

        $users = User::all();

        // Tổng số doanh thu được trong tháng
        $count_all_monthly_orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->where('delivery_status', 3)->where('payment_status', 2)->get();
        $doanh_thu = 0;
        foreach ($count_all_monthly_orders as $key => $value) {
            $totail = 0;
            $money = OrderDetail::where('order_id', $value->id)->first();
            $totail = $money->price - $money->tax;
            $doanh_thu += $totail;
        }
        // Đếm số lượng tất cả đơn hàng
        $count_all_orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->get();
        // Đếm số lượng đơn hàng đang chờ xử lý
        $count_all_delivery_orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->where('delivery_status', 1)->count();
        // Đếm số lượng đơn hàng giao thành công
        $count_all_delivery_orders_success = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->where('delivery_status', 3)->count();
        // Đếm số lượng đơn hàng bị hủy trong tháng
        $count_all_canceled_orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->where('delivery_status', 4)->get();

        $review = Review::where('status', 1)->count();
        $orderDetail = OrderDetail::all();
        $orders = Order::where('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())->where('created_at', '<=', \Carbon\Carbon::now()->endOfMonth())->get();

        /**
         * Thống kê đơn hàng (S
         */
        $count = [];
        $data = [];
        for ($i=0; $i < 5; $i++) { 
            if ($i == 0) {
                $value = 'Đơn hàng đã hủy';
            }elseif ($i == 1) {
                $value = 'Đơn hàng đang chờ xử lý';
            }elseif ($i == 2) {
                $value = 'Đơn hàng đang giao';
            }elseif ($i == 3) {
                $value = 'Đơn hàng giao thành công';
            }else{
                $value = 'Đơn hàng bị hủy';
            }
            array_push($data, $value);
        }
        $date = 0;
        for ($i=0; $i < 5; $i++) { 
            foreach ($orders as $order) {
                if ($order->delivery_status == $i) {
                    $date ++;
                }
            }
            array_push($count, $date);
            $date = 0;
        }
        /**
         * Thống kê đơn hàng E)
         */

        // dd($data, $count);

        return view('admin.dashboard.test', compact(
            'orderDetail', 'review',
            'doanh_thu',
            'count_all_orders',
            'count_all_delivery_orders',
            'count_all_delivery_orders_success',
            'count_all_canceled_orders',
            'data',
            'count',
            'users',
            'orders'
        ));
        
        
    }
}
