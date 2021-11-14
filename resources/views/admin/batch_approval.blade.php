@extends('layouts.admin_dashboard', ['page_title' => 'batch_approval'])

@section('content')
    <h5 class="text-center alert alert-info">Approve a Task for All Users</h5>
    <form class="mb-5" method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.dashboard.batch_approval.action') }}">
        @csrf
        <input type="hidden" name="batch_approval_type" value="by_task_id">
        <label for="task_id">Task</label>
        <select required class="form-select" name="task_id" id="task_id">
            <option></option>
            @foreach($tasks as $task)
                <option value="{{ $task->id }}">{{ $task->title }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary mt-2">Approve for All</button>
    </form>

    <h5 class="text-center alert alert-info">Approve a Task for All Users who have Completed Another Task (up to 100 users)</h5>
    <form class="mb-5" method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.dashboard.batch_approval.action') }}">
        @csrf
        <input type="hidden" name="batch_approval_type" value="if_done_then_approve">
        <label for="done_task_id">For all users that have completed the following task:</label>
        <select required class="form-select" name="done_task_id" id="done_task_id">
            <option></option>
            @foreach($tasks as $task)
                <option value="{{ $task->id }}">{{ $task->title }}</option>
            @endforeach
        </select>
        <label for="approve_task_id">Then approve the following for them:</label>
        <select required class="form-select" name="approve_task_id" id="approve_task_id">
            <option></option>
            @foreach($tasks as $task)
                <option value="{{ $task->id }}">{{ $task->title }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary mt-2">Approve for All</button>
    </form>


    <h5 class="text-center alert alert-info">Approve All Tasks for a User <small>(WARNING: This will generate close ticket numbers, e.g. 50000 -> 50001 -> 50002</small>)</h5>
    <form class="mb-5" method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.dashboard.batch_approval.action') }}">
        @csrf
        <input type="hidden" name="batch_approval_type" value="by_single_user">
        <label for="user_id">User ID</label>
        <input required type="number" class="form-control" value="" min="1" step="1" name="user_id" id="user_id">
        <button type="submit" class="btn btn-secondary mt-2">Approve</button>
    </form>
@endsection