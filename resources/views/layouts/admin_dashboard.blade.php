<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/dashboard.css') }}@if(app()->environment() === 'local')?v={{ date('YmdHis') }}@endif" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>

    @yield('head')
</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">Admin Dashboard</a>
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
                        <a class="nav-link @if(($page_title ?? '') === 'dashboard') active @endif" aria-current="page" href="{{ route('admin.dashboard.index') }}">
                            <span data-feather="home"></span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'users') active @endif" aria-current="page" href="{{ route('admin.dashboard.users') }}">
                            <span data-feather="user"></span>
                            Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'pending_tasks') active @endif" href="{{ route('admin.dashboard.pending_tasks') }}">
                            <span data-feather="briefcase"></span>
                            Pending Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'batch_approval') active @endif" href="{{ route('admin.dashboard.batch_approval') }}">
                            <span data-feather="grid"></span>
                            Batch Approval
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'list_winners') active @endif" aria-current="page" href="{{ route('admin.dashboard.list_winners') }}">
                            <span data-feather="list"></span>
                            List of Winners
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'tickets') active @endif" href="{{ route('admin.dashboard.tickets') }}">
                            <span data-feather="book-open"></span>
                            Tickets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'rounds') active @endif" href="{{ route('admin.dashboard.rounds.index') }}">
                            <span data-feather="book"></span>
                            Rounds
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'find_winners') active @endif" href="{{ route('admin.dashboard.find_winners') }}">
                            <span data-feather="search"></span>
                            Find Winners
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'find_lottery_winners') active @endif" href="{{ route('admin.dashboard.find_lottery_winners') }}">
                            <span data-feather="search"></span>
                            Find Lottery Winners
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'top_referrers') active @endif" aria-current="page" href="{{ route('admin.dashboard.top_referrers') }}">
                            <span data-feather="globe"></span>
                            Top Referrers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'test_winning_tickets') active @endif" href="{{ route('admin.dashboard.test_winning_tickets') }}">
                            <span data-feather="user-check"></span>
                            Test Winning Tickets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'submit_winners') active @endif" href="{{ route('admin.dashboard.submit_winners') }}">
                            <span data-feather="star"></span>
                            Submit Winners
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(($page_title ?? '') === 'change_password') active @endif" href="{{ route('admin.dashboard.change_password') }}">
                            <span data-feather="key"></span>
                            Change Password
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
                <h1 class="h2">{{ ucwords(str_replace('_',' ',$page_title ?? 'Dashboard')) }}</h1>
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
<form id="logout_form" method="POST" action="{{ route('admin.logout') }}">@csrf</form>

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