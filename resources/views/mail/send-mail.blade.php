<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send mail</title>
    <style>
    * {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        outline: none;
        border: none;
        text-decoration: none;
    }

    .container {
        max-width: 40rem;
        padding: 1rem;
        border: 0.1rem solid #f5f6f8;
        border-radius: 0.5rem;
        box-shadow: 1px 1px 1px #868080;
        background-color: #fff;
        margin: 1rem auto;
    }

    .container .logo {
        text-align: center;
    }

    .container .logo img {
        height: 5rem;
    }

    .container .thanks {
        font-size: 1rem;
        text-align: center;
        color: #6bb64a;
        margin: 1rem 0;
    }

    .container h2 {
        line-height: 2;
    }

    .container .title {
        font-size: 1rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .container .button {
        text-align: center;
    }

    .container .button a {
        position: relative;
        display: inline-block;
        padding: 1rem 2rem;
        font-size: 1rem;
        text-decoration: none;
        text-transform: uppercase;
        color: #fff;
        border-radius: 0.5rem;
        letter-spacing: 2px;
        overflow: hidden;
        background: linear-gradient(90deg, #6bb64a, #ccff33);
    }

    .bold {
        font-weight: bold;
    }

    .text-red {
        color: #F62217;
    }

    .container .note {
        padding: 1rem 0;
        line-height: 1.5;
    }

    .container table tbody tr td {
        line-height: 2;
        color: #868080;
    }

    .container table tbody tr td a {
        color: #1155cc;
    }

    .detail {
        padding-top: 1rem;
    }

    .detail p {
        line-height: 1.5;
    }

    .detail .space-between {
        padding-top: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .container .product {
        padding: 1rem 0;
    }

    .container .totail table {
        border-bottom: 1px solid #d8d8d8;
    }

    .container .delivery_status {
        padding-top: 1rem;
    }

    .container .footer {
        text-align: center;
        padding-top: 1rem;
    }

    .container .footer a {
        position: relative;
        display: block;
        padding: 1rem 2rem;
        font-size: 1rem;
        text-decoration: none;
        text-transform: uppercase;
        color: #fff;
        border-radius: 0.5rem;
        letter-spacing: 2px;
        overflow: hidden;
        background: linear-gradient(90deg, #6bb64a, #ccff33);
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <a href="https://lolipet.xyz/">
                <img src="{{asset('storage/' . $feedback['generalSetting'])}}" alt="">
            </a>
        </div>
        <p class="thanks">Cám ơn bạn đã đặt hàng tại LoliPetVN!</p>
        <h2>Xin chào {{$feedback['name_client']}},</h2>
        <p class="title">
            Cập nhật thông tin trạng thái đơn hàng của bạn - <span style="color: #F62217; font-weight: bold;">{{$feedback['delivery_status']}}</span>
        </p>
        <div class="button">
            <a href="{{ route('orderStatus',['code'=>$feedback['order_code']]) }}" class="bold" id="link">TÌNH TRẠNG ĐƠN HÀNG</a>
        </div>
        <p class="note">
            <span class="bold">*Lưu ý: </span>
            Bạn chỉ nên nhận hàng khi trạng thái đơn hàng là <span class="bold">Đang giao hàng </span> và nhớ kiểm tra
            <span class="bold">Mã đơn hàng</span>. Thông tin người gửi để nhận đúng kiện hàng nhé.
        </p>
        <div class="content">
            <p>Đơn hàng được giao đến:</p>
            <table cellpadding="2" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <td width="25%" valign="top" class="bold">Tên:</td>
                        <td valign="top">{{$feedback['name_client']}}</td>
                   </tr>
                    <tr>
                        <td valign="top" class="bold">Địa chỉ nhà:</td>
                        <td valign="top">{{$feedback['shipping_address']}}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="bold">Điện thoại:</td>
                        <td valign="top">{{$feedback['number_phone']}}</td>
                    </tr>
                    <tr>
                        <td valign="top" class="bold">Email:</td>
                        <td valign="top"><a href="{{$feedback['to_email']}}" target="_blank">{{$feedback['to_email']}}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="detail">
            <p>Mã đơn hàng: {{$feedback['order_code']}}</p>
            <div class="space-between">
                <span>Đặt vào: {{$feedback['date_time_order']}}</span>
            </div>
            <div class="product">
                <table cellpadding="0" cellspacing="0" style="width:100%">
                    <tbody>
                        @foreach($feedback['orderDetail'] as $value)
                            @if($value->product_type == 1)
                                @foreach($feedback['product'] as $valueP)
                                    @if($value->product_id == $valueP->id)
                                    <tr>
                                        <td style="width:40%">
                                            <div style="padding-right:10px">
                                                <a href="{{route('client.product.detail', ['id' => $valueP->slug])}}">
                                                    <img src="{{asset( 'storage/' . $valueP->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" style="width:100%;max-width:160px">
                                                </a>
                                            </div>
                                        </td>
                                        <td style="width:60%">
                                            <div>
                                                <a href="{{route('client.product.detail', ['id' => $valueP->slug])}}">
                                                    <span>{{$valueP->name}}</span>
                                                </a>
                                            </div>
                                            <div><span>{{number_format($valueP->price)}} VND</span></div>
                                            <div><span>Số lượng: {{$value->quantity}}</span></div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @else
                                @foreach($feedback['accessory'] as $valueP)
                                    @if($value->product_id == $valueP->id)
                                    <tr>
                                        <td style="width:40%">
                                            <div style="padding-right:10px">
                                                <a href="{{route('client.accessory.detail', ['id' => $valueP->slug])}}">
                                                    <img src="{{asset( 'storage/' . $valueP->image)}}" alt="Sản phẩm này hiện chưa có ảnh hoặc ảnh bị lỗi hiển thị!" style="width:100%;max-width:160px">
                                                </a>
                                            </div>
                                        </td>
                                        <td style="width:60%">
                                            <div>
                                                <a href="{{route('client.accessory.detail', ['id' => $valueP->slug])}}">
                                                    <span>{{$valueP->name}}</span>
                                                </a>
                                            </div>
                                            <div><span>{{number_format($valueP->price)}} VND</span></div>
                                            <div><span>Số lượng: {{$value->quantity}}</span></div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="totail">
                <table cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td valign="top" style="width:49%">Tạm tính:</td>
                            <td align="right" valign="top">{{$feedback['total']}} VND</td>
                        </tr>
                        <tr>
                            <td valign="top">Thuế:</td>
                            <td align="right" valign="top">{{$feedback['tax']}} VND</td>
                        </tr>
                        <tr>
                            <td valign="top" class="bold">Thành tiền:</td>
                            <td align="right" valign="top" class="bold text-red"  style="color: #F62217;">
                                {{$feedback['grand_total']}} VND
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="delivery_status">
                <table cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td valign="top">Hình thức thanh toán:</td>
                            <td align="right" valign="top">Thanh toán khi nhận hàng</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer">
            <a href="mailto:lolipetvn@gmail.com" target="_blank">lolipetvn@gmail.com</a>
        </div>
    </div>
</body>

</html>