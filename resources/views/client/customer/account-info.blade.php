@section('title', 'Quản lý tài khoản')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/account_info.css')}}">
@endsection
<!-- content -->
<section class="account-info">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <span>Quản lý tài khoản</span>
    </div>
    <div class="account_info_container">
        @include('client.customer.nav_bar_customer')
        <!-- <div class="content_page">
            <div class="title">Thông tin cá nhân</div>
            <div class="group">
                <label for="">Họ & tên:</label>
                <span>{{Auth::user()->name}}</span>
            </div>
            <div class="group">
                <label for="">Số điện thoại:</label>
                <span>{{Auth::user()->phone}}</span>
            </div>
            <div class="group">
                <label for="">Email:</label>
                <span>{{Auth::user()->email}}</span>
            </div>
            <div class="group-last">
                <a href="{{route('client.customer.updateinfo')}}" class="updateinfo">Cập nhật tài khoản</a>
                <a href="{{route('changePassword')}}" class="changepassword">Đổi mật khẩu</a>
            </div>
        </div> -->
        <div class="content_page_double">
            <div class="box form" id="box_form">
                <form action="{{route('client.customer.updateinfo')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="box_content">
                        <div class="avatar">
                            <img src="{{ (strpos(Auth::user()->avatar, 'uploads/') === false ? Auth::user()->avatar:asset('storage/' . Auth::user()->avatar)) }}"
                                id="blah2" alt="User profile picture">
                            <label for="hidden-avatar" class="setting">
                                <i class="far fa-edit"></i> Edit
                                <input hidden type="file" name="uploadfile" id="hidden-avatar">
                            </label>
                        </div>
                        <div class="undo">
                            <a href="javascript:;" style="float:right;" id="undo" class="btn_black_icon"><i
                                    class="fas fa-undo-alt"></i></a>
                        </div>
                    </div>
                    <div class="box_content_last">
                        <div class="box_item">
                            <label for="name" class="name"><i class="fas fa-user"></i></label>
                            <input type="text" name="name" id="name" placeholder="Họ và tên"
                                value="{{Auth::user()->name}}">
                            @error('name')
                            <span class="text_danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="box_item">
                            <label for=""><i class="fas fa-at"></i></label>
                            <input type="text" name="email" placeholder="Emai" value="{{Auth::user()->email}}">
                            @error('email')
                            <span class="text_danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="box_item">
                            <label for=""><i class="fas fa-phone-alt"></i></label>
                            <input type="text" name="phone" placeholder="Số điện thoại" value="{{Auth::user()->phone}}">
                            @error('phone')
                            <span class="text_danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="box_item_last">
                            <a href="javascript:;" id="cancel_edit">Hủy bỏ</a>
                            <button type="submit">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box info active" id="box_info">
                <div class="box_top">
                    <h5 class="title">Thông tin cá nhân</h5>
                    <a href="javascript:;" id="edit_info"><i class="fas fa-user-edit"></i></a>
                </div>
                <div class="box_middle">
                    <ul>
                        <li>
                            <strong>Họ & Tên: </strong><span>{{Auth::user()->name}}</span>
                        </li>
                        <li>
                            <strong>Điện thoại: </strong><span>{{Auth::user()->phone}}</span>
                        </li>
                        <li>
                            <strong>Email: </strong><span>{{Auth::user()->email}}</span>
                        </li>
                    </ul>
                </div>
                <div class="box_bottom">
                    <a href="{{route('changePassword')}}" class="changepassword">Đổi mật khẩu</a>
                </div>
            </div>
            <div class="box">
                <div class="box_middle">
                    <ul>
                        <li>
                            <strong>Họ & Tên: </strong><span>{{Auth::user()->name}}</span>
                        </li>
                        <li>
                            <strong>Điện thoại: </strong><span>{{Auth::user()->phone}}</span>
                        </li>
                        <li>
                            <strong>Email: </strong><span>{{Auth::user()->email}}</span>
                        </li>
                    </ul>
                    <ul>
                        <li class="first_two">
                            <strong>Thú cưng đã mua: </strong>
                            @foreach($order as $or)
                            @foreach($orderDetail as $orD)
                            @if($orD->order_id == $or->id && $or->delivery_status == 3 && $orD->product_type == 1)
                            <a
                                href="{{route('client.product.detail', ['id' => $orD->products->slug])}}">{{$orD->products->name}}</a><span
                                class="rtrim">,</span>
                            @endif
                            @endforeach
                            @endforeach
                        </li>
                        <li class="first_two">
                            <strong>Phụ kiện đã mua: </strong>
                            @foreach($order as $or)
                            @foreach($orderDetail as $orD)
                            @if($orD->order_id == $or->id && $or->delivery_status == 3 && $orD->product_type == 2)
                            <a
                                href="{{route('client.accessory.detail', ['id' => $orD->accessory->slug])}}">{{$orD->accessory->name}}</a><span
                                class="rtrim">,</span>
                            @endif
                            @endforeach
                            @endforeach
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <strong>Đơn hàng đang chờ xử lí:</strong>
                            <span>
                                <?php
                                $totail = 0;
                                foreach ($order as $value) {
                                    if ($value->delivery_status == 1) {
                                        $totail += 1;
                                    }
                                }
                                echo $totail;
                                ?>
                            </span>
                        </li>
                        <li>
                            <strong>Đơn hàng đang giao:</strong>
                            <span>
                                <?php
                                $totail = 0;
                                foreach ($order as $value) {
                                    if ($value->delivery_status == 2) {
                                        $totail += 1;
                                    }
                                }
                                echo $totail;
                                ?>
                            </span>
                        </li>
                        <li>
                            <strong>Đơn hàng giao thành công:</strong>
                            <span>
                                <?php
                                $totail = 0;
                                foreach ($order as $value) {
                                    if ($value->delivery_status == 3) {
                                        $totail += 1;
                                    }
                                }
                                echo $totail;
                                ?>
                            </span>
                        </li>
                        <li>
                            <strong>Đơn hàng bị hủy:</strong>
                            <span>
                                <?php
                                $totail = 0;
                                foreach ($order as $value) {
                                    if ($value->delivery_status == 0) {
                                        $totail += 1;
                                    }
                                }
                                echo $totail;
                                ?>
                            </span>
                        </li>
                        <li>
                            <strong>Đơn hàng đã hủy:</strong>
                            <span>
                                <?php
                                $totail = 0;
                                foreach ($order as $value) {
                                    if ($value->delivery_status == 4) {
                                        $totail += 1;
                                    }
                                }
                                echo $totail;
                                ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- content -->
@endsection
@section('pagejs')
<script>
$("#edit_info").on('click', function(e) {
    document.getElementById("box_info").style.display = 'none';
    document.getElementById("box_form").style.display = 'block';
    e.preventDefault();
});

$("#undo").on('click', function(e) {
    document.getElementById("box_form").style.display = 'none';
    document.getElementById("box_info").style.display = 'block';
    e.preventDefault();
});

$("#cancel_edit").on('click', function(e) {
    document.getElementById("box_form").style.display = 'none';
    document.getElementById("box_info").style.display = 'block';
    e.preventDefault();
});

var a = '';

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        // $('#cc').append(`
        // 	<img class="add-product-preview-img" id="blah" src="#" alt="your image" />
        // `);
        // document.getElementById("cc").style.display = 'block';
        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
            $('#blah2').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#hidden-avatar").change(function() {
    readURL(this);
});
</script>
@endsection