@section('title', 'Thông tin hệ thống')
@extends('layouts.admin.main') 
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Thông tin hệ thống</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@include('layouts.admin.message')
<!-- Main content -->
<section class="content">
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Cài đặt chung</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Logo dang dùng</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Dùng Logo mới</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Số điện thoại</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Địa chỉ Email</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Địa chỉ</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Thời gian mở cửa</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Bản đồ</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Facebook</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Instagram</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Twitter</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Youtube</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <div class="form-control">
                                    <img src="{{asset( 'storage/' . $model->logo)}}"
                                        alt="Không có hình ảnh logo để hiển thị!" height="25">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="file" name="uploadfile" class="form-control">
                                <span class="text-danger error_text uploadfile_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" value="{{$model->phone}}"
                                    placeholder="Số điện thoại liên hệ của cửa hảng">
                                <span class="text-danger error_text phone_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" value="{{$model->email}}"
                                    placeholder="Email liên hệ của cửa hàng">
                                <span class="text-danger error_text email_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="address" class="form-control" value="{{$model->address}}" placeholder="Địa chỉ">
                            </div>
                            <div class="form-group">
                                <input type="text" name="open_time" class="form-control" value="{{$model->open_time}}" placeholder="Thời gian mở cửa">
                            </div>
                            <div class="form-group">
                                <input type="text" name="map" class="form-control" value="{{$model->map}}" placeholder="Mã nhúng bản đồ">
                            </div>
                            <div class="form-group">
                                <input type="text" name="facebook" class="form-control" value="{{$model->facebook}}" placeholder="Link facebook ( nếu có )">
                            </div>
                            <div class="form-group">
                                <input type="text" name="instagram" class="form-control" value="{{$model->instagram}}"
                                    placeholder="Link instagram ( nếu có )">
                                <span class="text-danger error_text instagram_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="twitter" class="form-control" value="{{$model->twitter}}"
                                    placeholder="Link twitter ( nếu có )">
                                <span class="text-danger error_text twitter_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="youtube" class="form-control" value="{{$model->youtube}}"
                                    placeholder="Link kênh youtube ( nếu có )">
                                <span class="text-danger error_text youtube_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('dashboard.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script src="{{ asset('admin-theme/custom-js/custom.js') }}"></script>
<script>
$(document).ready(function() {
    $(".btn-info").click(function(e) {
        e.preventDefault();
        var formData = new FormData($('form')[0]);
        $.ajax({
            url: "{{route('general.saveAdd')}}",
            type: 'POST',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(data) {
                $(document).find('span.error_text').text('');
            },
            success: function(data) {
                console.log(data)
                $('#realize').attr('href', data.url)
                $('#realize').text('Dashboard');
                if (data.status == 0) {
                    $("#myModal").modal('show');
                    showErr = '<div class="alert alert-danger" role="alert" id="danger">';
                    $.each(data.error, function(key, value) {
                        showErr +=
                            '<span class="fas fa-times-circle text-danger mr-2"></span>' +
                            value[0] +
                            '<br>';
                        $('span.' + key + '_error').text(value[0]);
                    });
                    $('.modal-body').html(showErr);

                } else {
                    $("#myModal").modal('show');
                    $('.modal-body').html(
                        '<div class="alert alert-success" role="alert"><span class="fas fa-check-circle text-success mr-2"></span>' +
                        data.message + '</div>')
                }
            },
        });
    });
});
</script>
@endsection