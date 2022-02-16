@section('title', 'Thông tin tài khoản') @extends('layouts.admin.main') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item">
                        <a class="card-title" href="{{route('user.index')}}">Danh sách tài khoản</a>
                    </li>
                    <li class="breadcrumb-item active">Thông tin tài khoản</li>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-info card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{asset( 'storage/' . $user->avatar)}}" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{$user->name}}</h3>
                        @if(count($user->roles)>0) @foreach($user->roles as $ro)
                        <p class="text-muted text-center">{{$ro->name}}</p>
                        @endforeach @else
                        <p class="text-muted text-center">Khách hàng</p>
                        @endif

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Vai trò</b> 
                                @if(count($user->roles)>0) 
                                    @foreach($user->roles as $ro)
                                        <b class="float-right text-info">{{$ro->name}}</b> 
                                    @endforeach 
                                @else
                                    <b class="float-right text-info">Khách hàng</b>
                                @endif
                            </li>
                            <li class="list-group-item">
                                <b>Trạng thái</b>
                                <i class="{{ $user->status == 1 ? 'fa fa-check text-success' : 'fas fa-user-lock text-danger' }} float-right pr-3"></i>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-info card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Thông tin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="true">Số đơn hàng</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Tên tài khoản</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" value="{{$user->name}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Địa chỉ email</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="email" class="form-control" value="{{$user->email}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Số điện thoại</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="text" class="form-control" value="{{$user->phone}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Trạng thái</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="@if($user->status == 1) Hoạt động @else Tạm dừng hoạt động @endif" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">Vai trò</label>
                                    <div class="col-sm-10">
                                        @if(count($user->roles)>0) @foreach($user->roles as $rol)
                                        <input type="text" class="form-control" disabled value="{{$rol->name}}">
                                        @endforeach @else
                                        <input type="text" class="form-control" disabled value="Khách hàng">
                                        @endif
                                    </div>
                                </div>
                                @if(Auth::user()->id == $user->id)
                                    <div class="form-group row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <a href="{{route('user.edit', ['id' => $user->id])}}" class="btn btn-info">Cập nhật tài khoản</a>
                                        </div>
                                    </div>
                                @endif
                                @if(Auth::user()->hasPermissionTo('edit users'))
                                    @if( count($user->roles)>0 && $rol->name == 'Admin')
                                    <div class="form-group row">

                                    </div>
                                    @else
                                    <div class="form-group row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <a href="{{route('user.edit', ['id' => $user->id])}}" class="btn btn-info">Cập nhật tài khoản</a>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-3 col-form-label text-secondary">
                                        <i class="fas fa-stopwatch"></i>
                                        Số đơn chờ xử lí
                                    </label>
                                    <div class="col-sm-9 pt-2">
                                        <span class="btn btn-sm btn-info">
                                            <?php $number = 0; ?>
                                            @foreach($orders as $order)
                                                @if($order->delivery_status == 1)
                                                    <?php $number++ ?>  
                                                @endif
                                            @endforeach
                                            {{ $number }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-3 col-form-label text-info">
                                        <i class="fas fa-truck"></i>
                                        Số đơn đang giao
                                    </label>
                                    <div class="col-sm-9 pt-2">
                                        <span class="btn btn-sm btn-info">
                                            <?php $number = 0; ?>
                                            @foreach($orders as $order)
                                                @if($order->delivery_status == 2)
                                                    <?php $number++ ?>  
                                                @endif
                                            @endforeach
                                            {{ $number }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-3 col-form-label text-success">
                                        <i class="fas fa-check-circle"></i>
                                        Số đơn đã giao thành công
                                    </label>
                                    <div class="col-sm-9 pt-2">
                                        <span class="btn btn-sm btn-info">
                                            <?php $number = 0; ?>
                                            @foreach($orders as $order)
                                                @if($order->delivery_status == 3)
                                                    <?php $number++ ?>  
                                                @endif
                                            @endforeach
                                            {{ $number }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-3 col-form-label text-danger">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Số đơn đã hủy
                                    </label>
                                    <div class="col-sm-9 pt-2">
                                        <span class="btn btn-sm btn-info">
                                            <?php $number = 0; ?>
                                            @foreach($orders as $order)
                                                @if($order->delivery_status == 0)
                                                    <?php $number++ ?>  
                                                @endif
                                            @endforeach
                                            {{ $number }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-3 col-form-label text-warning">
                                        <i class="fas fa-times-circle"></i>
                                        Số đơn khách hủy
                                    </label>
                                    <div class="col-sm-9 pt-2">
                                        <span class="btn btn-sm btn-info">
                                            <?php $number = 0; ?>
                                            @foreach($orders as $order)
                                                @if($order->delivery_status == 4)
                                                    <?php $number++ ?>  
                                                @endif
                                            @endforeach
                                            {{ $number }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection