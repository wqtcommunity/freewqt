<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,900" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet">

    @if(isset($pg) && $pg === 'pages')
        <link href="{{ asset('assets/css/pages.css') }}@if(app()->environment() === 'local')?v={{ date('YmdHis') }}@endif" rel="stylesheet">
    @endif

    @if(config('custom.recaptcha.enabled') && isset($page_id) && in_array($page_id, config('custom.recaptcha.enable_pages')))
        <!-- Google Recaptcha -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    @yield('head')
</head>
<body>

@include('flash::message')

@if($errors->any())
    <div class="container text-center">
        <div class="alert alert-danger mt-3 d-md-inline-block">
            <p><strong>Oops Something went wrong!</strong></p>
            <ul class="pb-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@yield('content')

@if(request()->cookie('cookie_consent') !== 'yes')
    <div class="cookie-consent">
            <span>
                This website uses necessary cookies to enhance user experience.
                <!--<a href="#" class="read-more">Read More</a>-->
            </span>
        <div class="mt-2 d-flex align-items-center justify-content-center g-2">
            <a href="javascript:void(0);" onclick="cookieConsent();" class="consent-button me-1">Got it!</a>
        </div>
    </div>
@endif
<!-- JS -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
    function setCookie(cname, cvalue, exdays=30) {
        let d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires + ';path=/;SameSite=Lax;secure';
    }

    function cookieConsent() {
        $('.cookie-consent').addClass('animate__animated animate__backOutRight');
        setCookie('cookie_consent', 'yes');
    }
</script>
@yield('scripts')
</body>
</html>