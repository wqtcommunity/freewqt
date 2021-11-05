@extends('layouts.dashboard', ['page_title' => 'task'])

@section('content')
    <h5 class="mb-4">{{ $task->title }}</h5>
    <div class="card">
        <div class="card-body">
            <p class="card-text">
                {{ $task->description }}
                @if(strlen($task->link) > 1)
                    <br>
                    <a href="{{ $task->link }}" target="_blank">{{ $task->link }}</a>
                    <br>
                @endif
            </p>
        </div>
        <form class="card-footer" action="{{ route('dashboard.submit_task', ['task_id' => $task->id, 'round_id' => $task->round_id]) }}" method="POST">
            @csrf
            @if($task->input_required)
                <h6>Fill the Form:</h6>
                <input type="text" required class="form-control mb-2" placeholder="{{ $task->input_title }}" name="primary_input">
            @endif
            <button type="submit" class="btn btn-primary btn-sm">Get Ticket</button>
        </form>
    </div>
@endsection