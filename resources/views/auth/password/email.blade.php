<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <!-- Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('theme-bootstrap/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{ asset('theme-bootstrap/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('theme-bootstrap/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('theme-bootstrap/assets/css/soft-ui-dashboard.css')}}" rel="stylesheet" />
    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body>
    <div class="page-header section-height-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-8">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h4 class="mb-0 text-success">{{ __('Quên mật khẩu? Nhập địa chỉ Email của bạn tại đây') }}</h4>
                        </div>
                        <div class="card-body">
                            @if (session('message'))
                                <div class="alert alert-success text-white" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <form method="POST" role="form text-left">
                            @csrf
                                <div>
                                    <label for="email" class="h6">{{ __('Email') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Nhập vào địa chỉ email" value="{{old('email')}}">
                                    @error('email') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-success w-100 mt-4 mb-0">
                                        {{ __('Tiếp tục') }}
                                    </button>
                                </div>
                            </form>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1 mt-4">
	                            <!-- <small class="text-muted">
									Forgot you password? Reset you password
									<a href="{{ route('password.request') }}" class="text-success text-gradient font-weight-bold">here</a>
								</small> -->
	                            <p class="mb-4 text-sm mx-auto">
	                                Bạn chưa có tài khoản?
	                                <a href="{{ route('register') }}" class="text-success text-gradient font-weight-bold">Đăng ký tài khoản</a>
	                            </p>
	                            <p class="text-sm mt-3 mb-0">
                                    <a href="{{route('client.home')}}" class="text-success text-gradient font-weight-bold">
                                        <i class="fas fa-home"></i> {{ __('Trang chủ') }} <i class="fas fa-long-arrow-alt-left"></i>
                                    </a>
                                </p>
	                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                        <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                            style="background-image:url('{{ asset('theme-bootstrap/assets/img/curved-images/curved6.jpg')}}')"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>