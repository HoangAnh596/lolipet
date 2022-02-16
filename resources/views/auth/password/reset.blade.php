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
                            <h4 class="mb-0 text-success">{{ __('Đặt lại mật khẩu?') }}</h4>
                        </div>
                        <div class="card-body">
                            @if(session('error') != null)
                                <div class="alert alert-success" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form method="POST" role="form text-left" action="/reset-password">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                                <div>
                                    <label for="password" class="h6 mt-2">{{ __('Mật khẩu mới') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mật khẩu mới" name="password" value="{{old('password')}}">
                                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div>
                                    <label for="password-confirm" class="h6 mt-2">{{ __('Nhập lại mật khẩu') }}</label>
                                    <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Nhập lại mật khẩu" name="password_confirmation" value="{{old('password_confirmation')}}">
                                    @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-success w-100 mt-4 mb-0">
                                        {{ __('Đặt lại mật khẩu') }}
                                    </button>
                                </div>
                            </form>
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