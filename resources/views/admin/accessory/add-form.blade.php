@section('title', 'Thêm phụ kiện')
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
                    <li class="breadcrumb-item active">Thêm phụ kiện</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@include('layouts.admin.message')
<!-- Main content -->
<section class="content">
    <div class="container-fluid pb-1">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tên phụ kiện</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Tên phụ kiện">
                                <span class="text-danger error_text name_error"></span>
                            </div>
                        </div>
                        <input type="hidden" name="slug" id="slug" value="">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Ảnh phụ kiện</label>
                                <input type="file" name="image" class="form-control">
                                <span class="text-danger error_text image_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Danh mục</label>
                                <select name="category_id" id="category" class="form-control">
                                    <option value=""></option>
                                    @foreach($category as $c)
                                    @if($c->category_type_id == 2)
                                    <option value="{{$c->id}}" @if($c->id == old('category_id')) selected
                                        @endif>{{$c->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <span class="text-danger error_text category_id_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <select name="status" id="status" class="form-control">
                                    <option value=""></option>
                                    <option value="1">Còn hàng</option>
                                    <option value="0">Hết hàng</option>
                                </select>
                                <span class="text-danger error_text status_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Số lượng</label>
                                <input type="text" name="quantity" class="form-control" placeholder="Số lượng phụ kiện">
                                <span class="text-danger error_text quantity_error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Giá bán</label>
                                <input type="text" name="price" class="form-control" placeholder="Giá bán">
                                <span class="text-danger error_text price_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <label for="">Thông tin phiếu giảm giá</label>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col"><label for="">Giảm giá</label>
                            <input type="text" class="form-control" name="discount" placeholder="Giảm giá">
                            <span class="text-danger error_text discount_error"></span>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Kiểu giảm giá</label>
                                <select name="discount_type" id="discount_type" class="form-control">
                                    <option value=""></option>
                                    @foreach($discountType as $dt)
                                    <option value="{{$dt->id}}">{{$dt->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error_text discount_type_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Ngày bắt đầu</label>
                                <input type="datetime-local" class="form-control" name="discount_start_date" id="start">
                                <span class="text-danger error_text discount_start_date_error"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Ngày kết thúc</label>
                                <input type="datetime-local" class="form-control" name="discount_end_date" id="end">
                                <span class="text-danger error_text discount_end_date_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <label for="">Ảnh phụ sản phẩm</label>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-stripped">
                                <thead>
                                    <th>File</th>
                                    <th>Ảnh hiển thị</th>
                                    <th class="text-right">
                                        <button class="btn btn-success add-img float-right" type="button">Thêm
                                            ảnh</button>
                                    </th>
                                </thead>
                                <tbody id="gallery">

                                </tbody>
                            </table>
                            <span class="text-danger error_text galleries_error"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Chi tiết phụ kiện:</label>
                            <textarea name="detail" class=form-control rows="10"></textarea>
                            <span class="text-danger error_text detail_error"></span>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <a href="{{route('accessory.index')}}" class="btn btn-danger">Hủy</a>
                        <button type="submit" class="btn btn-info ml-2">Lưu</button>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script src="{{ asset('admin-theme/custom-js/custom.js') }}"></script>
<script>
function slugify(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();
    var from = "ạảầấậẩẫăằắặẳẵãàáäâẹẻềếệểễẽèéëêìíịĩỉïîọỏõồốộổỗơờớợởỡõòóöôụủũưừứựửữùúüûñçỳýỵỷỹđ·/_,:;";
    var to = "aaaaaaaaaaaaaaaaaaeeeeeeeeeeeeiiiiiiiooooooooooooooooooouuuuuuuuuuuuuncyyyyyd------";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }
    str = str.replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    return str;
}
$(document).ready(function() {
    var name = $('#name');
    var slug = $('#slug');
    name.keyup(function() {
        slug.val(slugify(name.val()));
    });
    tinymce.init({
        selector: 'textarea', // change this value according to your HTML
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        },
        width: 100 + '%',
        height: 300,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks code fullscreen insertdatetime media nonbreaking',
            'table emoticons template paste help'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | link image | print preview media fullpage | ' +
            'forecolor backcolor emoticons | help',
        menu: {
            favs: {
                title: 'My Favorites',
                items: 'code visualaid | searchreplace | emoticons'
            }
        },
        menubar: 'favs file edit view insert format tools table',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        relative_urls: false,
        images_upload_handler: function(blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', "{{route('accessory.upload')}}");
            var token = '{{csrf_token()}}';
            xhr.setRequestHeader("X-CSRF-Token", token);
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }
    });
    $('.add-img').click(function() {
        var rowId = Date.now();
        $('#gallery').append(`
                    <tr id="${rowId}">
                        <td>
                            <div class="form-group">
                                <input row_id="${rowId}" type="file" name="galleries[]" class="form-control" onchange="loadFiles(event, ${rowId})">
                            </div>
                        </td>
                        <td>
                            <img row_id="${rowId}" src=""  width="80">
                        </td>
                        <td class="text-right">
                            <button class="btn btn-danger" onclick="removeImg(this)">Xóa</button>
                        </td>
                    </tr>
                `);
    })
});

$(".btn-info").click(function(e) {
    e.preventDefault();
    var formData = new FormData($('form')[0]);
    let nameValue = $('#name').val();
    let name = nameValue.charAt(0).toUpperCase() + nameValue.slice(1);
    formData.set('name', name);
    formData.append('slug', $('input[name="slug"]').val())
    formData.set('discount_start_date', dateTime($("#start").val()))
    formData.set('discount_end_date', dateTime($("#end").val()))
    $.ajax({
        url: "{{route('accessory.saveAdd')}}",
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
            $('#realize').text('Phụ kiện')
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
</script>
@endsection