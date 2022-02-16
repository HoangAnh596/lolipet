@section('title', 'Thanh toán')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/gio-hang.css')}}">
@endsection
<!-- content -->
<div class="section-mt"></div>
<!-- <section class="search">
    <div class="container">
        <form action="" class="search-form">
            <div class="form-field">
                <input type="search" class="form-input" id="search-box" placeholder=" ">
                <label for="search" class="form-label"><i class="fas fa-search"></i> search here...</label>
            </div>
        </form>
    </div>
</section> -->
<section class="cart-details">
    <h2 class="heading">Thanh toán</h2>
    <div class="cart-detail-container">
        <div class="carts active">
            <div class="carts-container">
                <?php
                $content = Cart::content();
                ?>
                @foreach($content as $value)
                <div class="cart-item">
                    <div class="product-thumbnail">
                        <a href="#">
                            <img src="{{asset( 'storage/' . $value->options->image)}}" alt="">
                        </a>
                    </div>
                    <div class="product-info">
                        <h5 class="name">{{$value->name}}</h5>
                        <!-- <div class="category">
                            Danh mục: <span>Bird</span>
                        </div> -->
                        <div class="price">
                            Giá tiền: <span>{{number_format($value->price,0,',','.')}} VND</span>
                        </div>
                        <div class="quantity">
                            Số lượng: <span>{{$value->qty}}</span>
                        </div>
                        <div class="total">
                            Tổng: <span>
                                <?php
                                $subtotal = $value->price * $value->qty;
                                echo number_format($subtotal, 0, ',', '.');
                                ?>
                                 VND
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="group-double">
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="rowId" value="{{$value->rowId}}">
                <div class="group-item">
                    <div class="cart-detail-heading">
                        <span>Thông tin liên lạc</span>
                    </div>
                    <div class="form-group">
                        <label for="" class="group-label">Số điện thoại <span class="text-red">*</span></label>
                        @if(Auth::check())
                        <input type="text" name="phone" placeholder="Số điện thoại" value="{{Auth::user()->phone}}">
                        @else
                        <input type="text" name="phone" placeholder="Số điện thoại" value="{{old('phone')}}">
                        @endif
                        @error('phone')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="" class="group-label">Địa chỉ email <span class="text-red">*</span></label>
                        @if(Auth::check())
                        <input type="text" name="email" placeholder="Email" value="{{Auth::user()->email}}">
                        @else
                        <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
                        @endif
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="cart-detail-heading">
                        <span>Địa chỉ giao hàng</span>
                    </div>
                    <div class="form-group">
                        <label for="" class="group-label">Họ tên <span class="text-red">*</span></label>
                        @if(Auth::check())
                        <input type="text" placeholder="Họ & Tên" name="name" value="{{Auth::user()->name}}">
                        @else
                        <input type="text" placeholder="Họ & Tên" name="name" value="{{old('name')}}">
                        @endif
                    </div>
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                    <!-- ------------------------------------------------------------------------------ -->
                    <div class="form-group">
                        <label for="" class="group-label">Thành phố <span class="text-red">*</span></label>
                        <select name="calc_shipping_provinces" required="">
                            <option value="">Tỉnh / Thành phố</option>
                        </select>
                        <input class="billing_address_1" name="city" type="hidden" value="">
                    </div>
                    @error('city')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="form-group">
                        <label for="" class="group-label">Quận / Huyện <span class="text-red">*</span></label>
                        <select name="calc_shipping_district" required="">
                            <option value="">Quận / Huyện</option>
                        </select>
                        <input class="billing_address_2" name="district" type="hidden" value="">
                    </div>
                    @error('district')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="form-group">
                        <label for="" class="group-label">Phường / Xã <span class="text-red">*</span></label>
                        <input type="text" placeholder="Phường xã" name="ward" value="{{old('ward')}}">
                    </div>
                    @error('ward')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="form-group">
                        <label for="" class="group-label">Địa chỉ <span class="text-red">*</span></label>
                        <input type="text" placeholder="Địa chỉ nhà" name="address" value="{{old('address')}}">
                    </div>
                    @error('address')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                    <!-- ------------------------------------------------------------------------------ -->
                    <div class="cart-detail-heading">
                        <span>Ghi chú khi giao hàng</span>
                    </div>
                    <div class="form-group">
                        <textarea name="note" id="" cols="30" rows="10" placeholder="Ghi chú"></textarea>
                    </div>
                    <div class="cart-detail-heading">
                        <span>Hình thức thanh toán</span>
                    </div>
                    <div class="form-group-type-payment">
                        <input type="radio" name="ptvc" id="ptvc" value="1" checked><label for="ptvc">Thanh toán khi
                            giao hàng</label>
                    </div>
                </div>
                <div class="group-item">
                    <div class="pay-second">
                        <div class="cart-detail-heading">
                            <span>Đơn hàng của bạn</span>
                        </div>
                        <div class="pay-second-container">
                            <div class="item">
                                <span class="both">Sản phẩm</span>
                                <span class="both">Tổng tiền</span>
                            </div>
                            <!-- (S) vòng lặp sp -->
                            @foreach($content as $value)
                            <div class="item">
                                <span>{{$value->name}}</span>
                                <span>
                                    <?php
                                    $subtotal = $value->price * $value->qty;
                                    echo number_format($subtotal, 0, ',', '.');
                                    ?>
                                     VND
                                </span>
                            </div>
                            @endforeach
                            <!-- (E) vòng lặp sp -->
                            <div class="item">
                                <span class="both">Tạm tính</span>
                                <span class="both" name="priceTotal">
                                    {{Cart::priceTotal(0,',','.')}} VND
                                </span>
                            </div>
                            <div class="item">
                                <span class="both">Giảm giá
                                    @if(session()->has('coupon'))
                                        ({{ session()->get('coupon')['name'] }})
                                    @endif
                                </span>
                                <span class="both">
                                    <input type="hidden" value="@if(session()->has('coupon'))
                                        {{ $discount }} 
                                    @else
                                        0
                                    @endif" name="discount">
                                    @if(session()->has('coupon'))
                                        {{ number_format($discount,0,',','.') }} VND
                                    @else
                                        0 VND
                                    @endif
                                </span>
                            </div>
                            <div class="item">
                                <span class="both">Thuế</span>
                                <span class="both">
                                    <input type="hidden" value="{{Cart::tax(0,',','')}}" name="tax">
                                    {{Cart::tax(0,',','.')}} VND
                                </span>
                            </div>
                            <div class="item">
                                <span class="both">Tổng tiền</span>
                                <span class="both total">
                                    {{number_format($total,0,',','.')}} VND
                                </span>
                                <input type="hidden" value="{{ $total }}" name="grand_total">
                            </div>
                        </div>
                        <div class="item-last">
                            <button class="btn-pay" type="submit" id="cart-next"><span>Thanh toán</span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('pagejs')
