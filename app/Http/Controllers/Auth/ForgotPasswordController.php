<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function getEmail()
    {
        return view('auth.password.email');
        //    return view('auth.forgot-password');
    }

    public function postEmail(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users',
            ],
            [
                'email.required' => "Hãy nhập vào địa chỉ Email!",
                'email.email' => "Email không đúng định dạng!",
                'email.exists' => "Không tìm thấy tài khoản!"
            ]
        );

        $token = Str::random(60);

        $PasswordReset = PasswordReset::where('email', $request->email)->first();
        if (!empty($PasswordReset)) {
            PasswordReset::where(['email' => $request->email])->delete();
        }

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        $user = User::where('email', $request->email)->first();
        $name_client = $user->name;

        $mailData = [
            'name_client' => $name_client,
            'token' => $token
        ];
        $toMail = $request->email;
        Mail::to($toMail)->send(new MailForgotPassword($mailData));

        return back()->with('message', 'Chúng tôi đã sử dụng email liên kết để đặt lại mặt khẩu của bạn. Vui lòng kiểm tra email!');
    }
}