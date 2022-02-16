<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite as FacadesSocialite;

class AuthController extends Controller
{
    public function loginForm(Request $request)
    {
        if (Auth::check()) {
            return redirect()->back()->with('danger', "Vui lòng đăng xuất tài khoản trước khi vào trang này!");
        } else {
            return view('auth.login');
        }
    }

    public function postLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // thực hiện validate bằng $request
        $request->validate(
            [
                'email' => 'required|email|exists:users',
                'password' => 'required'
            ],
            [
                'email.required' => "Hãy nhập vào tài khoản!",
                'email.email' => "Email không đúng định dạng!",
                'email.exists' => "Không tìm thấy tài khoản!",
                'password.required' => "Hãy nhập vào mật khẩu!"
            ]
        );

        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 0])) {
            Auth::logout();
            return redirect()->back()->with('msg', "Tài khoản của bạn đang bị khóa, liên hệ Huy Phan để mở!");
        } elseif (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
            return redirect(route('client.home'));
        } else {
            return back()->withInput()->with('msg', "Mật khẩu không chính xác. Vui lòng thử lại!");
        }
    }

    public function redirectToGoogle()
    {
        return FacadesSocialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = FacadesSocialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('login');
        }

        if (explode('@', $user->email)[1] !== 'gmail.com' && explode('@', $user->email)[1] !== 'fpt.edu.vn') {
            return redirect('login');
        }
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            auth()->login($existingUser, true);
        } else {
            $newUser                    = new User;
            $newUser->google_id         = $user->id;
            $newUser->name              = $user->name;
            $newUser->email             = $user->email;
            $newUser->avatar            = $user->avatar;
            $newUser->avatar_original   = $user->avatar_original;
            $newUser->save();

            auth()->login($newUser, true);
        }

        return redirect('/');
    }

    public function changePassword(Request $request)
    {
        return view('auth.change-password');
    }

    public function saveChangePassword(Request $request)
    {
        $request->validate(
            [
                'currentpassword' => 'required',
                'newpassword' => 'required',
                'cfpassword' => 'required|same:newpassword|'
            ],
            [
                'currentpassword.required' => "Hãy nhập mật khẩu",
                'newpassword.required' => "Hãy nhập mật khẩu mới",
                'cfpassword.required' => "Hãy nhập xác nhận mật khẩu",
                'cfpassword.same' => "Mật khẩu xác nhận không giống mật khẩu"
            ]
        );

        if (!(Hash::check($request->get('currentpassword'), Auth::user()->password))) {
            return redirect()->back()->with("error", "Mật khẩu hiện tại bạn nhập không đúng. Vui lòng thử lại!")->withInput();
        }
        if (strcmp($request->get('currentpassword'), $request->get('newpassword')) == 0) {
            return redirect()->back()->with("error", "Mật khẩu mới không được giống với mật khẩu hiện tại!")->withInput();
        }
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->newpassword);
        $user->save();

        // return redirect()->back()->with("success","Mật khẩu của bạn đã được thay đổi !")->withInput();
        return Redirect::to("tai-khoan/")->with('success', "Mật khẩu của bạn đã được thay đổi.")->withInput();
    }


    /*
     * 28/29/21
    */

    // public function regeister(Request $request) {
    //     $fields = $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|string|unique:users,email',
    //         'password' => 'required|string|confirmed'
    //     ]);

    //     $user = User::create([
    //         'name' => $fields['name'],
    //         'email' => $fields['email'],
    //         'password' => bcrypt($fields['password'])
    //     ]);
    //     $token = $user->createToken('myapptoken')->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];
    //     return response($response, 201);
    // }

    // public function login(Request $request){
    //     $fields = $request->validate([
    //         'email' => 'required|string',
    //         'password' => 'required|string'
    //     ]);
    //     // Check email
    //     $user = User::where('email', $fields['email'])->first();

    //     // Check password
    //     if (!$user || !Hash::check($fields['password'], $user->password)) {
    //         return response([
    //             'message' => 'Bad creds'
    //         ], 401);
    //     }

    //     $token = $user->createToken('myapptoken')->plainTextToken;

    //     $response = [
    //         'user' => $user,
    //         'token' => $token
    //     ];
    //     return response($response, 201);
    // }

    // public function logout(Request $request){
    //     auth()->user()->tokens()->delete();
    //     return [
    //         'message' => 'Say bye bye'
    //     ];
    // }
}