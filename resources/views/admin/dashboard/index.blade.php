@extends('layouts.admin.main')
@section('title', 'Dashboard')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <!-- <div class="card card-light my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Dashboard</li>
                </ol>
            </div>
        </div> -->
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <div class="row">
                        <div class="col">
                            <h5>Trang chủ</h5><br>
                            <span>Thống kê chi tiết các thông tin dữ liệu</span>
                        </div>
                        <div class="col col-sm-4">
                            <div class="info-box bg-light mb-0">
                                <div class="info-box-content">
                                <h4 class="info-box-text text-center text-info">
                                    Tổng doanh thu
                                </h4>
                                <h5 class="info-box-number text-center text-muted mb-0">
                                    {{number_format($doanh_thu,0,',','.')}} VND
                                </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-white">
                    <div class="inner pl-2">
                        <h3 class="text-info">
                            {{count($count_all_orders)}}
                        </h3>
                        <p>Tổng số đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="bg-info text-center pt-2 pb-2">
                        <p class="small-box-footer text-light"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-white">
                    <div class="inner pl-2">
                        <h3 class="text-warning">
                            {{$count_all_delivery_orders}}
                        </h3>
                        <p>Đơn hàng chờ xử lý</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-stopwatch"></i>
                    </div>
                    <div class="bg-warning text-center pt-2 pb-2">
                        <p class="small-box-footer text-light"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-white">
                    <div class="inner">
                        <h3 class="text-success">
                            {{$count_all_delivery_orders_success}}
                        </h3>
                        <p>Đơn hàng giao thành công</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="bg-success text-center pt-2 pb-2">
                        <p class="small-box-footer text-light"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-white">
                    <div class="inner pl-2">
                        <h3 class="text-danger">{{count($count_all_canceled_orders)}}</h3>
                        <p>Đơn hàng bị hủy trong tháng</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="bg-danger text-center pt-2 pb-2">
                        <p class="small-box-footer text-light"></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Thống kê đơn hàng
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="warpper">
                            <div class="alert alert-light" id="emptyChart">Không có dữ liệu</div>
                            <canvas id="myChart" style="height: 300px; display: block; box-sizing: border-box;"></canvas>
                        </div>
                    </div>
                </div>
            </section>
            <section class="col-lg-5 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-friends"></i>
                            Khách hàng mua nhiều
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Thông tin</th>
                                    <th class="text-center">Số đơn hàng</th>
                                    <th>Thu được (VND)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userName as $key => $user)
                                <tr>
                                    <td>
                                        <p class="h6">{{$user}}</p>
                                        @foreach($userPhone as $key1 => $phone)
                                        @if($key == $key1)
                                        <small class="text-muted">{{$phone}}</small>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @foreach($countOrder as $key1 => $countOrd)
                                        @if($key == $key1)
                                        <span class="badge badge-danger mx-auto">
                                            {{$countOrd}}
                                        </span>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($sumOrder as $key1 => $sum)
                                        @if($key == $key1)
                                            {{number_format($sum,0,',','.')}} VNĐ
                                        @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- right col -->
        </div>
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Sản phẩm thú cưng bán chạy tháng này
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Người mua</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataPet as $key => $sell)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>
                                        @foreach($namePet as $key1 => $sel)
                                            @if($key == ++$key1)
                                            {{$sel}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$sell}}
                                    </td>
                                    <td>
                                        @foreach($userPet as $key1 => $sel)
                                        @if($key == ++$key1)
                                        {{$sel}}
                                        @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <section class="col-lg-5 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Sản phẩm phụ kiện bán chạy tháng này
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Người mua</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataAcc as $key => $sell)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>
                                        @foreach($nameAcc as $key1 => $sel)
                                        @if($key == ++$key1)
                                        {{$sel}}
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$sell}}
                                    </td>
                                    <td>
                                        @foreach($userAcc as $key1 => $sel)
                                        @if($key == ++$key1)
                                        {{$sel}}
                                        @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css')}}">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="{{ asset('admin-theme/custom-js/custom.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {

    $('#emptyChart').hide()

    var datas = <?= json_encode($data) ?>;
    var count = <?= json_encode($count) ?>;

    if (count == '') {
        $('#emptyChart').show(1500)
    } else {
        var max = Math.max.apply(Math, count);
        if (max == 0) {
            $('#emptyChart').show(1500)
        }
    }

    var color = [
        "#FFD700",
        "#ff8b01",
        "#1878b9",
        "#77b70a",
        "#F62217",
    ];

    const data = {
        labels: datas,
        datasets: [{
            label: 'My First Dataset',
            data: count,
            backgroundColor: color,
            hoverOffset: 4
        }]
    };
    const config = {
        type: 'pie',
        data: data,
        options: {
            plugins: {
                legend: {
                    labels: {
                        margin: 40
                    }
                },
                title: {
                    display: true,
                    text: 'Biểu đồ thống kê đơn hàng',
                    font: {
                        size: 14
                    }
                }
            },
            radius: '70%',
            responsive: true,
            maintainAspectRatio: false,

        },
        plugins: [{
            beforeInit: function(chart, legend, options) {
                const fitValue = chart.legend.fit;
                chart.legend.fit = function fit() {
                    fitValue.bind(chart.legend)();
                    return this.height -= 10;
                }
            }
        }]
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
});
</script>
@endsection