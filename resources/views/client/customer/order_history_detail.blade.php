@section('title', 'Lịch sử mua hàng')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/account_info.css')}}">
@endsection
<!-- content -->
<section class="account-info">
    <div class="bread-crumb">
        <a href="{{route('client.home')}}">Trang chủ</a>
        <span>Quản lý đơn hàng</span>
    </div>
    <div class="account_info_container">
        @include('client.customer.nav_bar_customer')
        <div class="content_page">
            <table class="greenTable">
                <thead>
                    @if($order->delivery_status == 1)
                        <tr>
                            <th>Chi tiết đơn hàng mã: {{$order->code}}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>
                                @if(!empty($order->cancel_order))
                                    <a href="javascript:;" class="delete_order_success">Error</a>
                                @else
                                    <a href="{{route('cancel_order', ['id' => $order->id])}}" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')" class="delete_order">Hủy đơn hàng</a>
                                @endif
                            </th>
                        </tr>
                    @endif
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Thành tiền</th>
                        <th>Số lượng</th>
                        <th style="min-width: 81px;">Ngày mua</th>
                        <th style="min-width: 172px;">Trạng thái thanh toán</th>
                        <th style="min-width: 142px;">Trạng thái đơn hàng</th>
                    </tr>
                </thead>
                <tbody class="list-overflow">
                    @foreach($orderDetail as $orD)
                    <tr>
                        @if($orD->product_type == 1)
                        <td>{{$orD->product->name}}</td>
                        <td>
                            <a href="{{route('client.product.detail', ['id' => $orD->product->slug])}}">
                                <img src="{{asset( 'storage/' . $orD->product->image)}}"
                                    alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" width="100">
                            </a>
                        </td>
                        @else
                        <td>{{$orD->accessory->name}}</td>
                        <td>
                            <a href="{{route('client.accessory.detail', ['id' => $orD->accessory->slug])}}">
                                <img src="{{asset( 'storage/' . $orD->accessory->image)}}"
                                    alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" width="100">
                            </a>
                        </td>
                        @endif
                        <td>{{number_format($orD->price,0,',','.')}}đ</td>
                        <td>{{$orD->quantity}}</td>
                        <td class="time">{{$orD->order->created_at->diffForHumans()}}</td>
                        <td>
                            {{$orD->payment_status}}
                        </td>
                            <td>
                                @if($order->delivery_status == 4)
                                    Bạn đã hủy đơn hàng này
                                @else
                                    {{$orD->delivery_status}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- content -->
@endsection