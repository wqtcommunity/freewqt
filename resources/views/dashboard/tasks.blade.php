@extends('layouts.dashboard', ['page_title' => 'tasks'])

@section('content')
    <div class="alert alert-warning text-center">We will double check the submitted tasks for all winners before amount distribution! Winners that undo or have provided invalid data, will be excluded from the final list.</div>

    <table class="table mb-5">
        <thead>
            <tr>
                <th>Title</th>
                <th>Reward</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>@if($task->tickets > 1)<strong class="text-success">@endif{{ $task->tickets }} @if($task->tickets > 1) Tickets @else Ticket @endif @if($task->tickets > 1)</strong>@endif</td>
                    <td>@if($task->approved)<span class="text-success">Auto Approved<br><small>Will be checked again before distribution.</small></span>@elseif($task->user_id)<span class="text-warning">Pending Approval</span>@else - @endif</td>
                    <td>@if($task->user_id)-@else<a href="{{ route('dashboard.do_task', ['task_id' => $task->id, 'round_id' => $task->round_id]) }}" class="btn btn-primary">Go</a>@endif</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="alert alert-info"><small>After completing the tasks, please allow a few hours (usually faster) for the system to check and approve them automatically.</small></div>
    <div class="alert alert-secondary">Rewards distribution date (if you win): 19th December, 2021</div>
@endsection