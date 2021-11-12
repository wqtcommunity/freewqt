@extends('layouts.admin_dashboard', ['page_title' => 'export_tickets'])

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.dashboard.change_password.store') }}">
            @csrf
            <div class="form-floating my-2">
                <input required type="password" class="form-control" name="current_password" id="current_password" placeholder="">
                <label class="form-check-label" for="current_password">
                    Current Password
                </label>
            </div>
            <hr>
            <div class="form-floating mt-2">
                <input required type="password" class="form-control" name="password" id="password" placeholder="">
                <label class="form-check-label" for="password">
                    New Password
                </label>
            </div>
            <div class="form-floating my-2">
                <input required type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="">
                <label class="form-check-label" for="password_confirmation">
                    Retype New Password
                </label>
            </div>
            <button type="submit" class="mt-2 btn btn-primary">Change</button>
        </form>
    </div>
@endsection