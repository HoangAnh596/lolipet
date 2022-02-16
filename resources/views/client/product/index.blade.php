@section('title', 'Sản phẩm')
@extends('layouts.client.main')
@section('content')
<!-- content -->
<!-- section product -->
<section class="products">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <span>Thú cưng</span>
    </div>
    <h1 id="heading">Thú cưng</h1>
    <div class="product-top">
        <form action="{{route('client.product.index')}}" method="GET">
            <div class="double">
                <div class="form-item">
                    <!-- <label for="">Danh mục</label> -->
                    <select name="cate_id" id="">
                        <option value="">Tất cả danh mục</option>
                        @foreach($category as $cate)
                            @if($cate->category_type_id == 1)
                            <option @if(isset($searchData['cate_id']) &&  $searchData['cate_id'] == $cate->id) selected @endif value="{{$cate->id}}">{{$cate->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-item">
                    <!-- <label for="">Sắp xếp theo</label> -->
                    <select name="order_by" id="">
                        <option value="0">Mặc định</option>
                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 1) selected @endif value="1">Giá tăng dần</option>
                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 2) selected @endif value="2">Giá giảm dần</option>
                        <option @if(isset($searchData['order_by']) &&  $searchData['order_by'] == 3) selected @endif value="3">Sản phẩm mới nhất</option>
                    </select>
                </div>
            </div>
            <div class="clear-both"></div>
            <button type="submit">Lọc sản phẩm</button>
            <div class="clear-both"></div>
        </form>
    </div>
    <div class="product-container">
        @foreach($product as $p)
        <div class="product-item">
            <div class="item-top">
                <div class="product-lable">
                </div>
                <div class="product-thumbnail">
                    <a href="{{route('client.product.detail', ['id' => $p->slug])}}">
                        <img src="{{asset( 'storage/' . $p->image)}}"
                            alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                </div>
                <div class="product-extra">
                    <form action="{{route('saveCart')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id_hidden" value="{{$p->id}}">
                        <input type="hidden" name="product_type" value="1">
                        @if($p->discount_start_date <= $carbon_now && $p->discount_end_date >= $carbon_now || $p->discount_start_date == '' || $p->discount_end_date == '')
                            <input type="hidden" name="discount_price" value="{{$p->discount}}">
                        @else
                            <input type="hidden" name="discount_price" value="0">
                        @endif
                        <input type="hidden" name="category_id" value="{{$p->category_id}}">
                        <input type="hidden" name="quantity" value="1">
                        @if($p->quantity > 0)
                            <button type="submit" class="btn-buyNow">Thêm vào giỏ hàng</button>
                        @else
                            <button type="button" class="btn-buyNow" disable>Hết hàng</button>
                        @endif
                    </form>
                </div>
            </div>
            <div class="item-bottom">
                <div class="product-info">
                    <a href="{{route('client.product.detail', ['id' => $p->slug])}}" class="name">{{$p->name}}</a>
                    @if($p->discount == '')
                    <span class="price">{{number_format($p->price)}} VND</span>
                    @else
                        @if($p->discount_start_date <= $carbon_now && $p->discount_end_date >= $carbon_now || $p->discount_start_date == '' || $p->discount_end_date == '')
                            <span class="discount">{{number_format($p->price)}} VND</span>
                            <span class="price">
                                <?php
                                    echo number_format($p->price - $p->discount).' VND';
                                ?>
                            </span>
                        @else
                            <span class="price">{{number_format($p->price)}} VND</span>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if(empty(count($product)))
        <div class="product-top" style="text-align:center;">
            <h3 style="font-size: 2rem; font-family: 'Coiny', cursive; color: #333333; padding: 1.4rem 0; text-transform: uppercase;">Không tìm thấy kết quả</h3>
            <img src="{{ asset('client-theme/images/not-found-cat.svg')}}" alt="Ảnh hiển thị bị lỗi!" id=featured>
        </div>
    @endif
    <div class="paging">
        {{ $product->links('vendor.pagination.custom') }}
    </div>
</section>
	<!-- content -->
@endsection
