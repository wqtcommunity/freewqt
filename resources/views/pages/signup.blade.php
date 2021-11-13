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
                @if(config('custom.optional_email'))
                    <span id="input_tooltip2" class="input_tooltips text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="You cannot change your wallet address later!">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg>
                    </span>
                @else
                    <small><strong>IMPORTANT:</strong> You cannot change or recover your address or password later, keep them safe!</small>
                @endif
            </div>
            <div class="form-floating">
                <input type="password" required name="password" class="form-control straight-both" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" required name="password_confirmation" class="form-control straight-top" id="floatingPasswordConfirmation" placeholder="Retype Password">
                <label for="floatingPasswordConfirmation">Retype Password</label>
            </div>

            @if(config('custom.optional_email'))
                <div class="form-floating">
                    <input type="email" name="email" class="form-control mt-2" id="floatingEmail" placeholder="Email">
                    <label for="floatingEmail">E-mail Address <strong>(Optional)</strong></label>
                    <span id="input_tooltip" class="input_tooltips text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Entering e-mail address is optional, but without it, we will not be able to help you reset your password in case it's forgotten!">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg>
                    </span>
                </div>
            @endif

            @include('pages.includes._recaptcha')

            <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Sign up</button>
            <p class="mt-5 mb-3 text-muted">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </form>
    </main>
    @if( ! config('custom.optional_email'))
        <p class="text-center mb-5 alert alert-info"><small>Because you only sign up with your Address and Password, resetting or recovering your password is not possible,<br>but if you win your WQT will be sent to your address automatically, you do not need to manually withdraw!</small></p>
    @endif
@endsection

@if(config('custom.optional_email'))
    @section('scripts')
    <style>
        .input_tooltips {
            position: absolute;
            right: 10px;
            top: 3px;
            z-index: 99;
        }
    </style>
    <script>
        var exampleEl = document.getElementById('input_tooltip');
        var tooltip = new bootstrap.Tooltip(exampleEl);
        var exampleEl2 = document.getElementById('input_tooltip2');
        var tooltip2 = new bootstrap.Tooltip(exampleEl2);
    </script>
    @endsection
@endif