<script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'/></script>
<script>//<![CDATA[
if (address_2 = localStorage.getItem('address_2_saved')) {
    $('select[name="calc_shipping_district"] option').each(function() {
        if ($(this).text() == address_2) {
        $(this).attr('selected', '')
        }
    })
    $('input.billing_address_2').attr('value', address_2)
}
if (district = localStorage.getItem('district')) {
  $('select[name="calc_shipping_district"]').html(district)
    $('select[name="calc_shipping_district"]').on('change', function() {
        var target = $(this).children('option:selected')
        target.attr('selected', '')
        $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
        address_2 = target.text()
        $('input.billing_address_2').attr('value', address_2)
        district = $('select[name="calc_shipping_district"]').html()
        localStorage.setItem('district', district)
        localStorage.setItem('address_2_saved', address_2)
    })
}
$('select[name="calc_shipping_provinces"]').each(function() {
    var $this = $(this),
        stc = ''
    c.forEach(function(i, e) {
        e += +1
        stc += '<option value=' + e + '>' + i + '</option>'
        $this.html('<option value="">Tỉnh / Thành phố</option>' + stc)
        if (address_1 = localStorage.getItem('address_1_saved')) {
        $('select[name="calc_shipping_provinces"] option').each(function() {
            if ($(this).text() == address_1) {
            $(this).attr('selected', '')
            }
        })
            $('input.billing_address_1').attr('value', address_1)
        }
    $this.on('change', function(i) {
        i = $this.children('option:selected').index() - 1
        var str = '',
            r = $this.val()
            if (r != '') {
                arr[i].forEach(function(el) {
                str += '<option value="' + el + '">' + el + '</option>'
                $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>' + str)
                })
                var address_1 = $this.children('option:selected').text()
                var district = $('select[name="calc_shipping_district"]').html()
                localStorage.setItem('address_1_saved', address_1)
                localStorage.setItem('district', district)
                $('select[name="calc_shipping_district"]').on('change', function() {
                    var target = $(this).children('option:selected')
                    target.attr('selected', '')
                    $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
                    var address_2 = target.text()
                    $('input.billing_address_2').attr('value', address_2)
                    district = $('select[name="calc_shipping_district"]').html()
                    localStorage.setItem('district', district)
                    localStorage.setItem('address_2_saved', address_2)
                })
            } else {
                $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>')
                district = $('select[name="calc_shipping_district"]').html()
                localStorage.setItem('district', district)
                localStorage.removeItem('address_1_saved', address_1)
            }
        })
    })
})
//]]></script>
@endsection