@section('title', 'Chi tiết phụ kiện')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('accessory.index')}}">Danh sách phụ
                            kiện</a></li>
                    <li class="breadcrumb-item active">Chi tiết phụ kiện</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <img class="img-custom-edit" src="{{asset( 'storage/' . $model->image)}}"
                                alt="phụ kiện này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <label for="">Tên phụ kiện</label>
                                @if($model->name)
                                <input type="text" name="name" class="form-control" value="{{$model->name}}" readonly>
                                @else
                                <div class="text-left">
                                    Chưa có thông tin
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục</label>
                                @if($model->category)
                                <input type="text" name="category_id" class="form-control"
                                    value="{{$model->category->name}}" readonly>
                                @else
                                <div class="text-left">
                                    Chưa có thông tin
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Số lượng</label>
                                @if($model->quantity)
                                <input type="text" name="quantity" class="form-control" value="{{$model->quantity}}"
                                    readonly>
                                @else
                                <div class="text-left">
                                    Chưa có thông tin
                                </div>
                                @endif
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
                                <label for="">Trạng thái</label>
                                <input class="form-control" type="text" name="status"
                                    value="{{ ($model->status == 1 ? 'Còn Hàng' : 'Hết hàng') }}" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Giá bán</label>
                                <input type="text" name="price" class="form-control" value="{{$model->price}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Ảnh phụ sản phẩm</label>
                                <table class="table table-stripped">
                                    <thead>
                                        <th>File</th>
                                        <th>Ảnh phụ sản phẩm</th>
                                    </thead>
                                    <tbody id="gallery">
                                        @foreach ($model->galleries as $gl)
                                        <tr id="{{$gl->id}}">
                                            <td>{{$gl->image_url}}</td>
                                            <td>
                                                <img src="{{asset('storage/' . $gl->image_url)}}" width="80">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Chi tiết phụ kiện:</label>
                                <textarea name="detail" class=form-control rows="10"
                                    readonly>{{$model->detail}}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="float-right">
                                <a href="{{route('accessory.index')}}" class="btn btn-danger text-light">Quay lại</a>
                                <a href="{{route('accessory.edit', ['id' => $model->id])}}" class="btn btn-info">Sửa danh
                                    mục</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')

@endsection