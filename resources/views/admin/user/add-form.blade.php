@section('title', 'Thêm tài khoản')
@extends('layouts.admin.main')
@section('content')
<!-- BEGIN: Subheader -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item">
                        <a class="card-title" href="{{route('user.index')}}">Danh sách tài khoản</a>
                    </li>
                    <li class="breadcrumb-item active">Thêm tài khoản</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@include('layouts.admin.message')
<!-- END: Subheader -->
<section class="content">
    <div class="container-fluid pb-1">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tên tài khoản</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Tên tài khoản">
                                <span class="text-danger error_text name_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Ảnh đại diện</label>
                                <input type="file" name="image" class="form-control">
                                <span class="text-danger error_text image_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Địa chỉ Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Nhập vào email">
                                <span class="text-danger error_text email_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control"
                                    placeholder="Nhập vào số điện thoại">
                                <span class="text-danger error_text phone_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                                <span class="text-danger error_text password_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Nhập lại mật khẩu</label>
                                <input type="password" name="cfpassword" class="form-control"
                                    placeholder="Nhập lại mật khẩu">
                                <span class="text-danger error_text cfpassword_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            @hasrole('Admin')
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-control">
                                    <label class="pr-1">
                                        <input type="radio" name="status" value="1" checked> Hoạt động
                                    </label>
                                    <label class="pl-1">
                                        <input type="radio" name="status" value="0"> Không hoạt động
                                    </label>
                                </div>
                                <span class="text-danger error_text status_error"></span>
                            </div>
                            @endhasrole
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right pl-2">
                            <button type="submit" class="btn btn-info">Lưu</button>
                            <a href="{{route('user.index')}}" class="btn btn-danger">Hủy</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script>
$(".btn-info").click(function(e) {
    e.preventDefault();
    var formData = new FormData($('form')[0]);
    let nameValue = $('#name').val();
    let name = nameValue.charAt(0).toUpperCase() + nameValue.slice(1);
    formData.set('name', name);
    $.ajax({
        url: "{{ route('user.saveAdd') }}",
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
            $('#realize').text('Tài khoản')
            $("#myModal").modal('show');
            if (data.status == 0) {
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
                $('.modal-body').html(
                    '<div class="alert alert-success" role="alert"><span class="fas fa-check-circle text-success mr-2"></span>' +
                    data.message + '</div>')
                $(document).find('input.form-control').val(null);
            }
        },
    });
});
$('select').map(function(i, dom) {
    var idSelect = $(dom).attr('id');
    $('#' + idSelect).select2({
        placeholder: 'Select ' + idSelect
    });
})
</script>
@endsection