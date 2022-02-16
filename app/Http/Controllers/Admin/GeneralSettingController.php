<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Validator;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $model = GeneralSetting::find(1);
        // dd($model);
        if (!$model) {
            return redirect()->back();
        }
        return view('admin.generalSetting.index', compact('model'));
    }
    public function saveAdd(Request $request)
    {
        $model = GeneralSetting::find(1);
        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'phone.min' => 'Số điện thoại có độ dài nhỏ nhất là 10 ký tự',
            'phone.max' => 'Số điện thoại có độ dài lớn nhất là 11 ký tự',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'phone.required' => 'Hãy nhập vào số điện thoại',
            'email.required' => 'Hãy nhập vào email',
             'email.email' => 'Email không đúng định dạng',
            'uploadfile.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ảnh không được quá 2MB',
            'facebook.url' => "Đường dẫn không hợp lệ",
            'instagram.url' => "Đường dẫn không hợp lệ",
            'twitter.url' => "Đường dẫn không hợp lệ",
            'youtube.url' => "Đường dẫn không hợp lệ",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'facebook' => 'nullable|url',
                'instagram' => 'nullable|url',
                'twitter' => 'nullable|url',
                'youtube' => 'nullable|url',
                'phone' => [
                    'required',
                    'min:10',
                    'max:11',
                    'regex:/^(09|03|07|08|05)[0-9]{8,9}$/'
                    //nên để regex trong mảng
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('dashboard.index')]);
        } else {
            $model->fill($request->all());

            if ($request->has('uploadfile')) {
                $model->logo = $request->file('uploadfile')->storeAs('uploads/logo/', uniqid() . '-' . $request->uploadfile->getClientOriginalName());
                $model->save();
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('dashboard.index'), 'message' => 'Sửa thông tin thành công']);
    }
}