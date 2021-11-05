@extends('layouts.admin_dashboard', ['page_title' => 'rounds'])

@section('content')
    <form method="POST" class="mb-4" action="{{ route('admin.dashboard.rounds.store') }}">
        @csrf
        <div class="mb-3">
            <label for="block_number" class="form-label">Goal Block Number</label>
            <input required type="number" name="block_number" min="12400000" step="1" class="form-control" id="block_number" aria-describedby="blockHelp">
            <div id="blockHelp" class="form-text">Which Block Number on BSC chain will be the target?</div>
        </div>
        <div class="mb-3">
            <label for="last_block" class="form-label">Last Mined Block Number</label>
            <input required type="number" name="last_block" min="12300000" step="1" class="form-control" id="last_block" aria-describedby="lastblockHelp">
            <div id="lastblockHelp" class="form-text">This will be used to calculate the remaining times.</div>
        </div>
        <div class="mb-3">
            <label for="rewards" class="form-label">Total Rewards</label>
            <input required type="number" name="rewards" min="10" step="1" class="form-control" id="rewards" aria-describedby="rewardsHelp">
            <div id="rewardsHelp" class="form-text">Total rewards that will be distributed.</div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description and Winning Conditions</label>
            <textarea required name="description" id="description" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection