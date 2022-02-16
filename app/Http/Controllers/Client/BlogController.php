<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\GeneralSetting;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = 6;
        $searchData = $request->except('page');

        if (count($request->all()) == 0) {
            // Lấy ra danh sách sản phẩm & phân trang cho nó
            $blog = Blog::where('status', 1)->orderBy('created_at', 'DESC')->paginate($pagesize);
        } else {
            $blogQuery = Blog::where('status', 1)->where('title', 'like', "%" . $request->keyword . "%");
            $blog = $blogQuery->orderBy('created_at', 'DESC')->paginate($pagesize)->appends($searchData);
        }

        $generalSetting = GeneralSetting::first();

        return view('client.blog.index', [
            'blog' => $blog,
            'searchData' => $searchData,
            'generalSetting' => $generalSetting
        ]);
    }

    public function detail($id, Request $request)
    {
        $blog = Blog::find($id);
        $blog = Blog::where('slug', $id)->first();
        $blog->load('blogCategory');

        $blogCategory = BlogCategory::all();
        $generalSetting = GeneralSetting::first();
        return view('client.blog.detail', compact('blog', 'blogCategory', 'generalSetting'));
    }
}