@extends('layouts.admin_dashboard', ['page_title' => 'subscribers'])

@section('content')
    <a href="?json=true" class="btn btn-primary btn-sm float-end">Export JSON</a>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Email</th>
            <th>Telegram</th>
            <th>User ID (if a user)</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($subscribers as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->telegram }}</td>
                <td>
                    @if(is_numeric($user->user_id) && $user->user_id > 0)
                        <a href="{{ route('admin.dashboard.users',['search_by' => 'id','search' => $user->user_id]) }}">{{ $user->user_id }}</a>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $user->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $subscribers->links() }}
@endsection