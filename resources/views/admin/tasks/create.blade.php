@extends('layouts.admin_dashboard', ['page_title' => 'rounds'])

@section('content')
    <h5>Adding Task for Round #{{ $round->id }}</h5>
    <form method="POST" class="mb-4" action="{{ route('admin.dashboard.rounds.tasks.store', $round->id) }}">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input required type="text" value="{{ old('title') }}" name="title" class="form-control" id="title">
        </div>
        <div class="mb-3">
            <label for="tickets" class="form-label">Tickets</label>
            <input required type="number" value="{{ old('tickets') }}" name="tickets" min="1" max="10" step="1" class="form-control" id="tickets" aria-describedby="ticketsHelp">
            <div id="ticketsHelp" class="form-text">Total tickets rewarded by completing this task.</div>
        </div>
        <div class="mb-4">
            <label for="difficulty" class="form-label">Difficulty</label>
            <select required class="form-select" name="difficulty" id="difficulty">
                <option></option>
                <option @if(old('difficulty') === 'instant') selected @endif value="instant">Instant (Approved as soon as they submit)</option>
                <option @if(old('difficulty') === 'easy') selected @endif value="easy">Easy</option>
                <option @if(old('difficulty') === 'normal') selected @endif value="normal">Normal</option>
                <option @if(old('difficulty') === 'hard') selected @endif value="hard">Hard</option>
            </select>
        </div>
        <div class="form-check mb-2">
            <input @if(old('input_required')) checked @endif class="form-check-input" name="input_required" type="checkbox" value="1" id="input_required">
            <label class="form-check-label" for="input_required">
                User Input is Required
            </label>
        </div>
        <div class="mb-3">
            <label for="input_title" class="form-label">User Input Title (If input required is checked above)</label>
            <input type="text" value="{{ old('input_title') }}" name="input_title" class="form-control" id="input_title">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <textarea required name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="link" class="form-label">Link (Task Link for User)</label>
            <input type="text" value="{{ old('link') }}" name="link" class="form-control" id="link">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection