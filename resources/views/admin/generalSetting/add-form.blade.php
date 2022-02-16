@section('title', 'Thêm thông tin hệ thống')
@extends('layouts.admin.main') 
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Thêm thông tin hệ thống</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

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
                                    <label for="">Phone</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-control border-0">
                                    <label for="">Email</label>
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
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" value="{{$model->phone}}"
                                    placeholder="Số điện thoại liên hệ của cửa hảng">
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" value="{{$model->email}}"
                                    placeholder="Email liên hệ của cửa hàng">
                            </div>
                            <div class="form-group">
                                <input type="text" name="facebook" class="form-control" value="{{$model->facebook}}"
                                    placeholder="Link facebook ( nếu có )">
                            </div>
                            <div class="form-group">
                                <input type="text" name="instagram" class="form-control" value="{{$model->instagram}}"
                                    placeholder="Link instagram ( nếu có )">
                            </div>
                            <div class="form-group">
                                <input type="text" name="twitter" class="form-control" value="{{$model->twitter}}"
                                    placeholder="Link twitter ( nếu có )">
                            </div>
                            <div class="form-group">
                                <input type="text" name="youtube" class="form-control" value="{{$model->youtube}}"
                                    placeholder="Link kênh youtube ( nếu có )">
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