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
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
@endsection