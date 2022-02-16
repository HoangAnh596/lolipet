<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function username(Request $request)
    {
        $data = [
            'email' => strtolower($request->email),
            'password' => $request->password,
            'status' => 1
        ];

        if (Auth::attempt($data)) {
            $remember = $request->remember;
            if (!empty($remember)) {
                Auth::login(Auth::user()->id, true);
                return redirect(route('dashboard.index'));
            }
        } else {
            // false
        }
        return 'username';
    }
}