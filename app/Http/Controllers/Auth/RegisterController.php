<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(){
        return view('auth.register');
    }
    public function storeUser(Request $request){
        $users = User::all();
        $request->validate(
        [
            'name' => 'required|string|max:50|alpha',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:40',
            'cfpassword' => 'required|same:password|'
        ],
        [
            'name.required' => "Hãy nhập vào tên!",
            'name.string' => "Kiểm tra string name",
            'name.max' => "Tên không được quá 50 ký tự",
            'name.alpha' => "Tên không được chứa ký tự số",
            'email.required' => "Hãy nhập vào email",
            'email.string' => "Kiểm tra string email",
            'email.email' => "Không đúng định dạng email",
            'email.max' => "Email không được quá 255 ký tự",
            'email.unique' => "Email này đã được sử dụng",
            'password.required' => "Hãy nhập mật khẩu",
            'password.min' => "Mật khẩu phải hơn 6 ký tự",
            'password.max' => "Mật khẩu không quá 40 ký tự",
            'cfpassword.required' => "Hãy nhập xác nhận mật khẩu",
            'cfpassword.same' => "Mật khẩu xác nhận không giống mật khẩu"
        ]);
        
        $model = new User();
        $model->fill($request->all());
        $model->name = ucwords($request->name);
        $model->password = Hash::make($request->password);
        $model->save();

        return redirect('/login')->with('success', 'Tạo tài khoản thành công!');
    }
}
