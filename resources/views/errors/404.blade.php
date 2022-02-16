<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404</title>
    <link rel="stylesheet" href="{{ asset('client-theme/css/style.css')}}">
</head>

<body>
    <section class="products">
        <div class="errors_page">
            <h2 class="title">404</h2>
            <p class="note">
                Không tìm thấy trang
                <a class="back" href="{{route('client.home')}}">Quay lại trang chủ</a>
            </p>
            <!-- <h2>{{ $exception->getMessage() }}</h2> -->
        </div>
    </section>
</body>

</html>