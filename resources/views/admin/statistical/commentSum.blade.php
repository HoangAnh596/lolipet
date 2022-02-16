@section('title', 'Tổng bình luận')
@extends('layouts.admin.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">Tổng bình luận</li>
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
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <select class="form-control" id="time"></select>
                        </div>
                    </div>
                    <div class="col">
                        <button class=" btn btn-info" id="reset">Reset</button>
                    </div>
                </div>
                <div class="warpper">
                    <canvas id="myChart" style="height: 300px; display: block; box-sizing: border-box;"></canvas>
                    <div class="alert alert-light" id="emptyChart">Không có dữ liệu</div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('pagejs')
<link rel="stylesheet" href="{{ asset('admin-theme/custom-css/custom.css')}}">
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="{{ asset('admin-theme/custom-js/custom.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    $('#reset').click(function(e) {
        window.location.reload();
    });

    $('#emptyChart').hide()
    let Year = <?= json_encode($year) ?>;
    let count = <?= json_encode(count($year)) ?>;
    let minYear = Math.min.apply(Math, Year);
    var startYear = Math.min.apply(Math, Year);
    if (count == 1) {
        startYear = minYear - 1;
    }

    let endYear = Math.max.apply(Math, Year);


    for (i = endYear; i >= startYear; i--) {
        $('#time').append($('<option />').val(i).html(i));
    }

    var datas = <?= json_encode($data) ?>;

    if (datas == '') {
        $('#emptyChart').show(1500)
    } else {
        var max = Math.max.apply(Math, datas);
        if (max == 0) {
            $('#emptyChart').show(1500)
        }
    }
    var color = [];
    for (i = 0; i <= 11; i++) {
        color[i] = `rgb(${[1,2,3].map(x=>Math.random()*256|0)})`;
    }

    var months = [];
    for (var i = 0; i < 12; i++) {
        var d = new Date((i + 1) + '/1');
        months.push(d.toLocaleDateString(undefined, {
            month: 'short'
        }));
    }

    const data = {
        labels: months,
        datasets: [{
            label: 'Thống kê tổng bình luận theo tháng',
            data: datas,
            backgroundColor: color,
            hoverOffset: 4
        }]
    };
    const config = {
        type: 'bar',
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
                    text: 'Biểu đồ thống kê bình luận',
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
                    return this.height += 10;
                }
            }
        }]
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );


    $('#time').change(function(e) {
        console.log($('#time').val())
        $.ajax({
            url: "{{ route('statistical.commentSum') }}",
            type: 'GET',
            data: {
                time: $('#time').val()
            },
            success: function(data) {
                console.log(data)
                var max = Math.max.apply(Math, data.data);
                if (max == 0) {
                    $('#emptyChart').show(1500)
                } else {
                    $('#emptyChart').hide(300)
                }
                myChart.data.datasets[0].data = data.data
                myChart.update();
            },
        });
    })

    $('select').map(function(i, dom) {
        var idSelect = $(dom).attr('id');
        $('#' + idSelect).select2({});
    })
});
</script>
@endsection