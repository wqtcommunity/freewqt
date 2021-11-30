@php
    $current_route = request()->route()->getName();
@endphp

<nav class="navbar navbar-light navbar-expand-md p-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/img/logo.png') }}" id="logo" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex">
                <li class="nav-item px-lg-3">
                    <a class="nav-link @if($current_route === 'pages.index') active @endif" href="{{ route('pages.index') }}">Home</a>
                </li>
                <li class="nav-item px-md-3">
                    <a class="text-primary nav-link @if($current_route === 'pages.meme') active @endif" style="font-size: 1.1rem; color: #c81414 !important;" href="{{ route('pages.meme') }}">Meme Contest</a>
                </li>
                <li class="nav-item px-md-3">
                    <a class="animate__animated animate__heartBeat animate__delay-1s nav-link @if($current_route === 'pages.winners') active @endif" href="{{ route('pages.winners') }}">Winners</a>
                </li>
                <li class="nav-item px-md-3">
                    <a class="nav-link @if($current_route === 'pages.faq') active @endif" href="{{ route('pages.faq') }}">FAQ</a>
                </li>
                <li class="nav-item px-md-3">
                    <a class="nav-link @if($current_route === 'pages.fair_draw') active @endif" href="{{ route('pages.fair_draw') }}">Fair Draw</a>
                </li>
                @auth
                    <li class="nav-item px-md-3">
                        <a href="{{ route('dashboard.index') }}" class="nav-link nav-dashboard">Dashboard</a>
                    </li>
                @else
                    <li class="nav-item px-md-3 nav-signup">
                        <a href="{{ route('signup') }}" class="nav-link nav-dashboard">Signup</a>
                    </li>
                    <li class="nav-item px-md-3 nav-login">
                        <a href="{{ route('login') }}" class="nav-link nav-dashboard">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>