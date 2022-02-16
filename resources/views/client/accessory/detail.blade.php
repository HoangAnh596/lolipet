@section('title', 'Thông tin phụ kiện')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/productDetail.css')}}">
@endsection
<!-- content -->
<!-- section detail product -->
<section class="detail-products">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <a href="{{route('client.accessory.index')}}">Phụ kiện</a>
        <span>{{$model->name}}</span>
    </div>
    <div class="product-container">
        <div class="product-item-image">
            <div class="main-image" id="main-image">
                <img src="{{asset( 'storage/' . $model->image)}}"
                    alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" id=featured>
            </div>
            <div class="thumbnails">
                <div id="slide_prev_thumbnail"><i class="fas fa-chevron-left"></i></div>
                <div class="slide-thumbnails" id="slide-thumbnails">
                    <div>
                        <img src="{{asset( 'storage/' . $model->image)}}" class="thumbnail_gallery_product active"
                            alt="error">
                    </div>
                    @foreach ($model->galleries as $gl)
                    <div><img src="{{asset('storage/' . $gl->image_url)}}" class="thumbnail_gallery_product"
                            alt="error"></div>
                    @endforeach
                </div>
                <div id="slide_next_thumbnail"><i class="fas fa-chevron-right"></i></div>
            </div>
        </div>
        <div class="product-item-description">
            <h1 class="name">{{$model->name}}</h1>
            <div class="product-extra-icons">
                <ul>
                    <li class="product-extra-star">
                        <span class="star">
                            @for($count=1; $count<=5; $count++) @if($count <=$rating) <i class="fas fa-star rating"></i>
                                @elseif($countReview == 0)
                                <i class="fas fa-star rating"></i>
                                @else
                                <i class="far fa-star"></i>
                                @endif
                                @endfor
                            </span>
                        </li>
                        <li>
                            <i class="far fa-comments"></i>
                            <span class="number">{{$countReview}}</span>
                            <span>Đánh giá</span>
                        </li>
                        <li>
                            <span class="number">1532</span>
                            <span>Đã bán</span>
                        </li>
                    </ul>
                </div>
                <div class="item-extra">
                    <h6>Giá bán</h6>
                    @if($model->discount == '')
                        <span class="price">{{number_format($model->price)}} VND</span>
                    @else
                        @if($model->discount_start_date <= $carbon_now && $model->discount_end_date >= $carbon_now || $model->discount_start_date == '' || $model->discount_end_date == '')
                            <span class="discount">{{number_format($model->price)}} VND</span>
                            <span class="price">
                                <?php
                                    echo number_format($model->price - $model->discount).' VND';
                                ?>
                            </span>
                        @else
                            <span class="price">{{number_format($model->price)}} VND</span>
                        @endif
                    @endif
                </div>
                <div class="item-extra">
                    <h6>Danh mục</h6>
                    <span class="box">{{$model->category->name}}</span>
                </div>
            <form action="{{route('saveCart')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id_hidden" value="{{$model->id}}">
                @if($model->discount_start_date <= $carbon_now && $model->discount_end_date >= $carbon_now || $model->discount_start_date == '' || $model->discount_end_date == '')
                    <input type="hidden" name="discount_price" value="{{$model->discount}}">
                @else
                    <input type="hidden" name="discount_price" value="0">
                @endif
                <input type="hidden" name="category_id" value="{{$model->category_id}}">
                <div class="item-extra">
                    <h6>Số lượng</h6>
                    <div class="quantity">
                        <input class="minus @if($model->quantity > 0) is-form @else is-form-none @endif" type="button"
                            value="-">
                        <input aria-label="quantity" class="input-qty" name="quantity" type="number"
                            @if($model->quantity > 0)
                        max="{{$model->quantity}}" min="1" value="1"
                        @else
                        value="0" disabled
                        @endif >
                        <input type="hidden" name="maxQuantity" value="{{$model->quantity}}">
                        <input class="plus @if($model->quantity > 0) is-form @else is-form-none @endif" type="button"
                            value="+">
                    </div>
                    <span style="padding-left: 2rem;color: var(--text-color);font-size: 1.5rem;">
                        @if($model->quantity > 0)
                        {{$model->quantity}} sản phẩm có sẵn
                        @else
                        Hết hàng
                        @endif
                    </span>
                </div>
                <?php
                $content = Cart::content();
                ?>
                <input type="hidden" name="product_type" value="2">
                @if($model->quantity > 0)
                    <button type="submit" class="btn">Thêm vào giỏ hàng</button>
                @endif
            </form>
        </div>
    </div>
