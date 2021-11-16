@extends('layouts.admin_dashboard', ['page_title' => 'users'])

@section('content')
    <table id="dataTable" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Wallet Address</th>
            <th>UUID (Invite Code)</th>
            <th>Referrals</th>
            <th>Email (Optional)</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->wallet_address }}</td>
                <td><small>{{ $user->uuid }}</small></td>
                <td>{{ $user->total_referrals }}</td>
                <td>{{ $user->email ?? '-' }}</td>
                <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.dashboard.login_as_user', $user->id) }}" onclick="return confirm('Login as this user?')">Login As</a>
                    <a class="btn btn-sm btn-secondary" href="{{ route('admin.dashboard.change_user_password', $user->id) }}" onclick="return confirm('Reset password for this user?')">Reset Password</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
@endsection