@extends('layouts.admin_dashboard', ['page_title' => 'users'])

@section('content')
    <h5 class="text-center alert alert-info">Change Password for User #{{ $user->id }}: {{ $user->wallet_address }}</h5>
    <form method="post" action="{{ route('admin.dashboard.change_user_password_store', $user->id) }}">
        @csrf
        @method('PATCH')

        <label for="pass">New Password</label>
        <input required type="text" class="form-control" value="" name="pass" id="pass">

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection