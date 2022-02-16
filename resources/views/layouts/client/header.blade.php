<header class="header-wrapper">
    <div class="header-top-bar">
        <div class="container">
            <div class="row">
                <ul class="header-item-left">
                    <li>
                        @if(!empty($generalSetting->email))
                        <a href="mailto:{{$generalSetting->email}}">
                            <i class="fas fa-envelope"></i>
                            <span>{{$generalSetting->email}}</span>
                        </a>
                        @else
                        <a href="javascript:;">
                            <i class="fas fa-envelope"></i>
                            <span></span>
                        </a>
                        @endif
                    </li>
                    <li>
                        @if(!empty($generalSetting->email))
                        <a href="javascript:;">
                            <i class="fas fa-phone-alt"></i>
                            <span>{{$generalSetting->phone}}</span>
                        </a>
                        @else
                        <a href="javascript:;">
                            <i class="fas fa-phone-alt"></i>
                            <span></span>
                        </a>
                        @endif
                    </li>
                </ul>
                <div class="header-item none"></div>
                <ul class="header-item">
                    @if(Auth::check())
                        @if(Auth::user()->hasPermissionTo('login_admin'))
                        <li>
                            <a href="{{route('dashboard.index')}}">
                                <i class="fas fa-cogs"></i>
                                <span>Đăng nhập quản trị</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{route('client.customer.info')}}">
                                <span>Xin chào: </span>
                                <span>{{Auth::user()->name}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('logout')}}">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{route('login')}}">
                                <i class="fas fa-user"></i>
                                <span>Tài khoản</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('login')}}">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Login</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="header-middle-bar">
        <div class="container">
            <div class="row">
                <div class="header-item icon-bars">
                    <div class="fas fa-bars" id="menu-btn"></div>
                </div>
                <div class="header-item none"></div>
                <div class="header-item">
                    <a href="{{route('client.home')}}" class="logo">
                        <!-- <i class="fas fa-paw"></i> <b> LOLI<span>PET</span></b> -->
                        @if(!empty($generalSetting->logo))
                        <img src="{{ asset('storage/' . $generalSetting->logo)}}" alt="">
                        @else
                        <img src="{{ asset('client.images.logo_full.png')}}" alt="">
                        @endif
                    </a>
                </div>
                <div class="header-item">
                    <nav class="navbar">
                        <ul class="nav-item">
                            <li>
                                <a href="{{route('client.home')}}" id="link_home">Trang chủ</a>
                            </li>
                            <li>
                                <a href="{{route('client.product.index')}}" id="link_product">Thú cưng</a>
                            </li>
                            <li>
                                <a href="{{route('client.accessory.index')}}" id="link_accessory">Phụ kiện</a>
                            </li>
                            <li>
                                <a href="{{route('client.blog.index')}}" id="link_blog">Tin tức</a>
                            </li>
                            <li>
                                <a href="{{route('client.contact')}}" id="link_contact">Liên hệ</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="header-item icons">
                    <!-- <div class="cart">
                        <i class="fas fa-heart"></i>
                    </div> -->
                    <div class="cart">
                        <a href="{{route('client.cart.index')}}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="title">Giỏ hàng</span>
                            <span class="btn-number">
                                <?php
                                $count = Cart::content()->count();
                                ?>
                                {{$count}}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom-bar">
        <div class="container">
            <form action="{{route('client.search')}}" method="GET" class="search-form">
                @csrf
                <div class="search_box select">
                    <select name="search_type" id="">
                        <option @if(isset($searchData['search_type']) && $searchData['search_type']==1) selected @endif
                            value="1">Mã đơn hàng</option>
                        <option @if(isset($searchData['search_type']) && $searchData['search_type']==2) selected @endif
                            value="2">Thú cưng</option>
                        <option @if(isset($searchData['search_type']) && $searchData['search_type']==3) selected @endif
                            value="3">Phụ kiện</option>
                        <option @if(isset($searchData['search_type']) && $searchData['search_type']==4) selected @endif
                            value="4">Bài viết</option>
                    </select>
                </div>
                <div class="search_box input">
                    <input type="search" name="search" @isset($searchData['search']) value="{{$searchData['search']}}"
                        @endisset class="form-input" id="search-box" placeholder="Tìm kiếm...">
                    <button for="search-box">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>
<!-- @if(session('msg') != null)
<div class="msg-alert">
    <p class="text-alert">
        <span>{{session('msg')}}</span>
        <i class="fas fa-times" data-dismiss="alert"></i>
    </p>
</div>
@endif -->
@if(session('success') || session('danger'))
<section class="all_alert" id="all_alert">
    <div class="msg-alert @if(session('success')) success @elseif(session('danger')) danger @endif">
        <p class="text-alert">
            <span>{{ session()->get('success') }}{{ session()->get('danger') }}</span>
            <button class="close" onclick="$('#all_alert').hide();; return false;">×</button>
        </p>
    </div>
</section>
@endif
@section('pagejs')
<script>
// $("#off_alert").on('click', function(e){
//     document.getElementById("all_alert").style.display = 'none';
//     // $("#all_alert").addClass("active");
//     e.preventDefault();
// });
// $(".msg-alert p a").click(function() {
//     $(".msg-alert").removeClass('active');
// });
</script>
@endsection
