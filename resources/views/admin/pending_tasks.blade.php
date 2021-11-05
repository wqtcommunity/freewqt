@extends('layouts.admin_dashboard', ['page_title' => 'pending_tasks'])

@section('content')
    <table id="dataTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Task</th>
                <th>User</th>
                <th>User Response</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pending_tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->task->title }}</td>
                    <td>{{ $task->user->wallet_address }}</td>
                    <td>{{ $task->primary_input }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.dashboard.pending_tasks.action', ['user_task_id' => $task->id, 'action' => 'approve']) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.dashboard.pending_tasks.action', ['user_task_id' => $task->id, 'action' => 'reject']) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-secondary">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection