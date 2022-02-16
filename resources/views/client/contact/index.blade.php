@section('title', 'Liên hệ')
@extends('layouts.client.main')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/contact.css')}}">
@endsection
@section('content')
    <section class="contact">
        <div class="bread-crumb">
            <a href="{{route('client.home')}}">Trang chủ</a>
            <span>Liên hệ</span>
        </div>
        <h1 id="heading">Liên hệ</h1>
        <div class="link_map_address">
            {!!$generalSetting->map!!}
        </div>
        <div class="information">
            <div class="box-info">
                <div class="contact-box">
                    <span>
                        <i class="fas fa-home"></i>
                    </span>
                    <p>
                        <label for="">Địa chỉ:</label> {{$generalSetting->address}}
                    </p>
                </div>
                <div class="contact-box">
                    <span>
                        <i class="fas fa-phone-alt"></i>
                    </span>
                    <p>
                        <label for="">Điện thoại:</label> {{$generalSetting->phone}}
                    </p>
                </div>
                <div class="contact-box">
                    <span>
                        <i class="fas fa-at"></i>
                    </span>
                    <p>
                        <label for="">Email:</label> <a href="#">lolipetvn@gmail.com</a>
                    </p>
                </div>
                <div class="contact-box">
                    <span>
                        <i class="fab fa-facebook-f"></i>
                    </span>
                    <p>
                        <label for="">Facebook:</label> <a href="{{$generalSetting->facebook}}">Lolipetvn</a>
                    </p>
                </div>
            </div>
        </div>
        <!-- <div class="post_contact">
            <h2 class="title">Gửi góp ý cho chúng tôi.</h2>
            <form action="">
                <div class="contact_box">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Name*" name="name">
                </div>
                <div class="contact_box">
                    <i class="fas fa-envelope"></i>
                    <input type="text" placeholder="Email*" name="email">
                </div>
                <div class="contact_box">
                    <i class="far fa-edit"></i>
                    <textarea name="message" placeholder="Nội dung*" id="" cols="30" rows="10"></textarea>
                </div>
                <button>Send Mail</button>
            </form>
        </div> -->
    </section>
</section>
@endsection