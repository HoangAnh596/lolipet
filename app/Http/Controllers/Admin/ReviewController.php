<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Accessory;
use App\Models\Product;
use App\Models\User;

class ReviewController extends Controller
{
    public function index(Request $request){
        $pagesize = 5;
        $searchData = $request->except('page');
        
        if(count($request->all()) == 0){
            $reviews = Review::orderBy('created_at', 'DESC')->paginate($pagesize);
        }else{
            $reviewQuery = Review::orderBy('created_at', 'DESC')->where('name', 'like', "%" .$request->keyword . "%");
            if($request->has('category_id') && $request->category_id != ""){
                $reviewQuery = $reviewQuery->orderBy('created_at', 'DESC')->where('product_type', $request->category_id);
            }
            if($request->has('review_rating') && $request->review_rating != ""){
                $reviewQuery = $reviewQuery->orderBy('created_at', 'DESC')->where('rating', $request->review_rating);
            }
            $reviews = $reviewQuery->paginate($pagesize)->appends($searchData);
        }

        $product = Product::all();
        $user = User::all();
        $accessory = Accessory::all();

        // trả về cho người dùng 1 giao diện + dữ liệu reviews vừa lấy đc 
        return view('admin.review.index', [
            'reviews' => $reviews, 
            'product' => $product,
            'users' => $user,
            'accessory' => $accessory,
            'searchData' => $searchData
        ]);
    }

    public function updateStatus($id){
        $review = Review::find($id);
        if($review->status == 1){
            $review->status = 0;
        }else{
            $review->status = 1;
        }
        $review->save();

        return redirect(route('list.review.index'));
    }
}
