@extends('layouts.dashboard', ['page_title' => 'tasks'])

@section('content')
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
                    <td>@if($task->approved)<span class="text-success">Approved</span>@elseif($task->user_id)<span class="text-warning">Pending</span>@else - @endif</td>
                    <td>@if($task->user_id)-@else<a href="{{ route('dashboard.do_task', ['task_id' => $task->id, 'round_id' => $task->round_id]) }}" class="btn btn-primary">Go</a>@endif</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection