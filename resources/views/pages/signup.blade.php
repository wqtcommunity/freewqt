@extends('layouts.pages', ['pg' => 'pages'])

@section('content')
    <main class="form-auth text-center pt-5">
        <form action="{{ route('signup.store') }}" method="POST">
            @csrf
            <a href="/"><img class="mb-5 mt-2" id="auth_logo" src="{{ asset('assets/img/logo.png') }}" alt="FreeWQT"></a>
            <h1 class="h4 mb-3 fw-normal">Create an account</h1>

            <div class="form-floating">
                <input type="text" required name="wallet_address" class="form-control straight-bottom" id="floatingInput" placeholder="0x...">
                <label for="floatingInput">BSC Wallet Address</label>
                <small><strong>IMPORTANT:</strong> You cannot change or recover your address or password later, keep them safe!</small>
            </div>
            <div class="form-floating">
                <input type="password" required name="password" class="form-control straight-both" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" required name="password_confirmation" class="form-control straight-top" id="floatingPasswordConfirmation" placeholder="Retype Password">
                <label for="floatingPasswordConfirmation">Retype Password</label>
            </div>

            @include('pages.includes._recaptcha')

            <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </form>
    </main>
    <p class="text-center mb-5 alert alert-info"><small>Because you only sign up with your Address and Password, resetting or recovering your password is not possible,<br>but if you win your WQT will be sent to your address automatically, you do not need to manually withdraw!</small></p>
@endsection