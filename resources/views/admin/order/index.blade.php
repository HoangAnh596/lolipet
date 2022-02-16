@section('title', 'Danh sách đơn hàng')
@extends('layouts.admin.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Danh sách đơn hàng</li>
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
                            <label for="">Trạng thái thanh toán</label>
                            <select class="form-control" name="payment_status" id="payment_status">
                                <option value="">Chọn trạng thái</option>
                                <option value="1">Chưa thanh toán</option>
                                <option value="2">Đã thanh toán</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Trạng thái đơn hàng</label>
                            <select class="form-control" name="delivery_status" id="delivery_status">
                                <option value="">Chọn trạng thái</option>
                                <option value="1">Đang chờ xử lý</option>
                                <option value="2">Đang giao hàng</option>
                                <option value="3">Giao hàng thành công</option>
                                <option value="0">Hủy đơn hàng</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                           <input type="date" name="created_at" id="created_at" class="form-control">
                        </div>
                    </div>
                     <div class="col-6">
                        <div class="form-group">
                           <input type="date" name="updated_at" id="updated_at" class="form-control">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="row">
                    <div style="width: 100%;">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table" style="width:100%">
                                <thead>
                                    <th>STT</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên khách hàng</th>
                                    <th>Thời gian</th>
                                    <th>Trạng thái</th>
                                    <th>Thanh toán</th>
                                    <th><span class="float-right mr-4">Lựa chọn</span></th>
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
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css')}}">
<script src="{{ asset('admin-theme/custom-js/custom.js')}}"></script>
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
        "order": [[ 3, "desc" ]],
        language: {
            processing: "<img width='70' src='{{ asset('client-theme/images/logo.png')}}'>",
        },
        serverSide: true,
        ajax: {
            url: "{{ route('order.filter') }}",
            data: function(d) {
                d.search = $('input[type="search"]').val();
                d.delivery_status = $('#delivery_status').val();
                d.payment_status = $('#payment_status').val();
                d.created_at = $('#created_at').val();
                d.updated_at = $('#updated_at').val();
            },
        },
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
            },
            {
                data: 'code',
                name: 'code',
            },
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'created_at',
                name: 'created_at',
            },
             {
                data: 'delivery_status',
                name: 'delivery_status',
            },
            {
                data: 'payment_status',
                name: 'payment_status',
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
    $('input').map(function(i,dom){
    var idSelect = $(dom).attr('id');
        $('#' + idSelect).change(function() {
            table.draw();
        });
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