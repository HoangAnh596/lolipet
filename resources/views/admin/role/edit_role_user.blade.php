@section('title', 'Sửa vai trò tài khoản')
@extends('layouts.admin.main')
@section('content')
<div class="container-fluid pt-4">
    <form action="" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Vai trò</div>
                    <div class="card-body">
                        <div class="form-group">
                            <select name="role_id" class="form-control">
                                <option value="">Chọn quyền hạn</option>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}" 
                                    @foreach($model_h_r as $ckk)
                                        @if($ckk->role_id == $role->id && $user->id == $ckk->model_id)
                                        selected
                                        @endif
                                    @endforeach
                                >{{$role->name}}</option>
                                @endforeach
                            </select>
                            @error('role_id') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('role.index')}}" class="btn btn-danger">Quay lại</a>
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Tên tài khoản</div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="user_id" class="form-control" value="{{$user->name}}" disabled>
                        </div> 
                        @error('user_id') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection