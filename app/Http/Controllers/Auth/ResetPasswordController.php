<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordRequest;
use DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function getPassword($token) {
        $model = PasswordReset::where('token', $token)->get();
        $check_time = PasswordReset::where('token', $token)->first();
        $now = Carbon::now();
        if ($now->format('Y-m-d H') == $check_time->created_at->format('Y-m-d H')) {
            if ($now->format('i:s') <= $check_time->created_at->addMinutes(2)->format('i:s')) {
                return view('auth.password.reset', ['token' => $token]);
            }else{
                return redirect('/forgot-password')->with('message', 'Đường dẫn cập nhật mật khẩu này đã hết hạn. Vui lòng gửi lại Email yêu cầu!');
            }
        }else{
            return redirect('/forgot-password')->with('message', 'Đường dẫn cập nhật mật khẩu này đã hết hạn. Vui lòng gửi lại Email yêu cầu!');
        }
    }
 
    public function updatePassword(Request $request) {
    $resetP = PasswordReset::where('token', $request->token)->first();
    // dd($resetP->email);
    $request->validate([
        // 'email' => 'required|email|exists:users',
        'password' => 'required|string|min:6',
        'password_confirmation' => 'required|same:password',
    ],
    [
        // 'email.required' => "Hãy nhập vào địa chỉ Email!",
        // 'email.email' => "Email không đúng định dạng!",
        // 'email.exists' => "Không tìm thấy tài khoản!",
        'password.required' => "Hãy nhập vào mật khẩu!",
        'password.string' => "ss string",
        'password.min' => "Mật khẩu không được dưới 6 ký tự",
        'password_confirmation.required' => "Hãy nhập vào xác nhận mật khẩu!",
        'password_confirmation.same' => "Mật khẩu xác nhận không giống mật khẩu!"
    ]);

        $updatePassword = DB::table('password_resets')->where(['email' => $resetP->email, 'token' => $request->token])->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Vui lòng nhập vào tài khoản của bạn!');
        }
        $user = User::where('email', $resetP->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $resetP->email])->delete();
        return redirect('/login')->with('success', 'Mật khẩu của bạn đã được thay đổi!');
    }
}
