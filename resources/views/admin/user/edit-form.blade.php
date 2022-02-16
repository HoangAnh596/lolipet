@section('title', 'Sửa tài khoản')
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
                    <li class="breadcrumb-item active">Sửa tài khoản</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- END: Subheader -->
@include('layouts.admin.message')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-success">
                    <div class="card-body box-profile">
                        <div class="text-center" id="cc">
                            <img class="profile-user-img img-fluid img-circle" id="blah"
                                src="{{asset( 'storage/' . $model->avatar)}}" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{$model->name}}</h3>
                        @if(count($model->roles)>0) @foreach($model->roles as $ro)
                        <p class="text-muted text-center">{{$ro->name}}</p>
                        @endforeach @else
                        <p class="text-muted text-center">Khách hàng</p>
                        @endif
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Vai trò</b>
                                @if(count($model->roles)>0) 
                                    @foreach($model->roles as $ro)
                                        <b class="float-right text-info">{{$ro->name}}</b> 
                                    @endforeach 
                                @else
                                    <b class="float-right text-info">Khách hàng</b>
                                @endif
                            </li>
                            <li class="list-group-item">
                                <b>Trạng thái</b>
                                <i class="{{ $model->status == 1 ? 'fa fa-check text-success' : 'fas fa-user-lock text-danger' }} float-right pr-3"></i>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                         <span>Cập nhật thông tin tài khoản</span>
                    </div>
                    <div class="card-body">
                        @if(session('msg') != null)
                            <b class="text-left text-danger">{{session('msg')}}</b>
                        @endif
                        <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Tên tài khoản</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{$model->name}}" placeholder="Tên tài khoản">
                                        <span class="text-danger error_text name_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Địa chỉ email</label>
                                        <input type="text" name="email" class="form-control" value="{{$model->email}}"
                                            placeholder="Nhập vào email">
                                        <span class="text-danger error_text email_error"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control" value="{{$model->phone}}"
                                            placeholder="Nhập vào số điện thoại">
                                        <span class="text-danger error_text phone_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Ảnh đại diện</label>
                                        <input type="file" name="image" id="imgInp" class="form-control">
                                        <span class="text-danger error_text image_error"></span>
                                    </div>
                                </div>
                                <div class="col-12 text-right">
                                    <a href="{{route('user.index')}}" class="btn btn-danger">Hủy</a>
                                    <button type="submit" class="btn btn-info">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script src="{{ asset('admin-theme/custom-js/custom.js') }}"></script>
<script>
$("#imgInp").change(function() {
    readURL(this);
});
$(".btn-info").click(function(e) {
    e.preventDefault();
    var formData = new FormData($('form')[0]);
    let nameValue = $('#name').val();
    let name = nameValue.charAt(0).toUpperCase() + nameValue.slice(1);
    formData.set('name', name);
    $.ajax({
        url: "{{route('user.saveEdit',['id'=>$model->id])}}",
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
            $('#realize').text('Người dùng')
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