</section>
<section class="product_description">
    <h2>Mô tả sản phẩm</h2>
    <div class="description">
        {{$model->description}}
    </div>
</section>
<section class="review_custom">
    <div class="customer_reviews">
        <h2>Đánh giá từ khách hàng</h2>
        <div class="container_customer_review">
            <div class="see_review">
                <div class="totail_rating">
                    <span class="rating">
                        @for($count=1; $count<=5; $count++)
                            @if($count <= $rating)
                                <i class="fas fa-star rating"></i>
                            @elseif($countReview == 0)
                                <i class="fas fa-star rating"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </span>
                    <span>Rating: {{$rating}} ({{$countReview}} đánh giá)</span>
                </div>
                <div class="content_review">
                    @foreach($review as $rv)
                        @if($rv->product_id == $model->id)
                        <div class="box-review">
                            <div class="calendar">
                                <span>
                                    {{date('d/m', strtotime($rv->created_at))}}
                                </span>
                                <span>{{date('Y', strtotime($rv->created_at))}}</span>
                            </div>
                            <div class="content">
                                <span class="rating">
                                    @for($count=1; $count<=5; $count++)
                                        @if($count <= $rv->rating)
                                            <i class="fas fa-star rating"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </span>
                                <div class="review_author">
                                    {{$rv->name}}
                                </div>
                                <div class="review_body">
                                    {{$rv->comment}}
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @if(empty(count($review)))
                    <div class="box-review">
                            <div class="content">
                                <div class="review_author">
                                    Sản phẩm này chưa có Review từ khách hàng!
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form_review">
                @if(!empty($check_rv->rating) && Auth::check())
                <h3>Cập nhật đánh giá của bạn</h3>
                @else
                <h3>Gửi đánh giá của bạn</h3>
                @endif
                <span class="note_comment">(Bạn có thể dùng email đã mua hàng để comment nếu không có tài khoản!)</span>
                <form action="{{route('client.accessory.post_review')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_type" value="2">
                    <input type="hidden" name="product_id" value="{{$model->id}}">
                    <div class="box">
                        <div class="col">
                            @if(Auth::check())
                            <input type="text" name="name" placeholder="Name" value="{{Auth::user()->name}}">
                            @else
                            <input type="text" name="name"  placeholder="Name"value="{{old('name')}}">
                            @endif
                        </div>
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="box">
                        <div class="col">
                            @if(Auth::check())
                            <input type="text" name="email" placeholder="Email" value="{{Auth::user()->email}}">
                            @else
                            <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
                            @endif
                        </div>
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="box">
                    <div class="col col-star">
                            <label for="">Đánh giá:</label>
                            @if(!empty($check_rv->rating) && Auth::check())
                            <span class="star-widget">
                                <input type="radio" value="5" name="rating" id="rate-5" @if( $check_rv->rating == 5 ) checked  @endif>
                                <label for="rate-5" class="fas fa-star"></label>
                                <input type="radio" value="4" name="rating" id="rate-4" @if( $check_rv->rating == 4 ) checked  @endif>
                                <label for="rate-4" class="fas fa-star"></label>
                                <input type="radio" value="3" name="rating" id="rate-3" @if( $check_rv->rating == 3 ) checked  @endif>
                                <label for="rate-3" class="fas fa-star"></label>
                                <input type="radio" value="2" name="rating" id="rate-2" @if( $check_rv->rating == 2 ) checked  @endif>
                                <label for="rate-2" class="fas fa-star"></label>
                                <input type="radio" value="1" name="rating" id="rate-1" @if( $check_rv->rating == 1 ) checked  @endif>
                                <label for="rate-1" class="fas fa-star"></label>
                            </span>
                            @else
                            <span class="star-widget">
                                <input type="radio" value="5" name="rating" id="rate-5" @if( old('rating') == 5 ) checked  @endif>
                                <label for="rate-5" class="fas fa-star"></label>
                                <input type="radio" value="4" name="rating" id="rate-4" @if( old('rating') == 4 ) checked  @endif>
                                <label for="rate-4" class="fas fa-star"></label>
                                <input type="radio" value="3" name="rating" id="rate-3" @if( old('rating') == 3 ) checked  @endif>
                                <label for="rate-3" class="fas fa-star"></label>
                                <input type="radio" value="2" name="rating" id="rate-2" @if( old('rating') == 2 ) checked  @endif>
                                <label for="rate-2" class="fas fa-star"></label>
                                <input type="radio" value="1" name="rating" id="rate-1" @if( old('rating') == 1 ) checked  @endif>
                                <label for="rate-1" class="fas fa-star"></label>
                            </span>
                            @endif
                            <div class="clear-both"></div>
                        </div>
                        @error('rating') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="box">
                        @if(!empty($check_rv->rating) && Auth::check())
                        <div class="col">
                            <textarea name="comment" placeholder="Review" cols="30" rows="10">{{ $check_rv->comment }}</textarea>
                        </div>
                        @else
                        <div class="col">
                            <textarea name="comment" placeholder="Review" cols="30" rows="10">{{ old('comment') }}</textarea>
                        </div>
                        @endif
                        @error('comment') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="box-last">
                    @if(!empty($check_rv->rating) && Auth::check())
                        <button type="submit">Cập nhật đánh giá của bạn</button>
                    @else
                        <button type="submit">Gửi đánh giá của bạn</button>
                    @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="product_slide" id="product">
    <h1 class="heading"> Sản Phẩm Tương Tự </h1>
    <div class="swiper product-slider product-container">
        <div class="swiper-wrapper">
            @foreach($product_slide as $pro_S)
            <div class="swiper-slide product-item">
                <div class="item-lable">
                    <div class="product-thumbnail">
                        <a href="{{route('client.product.detail', ['id' => $pro_S->slug])}}">
                            <img src="{{asset( 'storage/' . $pro_S->image)}}"
                                alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                        </a>
                    </div>
                    <div class="product-info">
                        <a href="{{route('client.product.detail', ['id' => $pro_S->slug])}}" class="name">
                            {{$pro_S->name}}
                        </a>
                        @if($pro_S->discount == '')
                        <span class="price">{{number_format($pro_S->price)}} VND</span>
                        @else
                            @if($pro_S->discount_start_date <= $carbon_now && $pro_S->discount_end_date >= $carbon_now || $pro_S->discount_start_date == '' || $pro_S->discount_end_date == '')
                                <span class="discount">{{number_format($pro_S->price)}} VND</span>
                                <span class="price">
                                    <?php
                                        echo number_format($pro_S->price - $pro_S->discount).' VND';
                                    ?>
                                </span>
                            @else
                                <span class="price">{{number_format($pro_S->price)}} VND</span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection @section('pagejs')
