<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>


    <meta charset="{{ config('app.charset') }}">

    <meta name="viewport" content="{{ __('width=device-width, initial-scale=1') }}">
    <meta name="copyright" content="{{ __('Maan News') }}">
    <meta name="robots" content="{{ __('Maan News') }}">
    <meta http-equiv="X-UA-Compatible" content="{{ __('IE=edge') }}">

    @yield('meta_content')

    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="630"/>

    <title>{{ $siteInfo['site_title'] }}</title>

    <link rel="shortcut icon"
          href="{{ $siteInfo['favicon'] ? asset('media/'.$siteInfo['favicon']) : asset('backend/images/favicon.ico') }}"
          type="image/x-icon">
    <link rel="icon"
          href="{{ $siteInfo['favicon'] ? asset('media/'.$siteInfo['favicon']) : asset('backend/images/favicon.ico') }}"
          type="image/x-icon">
    <!-- Apple Favicon -->
    <!-- All Device Favicon -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('frontend/fontawesome/all.css') }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('frontend/fonts/fonts.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/fonts/front_clock.css') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('frontend/css/normalize.css') }}">
    <!-- Default -->
    <link rel="stylesheet" href="{{ asset('frontend/css/default.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <!-- Venobox -->
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}">
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <!-- Responsive -->
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <!-- toastr -->
    <link rel="stylesheet" href="{{ asset('backend/toastr/toastr.css') }}">


    @if (@$siteInfo['header_code'] != null)
        <!-- Global site tag (gtag.js) - Google Analytics -->
        {!! $siteInfo['header_code'] !!}
    @endif


</head>

<body>

<div id="main-wrapper">
    <header class="sticky-manu">
        <!-- Maan Top Bar Start -->
        @include('frontend.layouts._topheader')
        <!-- Maan Top Bar End -->
        <!-- Maan Mid Bar Start -->
        @include('frontend.layouts._header')
        <!-- Maan Mid Bar End -->
        <!-- Maan Manu Bar Start -->
        @include('frontend.layouts._menu')
        <!-- Maan Manu Bar End -->
    </header>
    <main>
        <!-- Maan Breaking News Start -->
        @if(Route::currentRouteName() !='signup'&& Route::currentRouteName() !='signin')

            @include('frontend.layouts._breakingnews')

        @endif
        <!-- Maan Breaking News End -->
        <!-- Maan news  preloader start -->
        <div class="loader-inner ball-scale-multiple">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <link rel="stylesheet" href="{{ asset('frontend/css/loaders.css') }}">


        <!-- Maan news  preloader end -->
        <!-- Main Content Start -->
        @yield('main_content')
        <!-- Main Content End -->
    </main>
    @include('frontend.layouts._footer')
</div>

<!-- jQuery -->
<script src="{{ asset('frontend/js/vendor/jquery-3.6.0.min.js') }} "></script>
<!-- Popper -->
<script src="{{ asset('frontend/js/vendor/popper.min.js') }} "></script>
<!-- Bootstrap -->
<script src="{{ asset('frontend/js/vendor/bootstrap.min.js') }} "></script>
<!-- Slick -->
<script src="{{ asset('frontend/js/vendor/slick.min.js') }} "></script>
<!-- Counter Up -->
<script src="{{ asset('frontend/js/vendor/counterup.min.js') }} "></script>
<!-- Waypoints -->
<script src="{{ asset('frontend/js/vendor/waypoints.min.js') }} "></script>
<!-- Venobox -->
<script src="{{ asset('frontend/js/vendor/venobox.min.js') }} "></script>
<!-- Index -->
<script src="{{ asset('frontend/js/index.js') }} "></script>
<!-- toastr -->
<script src="{{ asset('backend/toastr/toastr.min.js') }} "></script>

<script>
    $("#loginMessage").show().delay(5000).fadeOut('slow');
</script>


</body>

</html>
