@section('title', 'Lịch sử đặt hàng')
@extends('layouts.client.main')
@section('content')
@section('pageStyle')
<link rel="stylesheet" href="{{ asset('client-theme/css/account_info.css')}}">
<style>
        section.alert_order {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* padding: 0; */
            z-index: 1000;
            padding: 16% 30% 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
        }
        
        section.alert_order.active {
            display: block;
        }
        
        section.alert_order form {
            position: relative;
            padding: 5rem;
            background-color: #fff;
            border-radius: 0.5rem;
        }
        
        section.alert_order form .hd {
            width: 100%;
            margin: 1rem 0;
            display: block;
        }
        
        section.alert_order form .hd label {
            font-size: 1.6rem;
            font-weight: bold;
            color: #443;
        }
        
        section.alert_order form .close_alert {
            position: absolute;
            top: 1.2rem;
            right: 2rem;
            font-size: 2rem;
            cursor: pointer;
        }
        
        section.alert_order form input {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 0.1rem solid #333;
            border-radius: 0.5rem;
            display: block;
        }
        
        section.alert_order form .button {
            display: flex;
            align-items: center;
            justify-content: end;
            margin-top: 2rem;
        }
    </style>
@endsection
<!-- content -->
<section class="account-info">
        <div class="bread-crumb">
            <a href="{{route('client.home')}}">Trang chủ</a>
            <span>Quản lý đơn hàng</span>
        </div>
        <div class="account_info_container">
            <div class="content_page">
                <table class="greenTable">
                    <thead>
                        <tr>
                            <th colspan="3">Đơn hàng mã: {{$order->code}}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            @if($order->delivery_status == 1)
                                <th>
                                    @if(!empty($order->cancel_order))
                                        <a href="javascript:;" class="delete_order_success">Error</a>
                                    @else
                                        <button id="alert_cl" class="delete_order">Hủy đơn hàng</button>
                                    @endif
                                </th>
                            @else
                                <th></th>
                            @endif
                        </tr>
                        <tr>
                            <th style="min-width: 100px;">Sản phẩm</th>
                            <th>Ảnh</th>
                            <th style="min-width: 100px;">Thành tiền</th>
                            <th style="min-width: 100px;">Số lượng</th>
                            <th style="min-width: 81px;">Ngày mua</th>
                            <th style="min-width: 172px;">Trạng thái thanh toán</th>
                            <th style="min-width: 142px;">Trạng thái đơn hàng</th>
                        </tr>
                    </thead>
                    <tbody class="list-overflow">
                        @foreach($order->orderDetails as $orD)
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
                            <td  style="text-align: center;">{{$orD->quantity}}</td>
                            <td class="time">{{$orD->order->created_at->diffForHumans()}}</td>
                            <td  style="text-align: center;">
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
    <section class="alert_order" id="alert_order">
        <form action="{{route('cancel_order_t', ['id' => $order->id])}}" method="GET">
            @csrf
            <div class="close_alert">
                <i class="fas fa-times"></i>
            </div>
            <div class="hd">
                <label for="">Vui lòng nhập vào Email dùng để đặt hàng để hủy đơn hàng này.</label>
            </div>
            <input type="hidden" name="id" value="{{$order->id}}">
            <input type="text" name="email" placeholder="Nhập vào Email dùng để đặt hàng">
            <div class="button">
                <button type="submit" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')" class="btn-gray">Hủy đơn hàng</button>
            </div>
        </form>
    </section>
	<!-- content -->
@endsection

@section('pagejs')
    <script>
        const showModal = (openButton, modalContent) => {
            const openBtn = document.getElementById(openButton),
                modalContainer = document.getElementById(modalContent)

            if (openBtn && modalContainer) {
                openBtn.addEventListener('click', () => {
                    modalContainer.classList.add('active')
                })
            }
        }
        showModal('alert_cl', 'alert_order')
        const closeBtn = document.querySelectorAll('.close_alert')

        function closeModal() {
            const modalContainer = document.getElementById('alert_order')
            modalContainer.classList.remove('active')
        }
        closeBtn.forEach(c => c.addEventListener('click', closeModal))
        $(window).scroll(function() {
            $('section.alert_order').removeClass('active');
      })
    </script>
@endsection