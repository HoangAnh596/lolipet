@section('title', 'Chi tiết đơn hàng')
@extends('layouts.admin.main') 
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="card card-white my-0">
            <div class="card-header">
                <ol class="breadcrumb float-sm-left ">
                    <li class="breadcrumb-item"><a class="card-title" href="{{route('order.index')}}">Thay đổi trạng thái Đơn hàng</a></li>
                    <li class="breadcrumb-item active">Chi tiết Đơn hàng</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
            <div class="card-header">
                Chi tiết đơn hàng
            </div>
                <div class="card-body table-responsive pad">
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Trạng thái thanh toán</label>
                                @foreach($orderDetail as $orD)
                                    @if($orD->order_id == $order->id)
                                        <input class="form-control" type="text" value="{{$orD->payment_status}}" disabled>
                                        @break
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Trạng thái đơn hàng</label>
                                @foreach($orderDetail as $orD)
                                    @if($orD->order_id == $order->id && $orD->delivery_status == 4)
                                        <input class="form-control" type="text" value="{{$orD->delivery_status}}" disabled>
                                        @break
                                    @else
                                        <input class="form-control" type="text" value="{{$orD->delivery_status}}" disabled>
                                        @break
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div>
                                    <b>Khách hàng: </b>
                                    <b>{{$order->name}}</b>
                                </div>
                                <div>
                                    <b>Email: </b>
                                    <span>{{$order->email}}</span>
                                </div>
                                <div>
                                    <b>Số điện thoại: </b>
                                    <span>{{$order->phone}}</span>
                                </div>
                                <div>
                                    <b>Địa chỉ giao hàng: </b>
                                    <span>{{$order->shipping_address}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">Mã đơn hàng</div>
                                    <div class="col">{{$order->code}}</div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">Trạng thái thanh toán</div>
                                    <div class="col">
                                        <span class="btn 
                                            @if($order->payment_status == 1)
                                                btn-danger
                                            @elseif($order->payment_status == 2)
                                                btn-success
                                            @else
                                                btn-danger
                                            @endif
                                        btn-sm text-light">
                                            @if($order->payment_status == 1)
                                                Chưa thanh toán
                                            @elseif($order->payment_status == 2)
                                                Đã thanh toán
                                            @else
                                                Lỗi code
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">Ngày đặt hàng</div>
                                    <div class="col">{{$order->created_at->format('d/m/Y')}}</div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">Tổng cộng</div>
                                    <div class="col">{{number_format($order->grand_total,0,',','.')}} VND</div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col">Phương thức thanh toán</div>
                                    <div class="col">Thanh toán khi nhận hàng</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-center">Ảnh</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Hình thức giao hàng</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Giá bán</th>
                                    <th scope="col">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderDetail as $key => $value)
                                <tr>
                                    <th scope="row">{{++$key}}</th>
                                    @if($value->product_type == 1)
                                        <td class="text-center"><img src="{{asset( 'storage/' . $value->product->image)}}" alt="" width="70"></td>
                                        <td>{{$value->product->name}}</td>
                                    @else
                                        <td class="text-center"><img src="{{asset( 'storage/' . $value->accessory->image)}}" alt="" width="70"></td>
                                        <td>{{$value->accessory->name}}</td>
                                    @endif
                                    <td>Giao hàng tận nhà</td>
                                    <td>{{$value->quantity}}</td>
                                    <td>
                                        <?php
                                            $tinh = $value->price/$value->quantity;
                                            echo number_format($tinh,0,',','.') . ' VND';
                                        ?> / sản phẩm
                                    </td>
                                    <td>{{number_format($value->price,0,',','.')}} VND</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-9"></div>
                        <div class="col-3">
                            <div class="form-group">
                                <div class="row border-bottom mt-1 mb-1">
                                    <div class="col form-group">Tạm tính</div>
                                    <div class="col form-group text-right">
                                        <?php
                                            $total = $value->order->grand_total - $value->tax;
                                            echo number_format($total,0,',','.') . ' VND';
                                        ?>
                                    </div>
                                </div>
                                <div class="row border-bottom mt-1 mb-1">
                                    <div class="col form-group">Giảm giá</div>
                                    <div class="col form-group text-right">{{number_format($value->order->coupon_discount,0,',','.')}} VND</div>
                                </div>
                                <div class="row border-bottom mt-1 mb-1">
                                    <div class="col form-group">Thuế</div>
                                    <div class="col form-group text-right">{{number_format($value->tax,0,',','.')}} VND</div>
                                </div>
                                <div class="row border-bottom mt-1 mb-1">
                                    <div class="col form-group"><b>Thành tiền</b></div>
                                    <div class="col form-group text-right"><b>{{number_format($value->order->grand_total,0,',','.')}} VND</b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 text-right">
                            <a href="{{route('order.index')}}" class="btn btn-danger">Quay lại</a>
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
