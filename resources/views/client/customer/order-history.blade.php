@section('title', 'Lịch sử đặt hàng')
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
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Số lượng</th>
                        <th style="min-width: 81px;">Ngày mua</th>
                        <th>Tổng tiền</th>
                        <th style="min-width: 142px;">Trạng thái đơn hàng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="list-overflow">
                    @foreach($order as $or)
                    <tr>
                        <td>{{(($order->currentPage()-1)*12) + $loop->iteration}}</td>
                        <td style="min-width: 120px;">{{$or->code}}</td>
                        <td>
                            {{count($or->orderDetails)}} Sản phẩm
                        </td>
                        <td class="time">{{$or->created_at->diffForHumans()}}</td>
                        <td>{{number_format($or->grand_total,0,',','.')}}đ</td>
                        <td>
                            @if($or->delivery_status == 1)
                            Đang chờ xử lý
                            @elseif($or->delivery_status == 2)
                            Đang giao hàng
                            @elseif($or->delivery_status == 3)
                            Giao hàng thành công
                            @elseif($or->delivery_status == 4)
                            Bạn đã hủy đơn hàng này
                            @elseif($or->delivery_status == 0)
                            Đơn hàng bị hủy
                            @else
                            Lỗi code
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('client.customer.order_history_detail', ['code' => $or->code]) }}">Chi
                                tiết</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paging">
                {{ $order->links('vendor.pagination.custom_blue') }}
            </div>
        </div>
    </div>
</section>
<!-- content -->
@endsection