@extends('layouts.pages', ['pg' => 'pages'])

@section('content')
    <main class="form-auth text-center py-5">
        <form action="{{ route('admin.login.check') }}" method="POST">
            @csrf
            <a href="/"><img class="mb-5 mt-2" id="auth_logo" src="{{ asset('assets/img/logo.png') }}" alt="FreeWQT"></a>
            <h1 class="h4 mb-3 fw-normal">Admin Login</h1>

            <div class="form-floating">
                <input type="text" name="username" class="form-control straight-bottom" id="floatingInput">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword">
                <label for="floatingPassword">Password</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Sign in</button>
        </form>
    </main>
@endsection