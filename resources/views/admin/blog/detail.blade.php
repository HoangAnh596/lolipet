@section('title', 'Chi tiết tin tức')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('blog.index')}}">Danh sách tin
                            tức</a></li>
                    <li class="breadcrumb-item active">Chi tiết tin tức</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Ảnh tin tức</label>
                                <img class="form-control" style="width:100%; height: 100%"
                                    src="{{asset( 'storage/' . $blog->image)}}"
                                    alt="Tin tức này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <label for="">Tiêu đề tin tức</label>
                                <input type="text" class="form-control" value="{{$blog->title}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <input class="form-control" type="text"
                                    value="{{ ($blog->status == 1 ? 'Hiển thị' : 'Tạm ẩn hiển thị') }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Nội dung bài viết</label>
                                <div>
                                    {!!$blog->content!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <div class="col-6 mt-2"><br>
                            <div class="text-right">
                                <a href="{{route('blog.index')}}" class="btn btn-warning text-light">Quay lại</a>
                                <a href="{{route('blog.edit', ['id' => $blog->id])}}" class="btn btn-info">Sửa tin
                                    tức</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection