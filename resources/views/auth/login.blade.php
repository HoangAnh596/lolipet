<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Đăng nhập</title>
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
    <section>
        <div class="page-header section-height-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-success text-gradient">ĐĂNG NHẬP</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" role="form text-left">
                                    @csrf
                                    @if(session('msg') != null)
                                    <div class="text-danger">{{session('msg')}}</div>
                                    @endif
                                    @if (session('success'))
                                    <div class="alert alert-success text-white" role="alert">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="email" class="h6">Email</label>
                                        <input id="email" type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Email" value="{{old('email')}}">
                                        @error('email') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="h6">Mật khẩu</label>
                                        <input id="password" name="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Mật khẩu">
                                        @error('password') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                                    </div>
                                    <!--<div class="form-check form-switch">-->
                                    <!--    <input class="form-check-input" type="checkbox" id="rememberMe">-->
                                    <!--    <label class="form-check-label" for="rememberMe">Remember me</label>-->
                                    <!--</div>-->
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-success w-100 mt-4 mb-0">Đăng
                                            nhập</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <small class="text-muted">
                                    Quên mật khẩu? Đặt lại mật khẩu của bạn
                                    <a href="{{ route('password.request') }}"
                                        class="text-success text-gradient font-weight-bold">tại đây</a>
                                </small>
                                <p class="mb-2 text-sm mx-auto">
                                    Bạn chưa có tài khoản?
                                    <a href="{{ route('register') }}"
                                        class="text-success text-gradient font-weight-bold">'Đăng ký'</a>
                                </p>
                                <div class="row px-xl-5 px-sm-4 px-3">
                                    <div class="position-relative text-center">
                                        <p
                                            class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">
                                            or
                                        </p>
                                    </div>
                                    <div class="col-12 me-auto px-1">
                                        <a class="btn btn-outline-dark w-100" href="/auth/redirect/"
                                            href="javascript:;">
                                            <svg width="24px" height="32px" viewBox="0 0 64 64" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <g id="Artboard" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">
                                                    <g id="google-icon" transform="translate(3.000000, 2.000000)"
                                                        fill-rule="nonzero">
                                                        <path
                                                            d="M57.8123233,30.1515267 C57.8123233,27.7263183 57.6155321,25.9565533 57.1896408,24.1212666 L29.4960833,24.1212666 L29.4960833,35.0674653 L45.7515771,35.0674653 C45.4239683,37.7877475 43.6542033,41.8844383 39.7213169,44.6372555 L39.6661883,45.0037254 L48.4223791,51.7870338 L49.0290201,51.8475849 C54.6004021,46.7020943 57.8123233,39.1313952 57.8123233,30.1515267"
                                                            id="Path" fill="#4285F4"></path>
                                                        <path
                                                            d="M29.4960833,58.9921667 C37.4599129,58.9921667 44.1456164,56.3701671 49.0290201,51.8475849 L39.7213169,44.6372555 C37.2305867,46.3742596 33.887622,47.5868638 29.4960833,47.5868638 C21.6960582,47.5868638 15.0758763,42.4415991 12.7159637,35.3297782 L12.3700541,35.3591501 L3.26524241,42.4054492 L3.14617358,42.736447 C7.9965904,52.3717589 17.959737,58.9921667 29.4960833,58.9921667"
                                                            id="Path" fill="#34A853"></path>
                                                        <path
                                                            d="M12.7159637,35.3297782 C12.0932812,33.4944915 11.7329116,31.5279353 11.7329116,29.4960833 C11.7329116,27.4640054 12.0932812,25.4976752 12.6832029,23.6623884 L12.6667095,23.2715173 L3.44779955,16.1120237 L3.14617358,16.2554937 C1.14708246,20.2539019 0,24.7439491 0,29.4960833 C0,34.2482175 1.14708246,38.7380388 3.14617358,42.736447 L12.7159637,35.3297782"
                                                            id="Path" fill="#FBBC05"></path>
                                                        <path
                                                            d="M29.4960833,11.4050769 C35.0347044,11.4050769 38.7707997,13.7975244 40.9011602,15.7968415 L49.2255853,7.66898166 C44.1130815,2.91684746 37.4599129,0 29.4960833,0 C17.959737,0 7.9965904,6.62018183 3.14617358,16.2554937 L12.6832029,23.6623884 C15.0758763,16.5505675 21.6960582,11.4050769 29.4960833,11.4050769"
                                                            id="Path" fill="#EB4335"></path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="col-6 mr-auto px-1">
                                        <a href="{{route('client.home')}}" class="text-success text-gradient font-weight-bold">
                                            <i class="fas fa-home"></i> {{ __('Trang chủ') }} <i class="fas fa-long-arrow-alt-left"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
	                    <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
	                        <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
	                            style="background-image:url('{{ asset('theme-bootstrap/assets/img/curved-images/1b201957aa96cf7a3427a5b25ee9a4bf_1024x1024.jpg')}}')"></div>
	                    </div>
	                </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>