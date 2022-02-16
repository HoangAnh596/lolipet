<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $uploadImg = $file->store('images', 'public', uniqid() . '-' . $request->file->getClientOriginalName());
        return json_encode(['location' => "/storage/$uploadImg"]);
    }
}