<script>
$('input.input-qty').each(function() {
    var $this = $(this),
        qty = $this.parent().find('.is-form'),
        min = Number($this.attr('min')),
        max = Number($this.attr('max'))
    if (min == 0) {
        var d = 0
    } else d = min
    $(qty).on('click', function() {
        if ($(this).hasClass('minus')) {
            if (d > min) d += -1
        } else if ($(this).hasClass('plus')) {
            var x = Number($this.val()) + 1
            if (x <= max) d += 1
            }
            $this.attr('value', d).val(d)
        })
    })

    let thumbnails = document.getElementsByClassName('thumbnail_gallery_product')
    let activeImages = document.getElementsByClassName('active')

    for (var i = 0; i < thumbnails.length; i++) {

        thumbnails[i].addEventListener('click', function() {
            // console.log(activeImages)
            if (activeImages.length > 0) {
                activeImages[0].classList.remove('active')
            }
            this.classList.add('active')
            document.getElementById('featured').src = this.src
        })
    }


    let buttonRight = document.getElementById('slide_next_thumbnail');
    let buttonLeft = document.getElementById('slide_prev_thumbnail');

    buttonLeft.addEventListener('click', function() {
        document.getElementById('slide-thumbnails').scrollLeft -= 180
    })

    buttonRight.addEventListener('click', function() {
        document.getElementById('slide-thumbnails').scrollLeft += 180
    })

    var swiper = new Swiper(".product-slider", {
            spaceBetween: 10,
            centeredSlides: true,
            // autoplay: {
            //     delay: 7500,
            //     disableOnInteraction: false,
            // },
            loop: true,
            breakpoints: {
                769: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                950: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1390: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
                1660: {
                    slidesPerView: 5,
                    spaceBetween: 50,
                },
            },
        });
</script>
@endsection