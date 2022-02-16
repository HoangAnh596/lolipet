@section('title', 'Tạo giới tính')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('age.index')}}">Danh sách giới
                            tính</a>
                    </li>
                    <li class="breadcrumb-item active">Tạo giới tính</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
@include('layouts.admin.message')
<!-- Main content -->
<section class="content">
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Giới tính</label>
                                <input type="text" name="gender" id="gender" class="form-control"
                                    placeholder="Giới tính">
                                <span class="text-danger error_text gender_error"></span>
                            </div>
                        </div>
                        <div class="col mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('gender.index')}}" class="btn btn-danger">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script src="{{ asset('admin-theme/custom-js/custom.js') }}"></script>
<script>
$(document).ready(function() {
    $(".btn-info").click(function(e) {
        e.preventDefault();
        var formData = new FormData($('form')[0]);
        let genderValue = $('#gender').val();
        let gender = genderValue.charAt(0).toUpperCase() + genderValue.slice(1);
        formData.set('gender', gender);
        $.ajax({
            url: "{{route('gender.saveAdd')}}",
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
                $('#realize').text('Giới tính');
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
});
</script>
@endsection