@section('title', 'Phân quyền tài khoản') @extends('layouts.admin.main') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Phân quyền tài khoản</li>
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
    <div class="container-fluid pb-1">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Vai trò
                        <div class="float-right">
                            @hasanyrole('Admin')
                            <a href="{{route('role.user.add')}}" class="btn btn-success">Gán vai trò cho tài khoản</a>
                            <a href="{{route('role.permission.add')}}" class="btn btn-info">Tạo vai trò</a> @endhasanyrole
                        </div>
                    </div>
                    <div class="card-body table-responsive pad">
                        @if(session('success') != null || session('danger') != null)
                        <div class="alert @if (session('success')) alert-success @else alert-danger @endif alert-dismissible fade show" role="alert">
                            <strong>@if (session('success')) Success @else Error @endif</strong> {{session('success') }} {{ session('danger') }}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Vai trò</th>
                                    <th>Quyền hạn</th>
                                    <th class="text-right">Lựa chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        @if(count($role->permissions)>0) @foreach($role->permissions as $permission)
                                        <span class="badge badge-success">{{$permission->name}}</span> @endforeach @else
                                        <span class="badge badge-danger">Không có quyền hạn</span> @endif
                                    </td>
                                    <td class="text-right" style="min-width: 10rem;">
                                        @if($role->id == 1)
                                            <a href="javascript:;" class="btn btn-info disabled">Sửa</a>
                                            <a href="javascript:;" class="btn btn-danger disabled">Xóa</a>
                                        @else
                                            <a href=" {{route('role.edit', ['id' => $role->id])}}" class="btn btn-info">Sửa</a>
                                            <a href="{{route('role.remove', ['id' => $role->id])}}" onclick="return confirm('Bạn có chắc muốn xóa Role này?')" class="btn btn-danger">Xóa</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Tài khoản</div>
                    <div class="card-body table-responsive pad">
                        @if(session('success_user') != null || session('danger_user') != null)
                            <div class="alert @if (session('success_user')) alert-success @else alert-danger @endif alert-dismissible fade show" role="alert">
                                <strong>@if (session('success_user')) Success @else Error @endif</strong> {{session('success_user') }} {{ session('danger_user') }}.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Vai trò</th>
                                    <th class="text-right">Lựa chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    @if(count($user->roles)>0)
                                        <tr>
                                            <td>
                                                {{$user->name}}
                                            </td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                    <span class="badge badge-success">{{$role->name}}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-right">
                                                @if($role->id == 1)
                                                    <a href="javascript:;" class="btn btn-warning text-light disabled">Sửa vai trò</a>
                                                    <a href="javascript:;" class="btn btn-danger disabled">Xóa vai trò</a>
                                                @else
                                                    <a href="{{route('role.user.edit', ['id' => $user->id])}}" class="btn btn-warning text-light">Sửa vai trò</a>
                                                    <a href="{{route('role.user.remove', ['id' => $user->id])}}" onclick="return confirm('Bạn có chắc muốn xóa Role của User này?')" class="btn btn-danger">Xóa vai trò</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection