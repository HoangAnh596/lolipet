<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\Category;
use App\Models\DiscountType;
use App\Models\Breed;
use App\Models\Gender;
use App\Models\Slide;
use App\Models\Age;
use App\Models\ProductGallery;
use App\Models\Review;
use App\Models\Blog;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class HomeController extends Controller
{
    public function home(Request $request){
        $carbon_now = Carbon::now();
        $category = Category::all();
        $product = Product::paginate(5);
        $accessory = Accessory::paginate(5);
        $gender = Gender::all();
        $breed = Breed::all();
        $slide = Slide::all();
        $blog = Blog::where('status', 1)->orderBy('created_at', 'DESC')->paginate(2);
        $generalSetting = GeneralSetting::first();
        
        return view('client.home', [
            'category' => $category,
            'product' => $product,
            'accessory' => $accessory,
            'gender' => $gender,
            'breed' => $breed,
            'slide' => $slide,
            'blog' => $blog,
            'carbon_now' => $carbon_now,
            'generalSetting' => $generalSetting
        ]);
    }

    public function search(Request $request)
    {
        $carbon_now = Carbon::now();
        $slide = Slide::all();
        $generalSetting = GeneralSetting::first();
        $category = Category::all();
        $searchData = $request->except('page');
        switch ($request->search_type) {
            case '1':
                if ($request->search) {
                    $order = Order::where('code', $request->search )->first();
                } else {
                    $order = '';
                }
                
                if(!empty($order)){
                    return view('client.search.search', [
                        'order' => $order,
                        'slide' => $slide,
                        'generalSetting' => $generalSetting,
                        'category' => $category,
                        'searchData' => $searchData
                    ]);
                }else{
                    return redirect()->back()->with('danger', "Không tìm thấy mã đơn hàng này. Vui lòng kiểm tra lại!");
                }
                break;
            case '2':
                if ($request->search) {
                    $product = Product::where('name', 'like', '%' . $request->search . '%')->paginate(12)->appends($searchData);
                } else {
                    $product = '';
                }
                
                if(!empty($product)){
                    return view('client.product.index', [
                        'product' => $product,
                        'slide' => $slide,
                        'generalSetting' => $generalSetting,
                        'category' => $category,
                        'carbon_now' => $carbon_now,
                        'searchData' => $searchData
                    ]);
                }else{
                    return redirect()->back()->with('danger', "Không tìm thấy sản phẩm này. Vui lòng kiểm tra lại!");
                }
                break;
            case '3':
                if ($request->search) {
                    $accessory = Accessory::where('name', 'like', '%' . $request->search . '%')->paginate(12)->appends($searchData);
                } else {
                    $accessory = '';
                }
                
                if(!empty($accessory)){
                    return view('client.accessory.index', [
                        'accessory' => $accessory,
                        'slide' => $slide,
                        'generalSetting' => $generalSetting,
                        'category' => $category,
                        'carbon_now' => $carbon_now,
                        'searchData' => $searchData
                    ]);
                }else{
                    return redirect()->back()->with('danger', "Không tìm thấy phụ kiện này. Vui lòng kiểm tra lại!");
                }
                break;
            case '4':
                if ($request->search) {
                    $blog = Blog::where('title', 'like', '%' . $request->search . '%')->paginate(8)->appends($searchData);
                } else {
                    $blog = '';
                }
                
                if(!empty($blog)){
                    return view('client.blog.index', [
                    'blog' => $blog,
                    'slide' => $slide,
                    'generalSetting' => $generalSetting,
                    'category' => $category,
                    'searchData' => $searchData
                ]);
                }else{
                    return redirect()->back()->with('danger', "Không tìm thấy bài viết này. Vui lòng kiểm tra lại!");
                }
                break;
        }
    }
}