@section('title', 'Tìm kiếm')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/account_info.css')}}">
    <style>
        section.alert_order {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* padding: 0; */
            z-index: 1000;
            padding: 16% 30% 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
        }
        
        section.alert_order.active {
            display: block;
        }
        
        section.alert_order form {
            position: relative;
            padding: 5rem;
            background-color: #fff;
            border-radius: 0.5rem;
        }
        
        section.alert_order form .hd {
            width: 100%;
            margin: 1rem 0;
            display: block;
        }
        
        section.alert_order form .hd label {
            font-size: 1.6rem;
            font-weight: bold;
            color: #443;
        }
        
        section.alert_order form .close_alert {
            position: absolute;
            top: 1.2rem;
            right: 2rem;
            font-size: 2rem;
            cursor: pointer;
        }
        
        section.alert_order form input {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 0.1rem solid #333;
            border-radius: 0.5rem;
            display: block;
        }
        
        section.alert_order form .button {
            display: flex;
            align-items: center;
            justify-content: end;
            margin-top: 2rem;
        }
    </style>
@endsection
<!-- section product -->
    @if(isset($product) && $product !== '')
    <section class="products" id="product">
        <h1 class="heading-center"> Thú cưng </h1>
        @if(empty($product))
            <div class="product-top" style="text-align:center;">
                <h3 style="font-size: 2rem; font-family: 'Coiny', cursive; color: #333333; padding: 1.4rem 0; text-transform: uppercase;">Không tìm thấy kết quả</h3>
                <img src="{{ asset('client-theme/images/not-found-cat.svg')}}" alt="Ảnh hiển thị bị lỗi!" id=featured>
            </div>
        @else
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
                                <input type="hidden" name="discount_price" value="{{$p->discount}}">
                                <input type="hidden" name="category_id" value="{{$p->category_id}}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-buyNow">Thêm vào giỏ hàng</button>
                            </form>
                        </div>
                    </div>
                    <div class="item-bottom">
                        <div class="product-info">
                            <a href="{{route('client.product.detail', ['id' => $p->slug])}}" class="name">{{$p->name}}</a>
                            @if($p->discount == '')
                            <span class="price">{{number_format($p->price)}}đ</span>
                            @else
                            <span class="discount">{{number_format($p->price)}}đ</span>
                            <span class="price">
                                <?php
                                echo number_format($p->price - $p->discount) . 'đ';
                                ?>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="details">
                <button><a href="{{route('client.product.index')}}">xem thêm <i class="fas fa-chevron-right"></i></a></button>
            </div>
        @endif
    </section>
    @elseif(isset($product))
    <section class="products">
        <h1 class="heading-center"> Thú cưng </h1>
        <div class="message-search" style="text-align: center;color: var(--main-color);">
            <h2>Không tìm thấy thú cưng.</h2>
        </div>
    </section>
    @endif
    <!-- section acsesory -->
    @if(isset($accessory) && $accessory !== '')
    <section class="products">
        <h1 class="heading-center"> Phụ kiện thú cưng </h1>
        <div class="product-container">
            @foreach($accessory as $ac)
            <div class="product-item">
                <div class="item-top">
                    <div class="product-lable">
                    </div>
                    <div class="product-thumbnail">
                        <a href="{{route('client.accessory.detail', ['id' => $ac->slug])}}">
                            <img src="{{asset( 'storage/' . $ac->image)}}"
                                alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                        </a>
                    </div>
                    <div class="product-extra">
                        <form action="{{route('saveCart')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id_hidden" value="{{$ac->id}}">
                            <input type="hidden" name="product_type" value="2">
                            <input type="hidden" name="discount_price" value="{{$ac->discount}}">
                            <input type="hidden" name="category_id" value="{{$ac->category_id}}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-buyNow">Thêm vào giỏ hàng</button>
                        </form>
                    </div>
                </div>
                <div class="item-bottom">
                    <div class="product-info">
                        <a href="{{route('client.accessory.detail', ['id' => $ac->slug])}}" class="name">{{$ac->name}}</a>
                        @if($ac->discount == '')
                        <span class="price">{{number_format($ac->price)}}đ</span>
                        @else
                        <span class="discount">{{number_format($ac->price)}}đ</span>
                        <span class="price">
                            <?php
                            echo number_format($ac->price - $ac->discount) . 'đ';
                            ?>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="details">
            <button><a href="{{route('client.accessory.index')}}">xem thêm <i class="fas fa-chevron-right"></i></a></button>
        </div>
    </section>
    @elseif(isset($accessory))
    <section class="products">
        <h1 class="heading-center"> Phụ kiện thú cưng </h1>
        <div class="message-search" style="text-align: center;color: var(--main-color);">
            <h2>Không tìm thấy phụ kiện thú cưng.</h2>
        </div>
    </section>
    @endif
    @if(isset($blog) && $blog !== '')
    <section class="blogs">
        <h1 class="heading-center">Bài viết</h1>
        <div class="blog-container">
            @foreach($blog as $blog)
            <div class="blog-item">
                <div class="item-top">
                    <div class="thumbnail">
                        <a href="{{route('client.blog.detail', ['id' => $blog->slug])}}">
                            <img src="{{asset( 'storage/' . $blog->image)}}"
                                alt="Bài viết này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                        </a>
                    </div>
                    <div class="link_blog">
                        <a href="{{route('client.blog.detail', ['id' => $blog->slug])}}" class="btn-gray">Chi tiết</a>
                    </div>
                </div>
                <div class="item-bottom">
                    <h1 class="title">{{$blog->title}}</h1>
                    <div class="item-extra">
                        <ul>
                            <li>
                                <i class="fas fa-user"></i>
                                <span>Tác giả: </span>
                                <span class="author">{{$blog->user->name}}</span>
                            </li>
                            <li class="middle">
                                <i class="far fa-calendar-alt"></i>
                                <span class="author">{{$blog->created_at->diffForHumans()}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @elseif(isset($blog))
    <section class="products">
        <h1 class="heading-center"> Bài viết </h1>
        <div class="text-center">
            <div class="message-search" style="text-align: center;color: var(--main-color);">
                <h2>Không tìm thấy bài viết.</h2>
            </div>
        </div>
    </section>
    @endif
    @if(isset($order) && $order !== '')
    <section class="account-info">
        <div class="bread-crumb">
            <a href="{{route('client.home')}}">Trang chủ</a>
            <span>Quản lý đơn hàng</span>
        </div>
        <div class="account_info_container">
            <div class="content_page">
                <table class="greenTable">
                    <thead>
                        <tr>
                            <th colspan="3">Dơn hàng mã: {{$order->code}}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            @if($order->delivery_status == 1)
                                <th>
                                    @if(!empty($order->cancel_order))
                                        <a href="javascript:;" class="delete_order_success">Error</a>
                                    @else
                                        <button id="alert_cl" class="delete_order">Hủy đơn hàng</button>
                                    @endif
                                </th>
                            @else
                                <th></th>
                            @endif
                        </tr>
                        <tr>
                            <th style="min-width: 100px;">Sản phẩm</th>
                            <th>Ảnh</th>
                            <th style="min-width: 100px;">Thành tiền</th>
                            <th style="min-width: 100px;">Số lượng</th>
                            <th style="min-width: 81px;">Ngày mua</th>
                            <th style="min-width: 172px;">Trạng thái thanh toán</th>
                            <th style="min-width: 142px;">Trạng thái đơn hàng</th>
                        </tr>
                    </thead>
                    <tbody class="list-overflow">
                        @foreach($order->orderDetails as $orD)
                        <tr>
                            @if($orD->product_type == 1)
                            <td>{{$orD->product->name}}</td>
                            <td>
                                <a href="{{route('client.product.detail', ['id' => $orD->product->slug])}}">
                                    <img src="{{asset( 'storage/' . $orD->product->image)}}"
                                        alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" width="100">
                                </a>
                            </td>
                            @else
                            <td>{{$orD->accessory->name}}</td>
                            <td>
                                <a href="{{route('client.accessory.detail', ['id' => $orD->accessory->slug])}}">
                                    <img src="{{asset( 'storage/' . $orD->accessory->image)}}"
                                        alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" width="100">
                                </a>
                            </td>
                            @endif
                            <td>{{number_format($orD->price,0,',','.')}}đ</td>
                            <td  style="text-align: center;">{{$orD->quantity}}</td>
                            <td class="time">{{$orD->order->created_at->diffForHumans()}}</td>
                            <td  style="text-align: center;">
                                {{$orD->payment_status}}
                            </td>
                                <td>
                                    @if($order->delivery_status == 4)
                                        Bạn đã hủy đơn hàng này
                                    @else
                                        {{$orD->delivery_status}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="alert_order" id="alert_order">
        <form action="{{route('cancel_order_t', ['id' => $order->id])}}" method="GET">
            @csrf
            <div class="close_alert">
                <i class="fas fa-times"></i>
            </div>
            <div class="hd">
                <label for="">Vui lòng nhập vào Email dùng để đặt hàng để hủy đơn hàng này.</label>
            </div>
            <input type="hidden" name="id" value="{{$order->id}}">
            <input type="text" name="email" placeholder="Nhập vào Email dùng để đặt hàng">
            <div class="button">
                <button type="submit" class="btn-gray">Hủy đơn hàng</button>
            </div>
        </form>
    </section>
    @elseif(isset($order))
    <section class="products">
        <h1 class="heading-center"> Đơn hàng </h1>
        <div class="message-search" style="text-align: center;color: var(--main-color);">
            <h2>Không tìm thấy đơn hàng.</h2>
        </div>
    </section>
    @endif
    
@endsection
@section('pagejs')
    <script>
        const showModal = (openButton, modalContent) => {
            const openBtn = document.getElementById(openButton),
                modalContainer = document.getElementById(modalContent)

            if (openBtn && modalContainer) {
                openBtn.addEventListener('click', () => {
                    modalContainer.classList.add('active')
                })
            }
        }
        showModal('alert_cl', 'alert_order')
        const closeBtn = document.querySelectorAll('.close_alert')

        function closeModal() {
            const modalContainer = document.getElementById('alert_order')
            modalContainer.classList.remove('active')
        }
        closeBtn.forEach(c => c.addEventListener('click', closeModal))
        $(window).scroll(function() {
            $('section.alert_order').removeClass('active');
      })
    </script>
@endsection