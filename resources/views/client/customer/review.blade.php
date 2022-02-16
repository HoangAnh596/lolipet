@section('title', 'Đánh giá của tôi')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/account_info.css')}}">
@endsection
	<!-- content -->
<section class="account-info">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <span>Lịch sử nhận xét</span>
    </div>
    <div class="account_info_container">
        @include('client.customer.nav_bar_customer')
        <div class="content_page">
            <table class="greenTable">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Rating</th>
                        <th>Nội dung đánh giá</th>
                        <th>Thời gian</th>
                        <td>Lực chọn</td>
                    </tr>
                </thead>
                <tbody class="list-overflow">
                    @foreach($review as $rv)
                        @foreach($product as $pro)
                            @if($rv->product_id == $pro->id)
                            <tr>
                                <td>
                                    <a href="{{route('client.product.detail', ['id' => $rv->product->slug])}}">
                                        <img src="{{asset( 'storage/' . $rv->product->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" width="100">
                                    </a>
                                </td>
                                <td style="min-width: 103px;">
                                    <span class="star">
                                       @for($count=1; $count<=5; $count++)
                                            @if($count <= $pro->review->rating)
                                                <i class="fas fa-star rating"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </span>
                                </td>
                                <td style="min-width: 260px;">{{$rv->comment}}</td>
                                <td style="min-width: 75px;">{{$rv->created_at->diffForHumans()}}</td>
                                <td>
                                    <div class="flex_R">
                                        <a href="{{route('client.product.detail', ['id' => $rv->product->slug])}}" class="edit-review">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="{{route('deleteReview', ['id' => $rv->id])}}" onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')" class="delete-review">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <div class="paging">
                {{ $review->links('vendor.pagination.custom_blue') }}
            </div>
        </div>
    </div>
</section>
	<!-- content -->
@endsection