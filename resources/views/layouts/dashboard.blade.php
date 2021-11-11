<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/dashboard.css') }}@if(app()->environment() === 'local')?v={{ date('YmdHis') }}@endif" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>

    @yield('head')
</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/"><img width="100" height="20" src="{{ asset('assets/img/logo_white.png') }}"></a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap d-none d-md-block">
            <a class="nav-link px-3 nav-top-logout" href="#" onclick="document.getElementById('logout_form').submit();">Logout</a>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'dashboard') active @endif" aria-current="page" href="{{ route('dashboard.index') }}">
                            <span data-feather="home"></span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'tasks' || ($page_title ?? '') === 'task') active @endif" href="{{ route('dashboard.tasks') }}">
                            <span data-feather="briefcase"></span>
                            Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'tickets') active @endif" href="{{ route('dashboard.tickets') }}">
                            <span data-feather="hash"></span>
                            Your Tickets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'current_airdrop') active @endif" href="{{ route('dashboard.current') }}">
                            <span data-feather="watch"></span>
                            Current AirDrop
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'results') active @endif" href="{{ route('dashboard.results') }}">
                            <span data-feather="bar-chart-2"></span>
                            Results
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'referrals') active @endif" href="{{ route('dashboard.referrals') }}">
                            <span data-feather="share-2"></span>
                            Referrals
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="document.getElementById('logout_form').submit();">
                            <span data-feather="log-out"></span>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">{{ ucwords(str_replace('_', ' ', ($page_title ?? 'Dashboard'))) }}</h1>
            </div>

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

        </main>
    </div>
</div>

<!-- Logout -->
<form id="logout_form" method="POST" action="{{ route('logout') }}">@csrf</form>

<!-- JS -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script>
    (function () {
        'use strict'
        feather.replace({ 'aria-hidden': 'true' })
    })()
    $(document).ready( function () {
        $('#dataTable').DataTable({"order": []});
    });
</script>
@yield('scripts')
</body>
</html>