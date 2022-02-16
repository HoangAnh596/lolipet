@section('title', 'Sửa tin tức')
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
                    <li class="breadcrumb-item active">Sửa tin tức</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@include('layouts.admin.message')
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
                                <img class="img-custom-edit" src="{{asset( 'storage/' . $model->image)}}"
                                    alt="Tin tức này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!">
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <label for="">Tiêu đề tin tức</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{$model->title}}">
                                <span class="text-danger error_text title_error"></span>
                            </div>
                            <input type="hidden" name="slug" id="slug" value="{{$model->slug}}">
                            <div class="form-group">
                                <label for="">Danh mục bài viết</label>
                                <select class="form-control" name="category_blog_id" id="categories">
                                    <option value=""></option>
                                    @foreach($categoryBlog as $ctb)
                                    <option value="{{$ctb->id}}" @if($model->category_blog_id == $ctb->id) selected
                                        @endif>{{$ctb->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error_text category_blog_id_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Ảnh tin tức</label>
                                <input type="file" name="image" class="form-control">
                                <span class="text-danger error_text image_error"></span>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Trạng thái</label>
                                        <div class="form-control">
                                            <label class="pr-2">
                                                <input type="radio" name="status" value="1"
                                                    {{ ($model->status == 1 ? 'checked' : '') }}> Hiển thị
                                            </label>
                                            <label class="pl-2">
                                                <input type="radio" name="status" value="0"
                                                    {{ ($model->status == 0 ? 'checked' : '') }}> Tạm ẩn hiển thị
                                            </label>
                                        </div>
                                        <span class="text-danger error_text status_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Nội dung bài viết</label>
                                <textarea class="form-control" name="content" cols="30"
                                    rows="10">{{$model->content}}</textarea>
                                <span class="text-danger error_text content_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 mt-2"><br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Lưu</button>
                                <a href="{{route('category.index')}}" class="btn btn-danger">Hủy</a>
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
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script src="{{ asset('admin-theme/custom-js/custom.js') }}"></script>
<script>
function slugify(str) {
    str = str.replace(/^\s+|\s+$/g, '');
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
    var title = $('#title');
    var slug = $('#slug');
    title.keyup(function() {
        slug.val(slugify(title.val()));
    });
    tinymce.init({
        selector: 'textarea[name="content"]',
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        },
        width: 100 + '%',
        height: 800,
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
            xhr.open('POST', "{{route('blog.upload')}}");
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
});

$(".btn-info").click(function(e) {
    e.preventDefault();
    var formData = new FormData($('form')[0]);
    let titleValue = $('#title').val();
    let title = titleValue.charAt(0).toUpperCase() + titleValue.slice(1);
    formData.set('title', title);
    formData.append('slug', $('input[name="slug"]').val())
    $.ajax({
        url: "{{route('blog.saveEdit',['id'=>$model->id])}}",
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
            $('#realize').attr('href', data.url)
            $('#realize').text('Bài viết');
            if (data.status == 0) {
                $("#myModal").modal('show');
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
                $("#myModal").modal('show');
                $('.modal-body').html(
                    '<div class="alert alert-success" role="alert"><span class="fas fa-check-circle text-success mr-2"></span>' +
                    data.message + '</div>')
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