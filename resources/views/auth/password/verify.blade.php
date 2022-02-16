<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send mail Forgot Password</title>
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
        margin-bottom: 1rem;
    }

    .container .logo img {
        height: 5rem;
    }

    h2 {
        text-align: center;
        font-size: 1.7rem;
        padding: 1rem 0;
    }

    .container .content p {
        line-height: 2;
        font-size: 1.2rem;
    }

    .container .content p a {
        color: #1878b9;
        text-decoration: underline;
    }

    .bold {
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <a href="#">
                <img src="http://lolipet.xyz/client-theme/images/logo_full.png" alt="">
            </a>
        </div>
        <h2>Đặt lại mật khẩu</h2>
        <div class="content">
            <p>Kính Gửi: <span class="bold">{{$feedback['name_client']}}</span>,</p>
            <p>Yêu cầu đặt lại mật khẩu của bạn đã được thông qua.</p>
            <p>Vui lòng <a href="{{ route('resetPassword',['token'=>$feedback['token']]) }}">click here</a> để cập nhật
                lại mật khẩu của mình.</p>
        </div>
    </div>
</body>

</html>