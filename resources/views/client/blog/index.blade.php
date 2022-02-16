@section('title', 'Bài viết')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/blog.css')}}">
@endsection
<!-- content -->
<!-- section product -->
<section class="blogs">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <span>Bài viết</span>
    </div>
    <h1 id="heading">Bài viết</h1>
    <div class="blog-container">
        @foreach($blog as $value)
        <div class="blog-item">
            <div class="item-top">
                <div class="thumbnail">
                    <a href="{{route('client.blog.detail', ['id' => $value->slug])}}">
                        <img src="{{asset( 'storage/' . $value->image)}}"
                            alt="Bài viết này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                    </a>
                </div>
                <div class="link_blog">
                    <a href="{{route('client.blog.detail', ['id' => $value->slug])}}" class="btn-gray">Chi tiết</a>
                </div>
            </div>
            <div class="item-bottom">
                <h1 class="title">{{$value->title}}</h1>
                <div class="item-extra">
                    <ul>
                        <li>
                            <i class="fas fa-user"></i>
                            <span>Tác giả: </span>
                            <span class="author">{{$value->user->name}}</span>
                        </li>
                        <li class="middle">
                            <i class="far fa-calendar-alt"></i>
                            <span class="author">{{$value->created_at->diffForHumans()}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if(empty(count($blog)))
        <div class="product-top" style="text-align:center;">
            <h3 style="font-size: 2rem; font-family: 'Coiny', cursive; color: #333333; padding: 1.4rem 0; text-transform: uppercase;">Không tìm thấy kết quả</h3>
            <img src="{{ asset('client-theme/images/not-found-cat.svg')}}" alt="Ảnh hiển thị bị lỗi!" id=featured>
        </div>
    @endif
    <div class="paging">
        {{ $blog->links('vendor.pagination.custom') }}
    </div>
</section>
<!-- scroll to top -->
@endsection
