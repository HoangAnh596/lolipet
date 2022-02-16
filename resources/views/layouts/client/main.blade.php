<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('title')">
    <meta name="keywords" content="Lolipet, Wibupet, lolipet, wibupet">
    <meta name="google-site-verification" content="U6Q61lgaHjS8xWh3nNQ8jqSahyhpzZldipGhy9-1G4M" />
    <title>@yield('title')</title>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CRPEJVP495"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CRPEJVP495');
</script>
    <!-- Css -->
    <link rel="icon" type="image/x-icon" href="{{ asset('client-theme/images/logo.png')}}">
    
    @include('layouts.client.style')
    @yield('pageStyle')
    <style>
    .zalo-chat-widget{
        left: 30px !important;
        bottom: 146px !important;
    }
    </style>
</head>

<body>
    <!-- Header - Start -->
    @include('layouts.client.header')
    <!-- Header - End -->

    <!-- Content Start -->
    @yield('content')
    <!-- Content End -->

    <!-- 
      * scroll to top 
      * start
    -->
    <button id="scrollToTop" class="scrollToTop">
        <i class="fas fa-chevron-up"></i>
    </button>
    <!-- 
      * scroll to top 
      * end
    -->
<!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div><br>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "580388089307574");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v12.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

<div class="zalo-chat-widget" data-oaid="3192202764043361564" data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="0" data-width="350" data-height="350"></div>

<script src="https://sp.zalo.me/plugins/sdk.js"></script>
    <!-- Footer - Start -->
    @include('layouts.client.footer')
    <!-- Footer - End -->
    <!-- JS -->
    @include('layouts.client.script')
    @yield('pagejs')
    <!-- end JS -->
</body>

</html>