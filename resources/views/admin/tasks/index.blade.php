@extends('layouts.admin_dashboard', ['page_title' => 'tasks'])

@section('content')
    <h5>Tasks for Round #{{ $round->id }}</h5>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Difficulty</th>
            <th>Link</th>
            <th>Requires Input</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($round->tasks as $task)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $task->title }}<br><small class="fw-bold text-info">({{ $task->tickets }} Tickets)</small></td>
                <td><small style="font-size:0.6rem;">{{ $task->description }}</small></td>
                <td>{{ $task->difficulty }}</td>
                <td>@if($task->link)<a href="{{ $task->link }}">Link</a>@else - @endif</td>
                <td>@if($task->input_required) {{ $task->input_title }} @else - @endif</td>
                <td>
                    <form method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.dashboard.rounds.tasks.destroy', [$round->id, $task->id]) }}">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-sm btn-secondary" href="{{ route('admin.dashboard.rounds.tasks.edit', [$round->id, $task->id]) }}">Edit</a>
                        @if( ! $round->active && ! $round->completed)<button type="submit" class="btn btn-sm btn-danger">Delete</button>@endif
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.dashboard.rounds.tasks.create', $round->id) }}" class="btn btn-primary my-4">Add New Task</a>
@endsection