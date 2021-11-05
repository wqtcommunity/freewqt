@extends('layouts.pages', ['pg' => 'pages'])

@section('content')
    <main class="form-auth text-center py-5">
        <form action="{{ route('login.check') }}" method="POST">
            @csrf
            <a href="/"><img class="mb-5 mt-2" id="auth_logo" src="{{ asset('assets/img/logo.png') }}" alt="FreeWQT"></a>
            <h1 class="h4 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="text" name="wallet_address" class="form-control straight-bottom" id="floatingInput" placeholder="0x...">
                <label for="floatingInput">BSC Wallet Address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="checkbox my-3">
                <label>
                    <input type="checkbox" name="remember" value="yes"> Remember me
                </label>
            </div>

            @include('pages.includes._recaptcha')

            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">Don't have an account? <a href="{{ route('signup') }}">Create one here</a></p>
        </form>
    </main>
@endsection