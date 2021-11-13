@extends('layouts.admin_dashboard', ['page_title' => 'batch_approval'])

@section('content')
    <h5 class="text-center alert alert-info">Approve All Tasks for a User</h5>
    <form class="mb-5" method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.dashboard.batch_approval.action') }}">
        @csrf
        <input type="hidden" name="batch_approval_type" value="user_id">
        <label for="user_id">User ID</label>
        <input required type="number" class="form-control" value="" min="1" step="1" name="user_id" id="user_id">
        <button type="submit" class="btn btn-secondary mt-2">Approve</button>
    </form>

    <h5 class="text-center alert alert-info">Approve a Task for All Users</h5>
    <form class="mb-5" method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.dashboard.batch_approval.action') }}">
        @csrf
        <input type="hidden" name="batch_approval_type" value="single_user">
        <label for="task_id">Task</label>
        <select required class="form-select" name="task_id" id="task_id">
            <option></option>
            @foreach($tasks as $task)
                <option value="{{ $task->id }}">{{ $task->title }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary mt-2">Approve for All</button>
    </form>
@endsection