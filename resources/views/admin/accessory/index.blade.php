@section('title', 'Danh sách phụ kiện')
@extends('layouts.admin.main')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Danh sách phụ kiện</li>
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
        <div class="card">
            <div class="card-body">
                <div class="alert alert-success" role="alert" style="display: none;">
                </div>
                @if(session('BadState'))
                <div class="alert alert-danger" role="alert">
                    {{session('BadState')}}
                </div>
                @endif
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">Chọn trạng thái</option>
                                <option value="0">Hết hàng</option>
                                <option value="1">Còn hàng</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Danh mục</label>
                            <select class="form-control" name="cate" id="cate">
                                <option value="">Lấy tất cả</option>
                                @foreach($categories as $c)
                                @if($c->category_type_id == 2)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="row">
                    <div style="width: 100%;">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table" style="width:100%">
                                <thead>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Tên phụ kiện</th>
                                    <th>Danh mục</th>
                                    <th>Giá bán</th>
                                    <th>Số lượng</th>
                                    <th>
                                        @if(Auth::user()->hasPermissionTo('add products'))
                                        <a href="{{route('accessory.add')}}" class="btn btn-outline-info float-right">Thêm phụ kiện</a>
                                        @else
                                        <a href="javascript:void(0);"
                                            onclick="alert('Bạn không được cấp quyền để thêm phụ kiện?')"
                                            class="btn btn-outline-info float-right">Thêm phụ kiện</a>
                                        @endif
                                    </th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css') }}">
<script src="{{ asset('admin-theme/custom-js/custom.js') }}"></script>
<script>
$(document).ready(function() {
    var table = $('.data-table').DataTable({
        responsive: true,
        processing: true,
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        dom: 'Bfrtip',
        buttons: [{
                text: 'Reload',
                action: function(e) {
                    table.ajax.reload();
                }
            },
            {
                text: 'Delete',
                action: function(e) {
                    e.preventDefault();
                    $("#myModal").modal('show');
                    var allId = [];
                    $('input:checkbox[name=checkPro]:checked').each(function() {
                        allId.push($(this).val());
                    })
                    if ('{{$admin}}') {
                        if (allId == '') {
                            $('.modal-body').html(
                                `<div class="alert alert-danger" role="alert">
                        <span class="fas fa-times-circle text-danger mr-2">
                        Hãy chọn danh mục để xóa
                        </span></div>`);

                            $('#realize').click(function(e) {
                                e.stopImmediatePropagation()
                                $("#realize").unbind('click');
                                $('#myModal').modal('toggle');
                            })
                        } else {
                            $('.modal-body').html(
                                `<div class="alert alert-success" role="alert">
                        <span class="fas fa-check-circle text-success mr-2">
                        Thực hiện xóa dữ liệu ( Lưu ý : sau khi khối phục dữ liệu tất cả những dữ liệu liên quan sẽ được xóa )
                        </span></div>`);

                            $('#realize').click(function(e) {
                                e.stopImmediatePropagation()
                                $("#realize").unbind('click');
                                $('#myModal').modal('toggle');
                                deleteMul('{{route("accessory.removeMul")}}', allId);
                                load(table);
                            })
                        }
                    } else {
                        $('.modal-body').html(
                            `<div class="alert alert-danger" role="alert">
                        <span class="fas fa-times-circle text-danger mr-2">
                        Bạn không đủ quyền để dùng chức năng này
                        </span></div>`);
                        $('#realize').css('display', 'none')
                        $('#cancel').click(function(e) {
                            $("#cancel").unbind('click');
                            $('#myModal').modal('toggle');
                        })
                    }
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                charset: 'utf-8',
                bom: true,
                fieldSeparator: ';',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'portrait',
                pageSize: 'LEGAL',
                orientation: 'landscape',
                exportOptions: {
                    columns: ':visible'
                }
            }, {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            "colvis"
        ],
        columnDefs: [{
            "orderable": false,
            "targets": 0
        }],
        "order": [],
        language: {
            processing: "<img width='70' src='{{ asset('client-theme/images/logo.png')}}'>",
        },
        serverSide: true,
        ajax: {
            url: "{{ route('accessory.filter') }}",
            data: function(d) {
                d.cate = $('#cate').val();
                d.status = $('#status').val();
                d.search = $('input[type="search"]').val();
            }
        },
        columns: [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false,
            },
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'category_id',
                name: 'category_id',
            },
            {
                data: 'price',
                name: 'price',
            },
            {
                data: 'status',
                name: 'status',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
    table.buttons().container().appendTo('.row .col-md-6:eq(0)');

    $(document).on("click", "#undoIndex", function() {
        $("#myModal").modal('show');
        $('.modal-body').html(
            `<div class="alert alert-success" role="alert">
                        <span class="fas fa-check-circle text-success mr-2">
                        Thực hiện khôi phục dữ liệu ( Lưu ý : sau khi khôi phục dữ liệu tất cả những dữ liệu liên quan sẽ được xóa )
                        </span></div>`);

        $('#realize').click(function(e) {
            e.stopImmediatePropagation()
            $("#realize").unbind('click');
            $('#myModal').modal('toggle');
            id = $('#undoIndex').data('id');
            var url = '{{route("accessory.restore",":id")}}';
            url = url.replace(':id', id);
            undoIndex(url, id)
            load(table);
        })
        $('#cancel').click(function(e) {
            $("#cancel").unbind('click');
            $('#myModal').modal('toggle');
        })

    })

    $('select').map(function(i, dom) {
        var idSelect = $(dom).attr('id');
        $('#' + idSelect).change(function() {
            table.draw();
        });
        $('#' + idSelect).select2({});
    })
});
</script>
@endsection