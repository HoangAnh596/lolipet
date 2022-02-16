@section('title', 'So sánh')
@extends('layouts.admin.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item card-title">So sánh</li>
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
                            <input type="month" id="time" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <button class=" btn btn-info" id="reset">Reset</button>
                    </div>
                </div>
                <div class="warpper">
                    <div class="alert alert-light" id="emptyChart">Không có dữ liệu</div>
                    <canvas id="myChart" style="height: 300px; display: block; box-sizing: border-box;"></canvas>
                </div>
            </div>
        </div>
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
    $('#reset').click(function(e) {
        window.location.reload();
    });

    $('#emptyChart').hide()

    var datas = <?= json_encode($data) ?>;
    var labels = <?= json_encode($labels) ?>;

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

    const data = {
        labels: labels,
        datasets: [{
            label: 'My First Dataset',
            data: datas,
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
                    text: 'Biểu đồ thống kê so sánh thể loại',
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


    $('#time').change(function(e) {
        $.ajax({
            url: "{{ route('statistical.compare') }}",
            type: 'GET',
            data: {
                time: $('#time').val()
            },
            success: function(data) {
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
});
</script>
@endsection