<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Đổi mật khẩu</title>
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
    <section class="h-100-vh mt-8">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>{{ __('Đổi mật khẩu') }}</h5>
                        </div>
                        <div class="card-body">
                            @if(session('success') || session('error'))
                            <p
                                class="@if(session('success')) text-success @elseif(session('error')) text-danger @endif">
                                {{ session()->get('success') }}{{ session()->get('error') }}
                            </p>
                            @endif
                            <form method="POST" role="form text-left">
                                @csrf
                                <div class="mb-3">
                                    <label for="">Mật khẩu hiện tại</label>
                                    <input wire:model="password" type="password"
                                        class="form-control @error('currentpassword') is-invalid @enderror"
                                        placeholder="Mật khẩu hiện tại" aria-label="Password" name="currentpassword"
                                        aria-describedby="password-addon" value="{{old('currentpassword')}}">
                                    @error('currentpassword') <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Mật khẩu mới</label>
                                    <input wire:model="password" type="password"
                                        class="form-control @error('newpassword') is-invalid @enderror"
                                        placeholder="Mật khẩu mới" aria-label="Password" name="newpassword"
                                        aria-describedby="password-addon" value="{{old('newpassword')}}">
                                    @error('newpassword') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Nhập lại mật khẩu mới</label>
                                    <input type="password"
                                        class="form-control @error('cfpassword') is-invalid @enderror"
                                        placeholder="Nhập lại mật khẩu" name="cfpassword" value="{{old('cfpassword')}}">
                                    @error('cfpassword') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Đổi mật
                                        khẩu</button>
                                </div>
                                <p class="text-sm mt-3 mb-0">{{ __('Quay lại ') }}
                                    <a href="{{ route('client.home') }}" class="text-dark font-weight-bolder">
                                        {{ __('trang chủ') }}
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