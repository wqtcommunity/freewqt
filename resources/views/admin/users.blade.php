@extends('layouts.admin_dashboard', ['page_title' => 'users'])

@section('content')
    @if(request('search'))
        <div class="alert alert-info">Search for {{ request('search_by') }} {{ request('search') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Wallet Address</th>
            <th>Referrals</th>
            <th>Email (Optional)</th>
            <th>Invite Code</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->wallet_address }}</td>
                <td>{{ $user->total_referrals }}</td>
                <td>{{ $user->email ?? '-' }}</td>
                <td><small>{{ $user->id + $increment_ref_id }}</small></td>
                <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.dashboard.login_as_user', $user->id) }}" onclick="return confirm('Login as this user?')">Login As</a>
                    <a class="btn btn-sm btn-secondary" href="{{ route('admin.dashboard.change_user_password', $user->id) }}" onclick="return confirm('Reset password for this user?')">Reset Password</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if( ! request('search'))
        {{ $users->links() }}
        <form method="GET" class="my-5" action="{{ route('admin.dashboard.users') }}">
            Find A User
            <select required name="search_by" class="form-select">
                <option selected value="wallet_address">Find by Wallet Address</option>
                <option value="id">Find by User ID</option>
                <option value="email">Find by Email</option>
            </select>

            <input type="text" name="search" class="form-control" placeholder="Search Value">

            <button type="submit" class="btn btn-sm btn-primary">Search</button>
        </form>
    @endif

    @if($tasks)
        <h5 class="">Submitted Tasks</h5>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Task ID</th>
                <th>Input</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->task_id }}</td>
                    <td>{{ $task->primary_input }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

@endsection