@extends('layouts.admin_dashboard', ['page_title' => 'rounds'])

@section('content')
    <form method="POST" class="mb-4" action="{{ route('admin.dashboard.rounds.update', $round->id) }}">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="block_number" class="form-label">Goal Block Number</label>
            <input required type="number" value="{{ old('block_number', $round->block_number) }}" name="block_number" min="12400000" step="1" class="form-control" id="block_number" aria-describedby="blockHelp">
            <div id="blockHelp" class="form-text">Which Block Number on BSC chain will be the target?</div>
        </div>
        <div class="mb-3">
            <label for="estimated_block_time" class="form-label">Estimated Block Time (NOT LAST BLOCK NUMBER)</label>
            <input required type="number" value="{{ old('estimated_block_time', $round->estimated_block_time) }}" name="estimated_block_time" min="{{ time() }}" step="1" class="form-control" id="estimated_block_time" aria-describedby="estimatedHelp">
            <div id="estimatedHelp" class="form-text">Unix Timestamp. (Remaining minutes: {{ round(($round->estimated_block_time - time()) / 60) }} )</div>
        </div>
        <div class="mb-3">
            <label for="rewards" class="form-label">Total Rewards</label>
            <input required type="number" value="{{ old('rewards', $round->rewards) }}" name="rewards" min="10" step="1" class="form-control" id="rewards" aria-describedby="rewardsHelp">
            <div id="rewardsHelp" class="form-text">Total rewards that will be distributed.</div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description and Winning Conditions</label>
            <textarea required name="description" id="description" class="form-control">{{ old('description', $round->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="resulting_hash" class="form-label">Resulting Hash</label>
            <input type="text" value="{{ old('resulting_hash', $round->resulting_hash) }}" name="resulting_hash" class="form-control" id="resulting_hash" aria-describedby="resultHashHelp">
            <div id="resultHashHelp" class="form-text">Block Hash when the block is mined.</div>
        </div>
        <div class="form-check mb-4">
            <input class="form-check-input" name="completed" type="checkbox" value="1" id="completed" @if($round->completed) checked @endif>
            <label class="form-check-label" for="completed">
                Completed
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection