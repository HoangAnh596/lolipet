<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Coupons;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

class CouponController extends Controller
{
    public function usDiscount(Request $request){
        $cart = Cart::content();
        $code_discount = $request->code_discount;
        $coupon = Coupons::where('code', $code_discount)->first();
        $now = Carbon::now();
        // dd($coupon);
        if (!empty($coupon)) {
            if($coupon->start_date == '' && $coupon->end_date == ''){
                if ($coupon->discount >= Cart::total(0,',','')) {
                    return redirect()->back()->with('danger', "Không thể sử dụng giá trị giảm giá cao hơn đơn hàng.");
                }
                    session()->put('coupon', [
                        'name' => $code_discount,
                        'discount' => $coupon->discount(Cart::subtotal(0,',','')),
                        'type' => $coupon->discount_type
                    ]);
                    $dc = session()->get('coupon')['discount'];
                return redirect()->back()->with('success', "Bạn đã được giảm " . number_format($dc,0,',','.') . ' VND');
            }elseif ($coupon->start_date <= $now->format('Y-m-d h:m:s') && $coupon->end_date >= $now->format('Y-m-d h:m:s')) {
                if ($coupon->discount >= Cart::total(0,',','')) {
                    return redirect()->back()->with('danger', "Không thể sử dụng giá trị giảm giá cao hơn đơn hàng.");
                }
                    session()->put('coupon', [
                        'name' => $code_discount,
                        'discount' => $coupon->discount(Cart::subtotal(0,',','')),
                        'type' => $coupon->discount_type
                    ]);
                    $dc = session()->get('coupon')['discount'];
                return redirect()->back()->with('success', "Bạn đã được giảm " . number_format($dc,0,',','.') . ' VND');
            }else{
                return redirect()->back()->with('danger', "Mã giảm giá đã hết hạn sử dụng.");
            }
        }else{
            return redirect()->back()->with('danger', "Mã giảm giá không tồn tại");
        }
    }

    public function destroy(Request $request){
        session()->forget('coupon');
        return redirect()->back()->with('success', "Đã xóa giảm giá");
    }
}
