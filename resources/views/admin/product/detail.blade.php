@section('title', 'Chi tiết sản phẩm')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('product.index')}}">Danh sách sản
                            phẩm</a></li>
                    <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
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
                            <div class="form-group">
                                <label for="">Ảnh sản phẩm</label>
                                <img class="img-custom-edit"
                                    src="{{ (strpos($model->image, 'uploads/products/')=== false ? $model->image : asset('storage/' . $model->image)) }}"
                                    alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <label for="">Tên sản phẩm</label>
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
                                <label for="">Giống loài</label>
                                @if($model->breed)
                                <input type="text" name="breed_id" class="form-control" value="{{$model->breed->name}}"
                                    readonly>
                                @else
                                <div class="text-left">
                                    Chưa có thông tin
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
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
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Cân nặng</label>
                                @if($model->weight)
                                <input type="text" name="weight" class="form-control" value="{{$model->weight}} kg"
                                    readonly>
                                @else
                                <div class="text-left">
                                    Chưa có thông tin
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Giá bán</label>
                                @if($model->price)
                                <input type="text" name="price" class="form-control" value="{{$model->price}}" readonly>
                                @else
                                <div class="text-left">
                                    Chưa có thông tin
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tuổi của thú cưng</label>
                                @if($model->age)
                                <input type="text" name="age_id" class="form-control" value="{{$model->age->age}}"
                                    readonly>
                                @else
                                <div class="text-left">
                                    Chưa có thông tin
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
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
                                <label for="">Giới tính</label>
                                @if($model->gender)
                                <input class="form-control" type="text" name="gender_id"
                                    value="{{ ($model->gender_id == 1 ? 'Giống đực' : ($model->gender_id == 2 ? 'Giống cái' : 'Lưỡng tính')) }}"
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
                        <div class="col-md-12 mt-2 mb-2">
                            <div class="form-group">
                                <label for="">Ảnh phụ sản phẩm</label>
                                @if($model->galleries != null)
                                <table class="table table-stripped">
                                    <thead>
                                        <th>File</th>
                                        <th>Ảnh hiển thị</th>
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
                        <div class="col-12 m-1">
                            <div class="form-group">
                                <label for="">Chi tiết sản phẩm:</label>
                                @if($model->description)
                                <p>{!!$model->description!!}</p>
                                @else
                                <div class="text-left">
                                    Chưa có thông tin
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="float-right">
                                <a href="{{route('product.index')}}" class="btn btn-warning text-light">Quay lại</a>
                                <a href="{{route('product.edit', ['id' => $model->id])}}" class="btn btn-info">Sửa sản phẩm</a>
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