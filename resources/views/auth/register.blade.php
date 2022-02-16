<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Đăng ký</title>
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
	<section class="mb-8">
        <div class="page-header align-items-start section-height-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('{{ asset('theme-bootstrap/assets/img/curved-images/pet-quotes.jpg')}}')">
            <span class="mask"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <!-- <h1 class="text-white mb-2 mt-5">{{ __('Welcome!') }}</h1> -->
                        <p class="text-lead text-dark">
                            <b>{{ __('Đăng ký sử dụng tài khoản giúp quản lý đơn hàng và trải nghiệm website của bạn được tốt hơn !') }}</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n12 mt-md-n11 mt-n10">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>{{ __('ĐĂNG KÝ TÀI KHOẢN') }}</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" role="form text-left">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Họ & tên" name="name" aria-describedby="email-addon"
                                        value="{{old('name')}}">
                                    @error('name') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email" aria-describedby="email-addon"
                                        value="{{old('email')}}">
                                    @error('email') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Số điện thoại" name="phone" aria-describedby="email-addon"
                                        value="{{old('phone')}}">
                                    @error('phone') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <input wire:model="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Mật khẩu" aria-label="Password" name="password"
                                        aria-describedby="password-addon" value="{{old('password')}}">
                                    @error('password') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="password"
                                        class="form-control @error('cfpassword') is-invalid @enderror"
                                        placeholder="Nhập lại mật khẩu" name="cfpassword" value="{{old('cfpassword')}}">
                                    @error('cfpassword') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Đăng ký</button>
                                </div>
                                <p class="text-sm mt-3 mb-0">{{ __('Bạn đã có tài khoản? ') }}
                                    <a href="{{ route('login') }}" class="text-dark font-weight-bolder">
                                        {{ __('Đăng nhập') }}
                                    </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>