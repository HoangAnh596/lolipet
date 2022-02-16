@section('title', 'Add Role User')
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
                                <option value="">Chọn vai trò</option>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
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
                    <div class="card-header">Tài khoản</div>
                    <div class="card-body">
                        @foreach($users as $user)
                            <div class="form-group">
                            @if(count($user->roles)<=0)
                                <input type="checkbox" name="user_id[]" id="{{$user->id}}" value="{{$user->id}}" {{ in_array($user->id, old('user_id', [])) ? 'checked' : '' }}>
                                <label for="{{$user->id}}">{{$user->name}}</label>
                            @endif
                            </div> 
                        @endforeach
                        @error('user_id') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection