@section('title', 'Chi tiết bài viết')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/blogDetail.css')}}">
@endsection
<!-- content -->
<section class="detail-blog">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <a href="{{route('client.blog.index')}}">Bài viết</a>
        <span>{{$blog->title}}</span>
    </div>
    <h1 id="heading">{{$blog->title}}</h1>
    <div class="blog-container">
        <div class="blog-description">
            <!-- <h1 class="title">{{$blog->title}}</h1> -->
            <div class="blog-extra">
                <ul>
                    <li>
                        <i class="far fa-user"></i>
                        <span>Tác giả: </span>
                        <strong class="author">{{$blog->user->name}}</strong>
                    </li>
                    <li>
                        <i class="far fa-calendar-alt"></i>
                        <strong class="author">{{$blog->created_at->diffForHumans()}}</strong>
                    </li>
                </ul>
            </div>
            <div class="content">
                {!!$blog->content!!}
            </div>
            <!-- <div class="customer_reviews">
                <h2>Đánh giá từ khách hàng</h2>
                <div class="container_customer_review">
                    <div class="see_review">
                        <div class="totail_rating">
                            <span class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </span>
                            <span>Rating: 4.8 (29 đánh giá)</span>
                        </div>
                        <div class="content_review">
                            <div class="box-review">
                                <div class="calendar">
                                    <span>30/2</span>
                                    <span>2020</span>
                                </div>
                                <div class="content">
                                    <div class="title">Great</div>
                                    <span class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </span>
                                    <div class="review_body">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. At, ad. Vel earum temporibus aut suscipit in accusantium consequatur pariatur! Esse rerum modi itaque ipsam reprehenderit recusandae sunt deleniti accusamus quisquam.
                                    </div>
                                    <div class="review_author">
                                        Mạnh Hùng
                                    </div>
                                </div>
                            </div>
                            <div class="box-review">
                                <div class="calendar">
                                    <span>22/2</span>
                                    <span>2020</span>
                                </div>
                                <div class="content">
                                    <div class="title">Great</div>
                                    <span class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </span>
                                    <div class="review_body">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. At, ad. Vel earum temporibus aut suscipit in accusantium consequatur pariatur! Esse rerum modi itaque ipsam reprehenderit recusandae sunt deleniti accusamus quisquam.
                                    </div>
                                    <div class="review_author">
                                        Mạnh Hùng
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form_review">
                        <h3>Gửi đánh giá của bạn</h3>
                        <form action="">
                            <div class="box">
                                <div class="col">
                                    <input type="text" placeholder="Name" name="name">
                                </div>
                            </div>
                            <div class="box">
                                <div class="col">
                                    <input type="text" placeholder="Email" name="email">
                                </div>
                            </div>
                            <div class="box">
                                <div class="col">
                                    <input type="text" placeholder="Review Title" name="title">
                                </div>
                            </div>
                            <div class="box">
                                <div class="col-star">
                                    <label for="">Đánh giá:</label>
                                    <span class="star-widget">
                                        <input type="radio" value="5" name="rating" id="rate-5">
                                        <label for="rate-5" class="fas fa-star"></label>
                                        <input type="radio" value="4" name="rating" id="rate-4">
                                        <label for="rate-4" class="fas fa-star"></label>
                                        <input type="radio" value="3" name="rating" id="rate-3">
                                        <label for="rate-3" class="fas fa-star"></label>
                                        <input type="radio" value="2" name="rating" id="rate-2">
                                        <label for="rate-2" class="fas fa-star"></label>
                                        <input type="radio" value="1" name="rating" id="rate-1">
                                        <label for="rate-1" class="fas fa-star"></label>
                                    </span>
                                    <div class="clear-both"></div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="col">
                                    <textarea name="content" placeholder="Review" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="box-last">
                                <button>Gửi đánh giá của bạn</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>
<!-- scroll to top -->
@endsection
