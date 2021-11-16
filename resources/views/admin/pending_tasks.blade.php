@extends('layouts.admin_dashboard', ['page_title' => 'pending_tasks'])

@section('content')
    @if($filter_task)
        <p class="alert alert-secondary">Filtered by Task ID {{ $filter_task }}, to unset, select No Filter below.</p>
    @endif
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
                        <form method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.dashboard.pending_tasks.action', ['user_task_id' => $task->id, 'action' => 'reject']) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-secondary">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr class="mb-5">
    <form class="float-start" action="{{ route('admin.dashboard.pending_tasks') }}" method="GET">
        <label for="task_id">Filter Task Type</label>
        <select name="task_id" id="task_id">
            <option value="none">No Filter</option>
            @foreach($tasks as $task)
                <option @if($filter_task == $task->id) selected @endif value="{{ $task->id }}">{{ $task->title }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-sm btn-secondary">Go</button>
    </form>
    <form class="float-end" action="{{ route('admin.dashboard.pending_tasks') }}" method="GET">
        <label for="limit">Limit Results</label>
        <select name="limit" id="limit">
            <option value="500">500</option>
            <option @if($limit == 100) selected @endif value="100">100</option>
            <option @if($limit == 1000) selected @endif value="1000">1000</option>
            <option @if($limit == 5000) selected @endif value="5000">5000</option>
            <option @if($limit == 10000) selected @endif value="10000">10000</option>
        </select>
        <button type="submit" class="btn btn-sm btn-secondary">Go</button>
    </form>

    <form class="float-end" action="{{ route('admin.dashboard.pending_tasks') }}" method="GET">
        <label for="order">Order</label>
        <select name="order" id="order">
            <option @if($order === 'asc') selected @endif value="asc">ID - ASC</option>
            <option @if($order === 'desc') selected @endif value="desc">ID - DESC</option>
            <option @if($order === 'random') selected @endif value="random">Random</option>
        </select>
        <button type="submit" class="btn btn-sm btn-secondary">Go</button>
    </form>
@endsection