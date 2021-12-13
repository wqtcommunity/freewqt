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
                <li class="nav-item px-md-3">
                    <a class="animate__animated animate__heartBeat animate__delay-1s nav-link @if($current_route === 'pages.winners') active @endif" href="{{ route('pages.winners') }}">Winners</a>
                </li>
                @if(date('Ymd') < 20211220)
                    @auth
                        <li class="nav-item px-md-3">
                            <a href="{{ route('dashboard.index') }}" class="nav-link nav-dashboard">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item px-md-3">
                            <a href="{{ route('login') }}" class="nav-link nav-dashboard">Login</a>
                        </li>
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>