@extends('layouts.admin_dashboard', ['page_title' => 'find_winners'])

@section('content')
    <form method="POST" class="mb-4" action="{{ route('admin.dashboard.find_winners.action') }}">
        @csrf
        <div class="mb-4">
            <label for="round_id" class="form-label">Round</label>
            <select required class="form-select" name="round_id" id="round_id">
                <option></option>
                @foreach($rounds as $round)
                    <option data-min="{{ $round_min_max[$round->id]['min'] ?? '' }}" data-max="{{ $round_min_max[$round->id]['max'] ?? '' }}" @if(old('round_id') == $round->id) selected @endif value="{{ $round->id }}">Round {{ $round->id }} (Rewards: {{ $round->rewards }}, Block: #{{ $round->block_number }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="min" class="form-label">Minimum Ticket Number</label>
            <input type="number" class="form-control" value="{{ old('min') }}" id="min" name="min">
        </div>

        <div class="mb-3">
            <label for="max" class="form-label">Maximum Ticket Number</label>
            <input type="number" class="form-control" value="{{ old('max') }}" id="max" name="max">
        </div>

        <div class="mb-3">
            <label for="hash" class="form-label">Resulting Block Hash <small>(Important, make sure it is the hash, not parent hash or anything else)</small></label>
            <input type="text" class="form-control" value="{{ old('hash') }}" id="hash" name="hash">
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount for all (WQT)</label>
            <input type="number" class="form-control" value="{{ old('amount', 40) }}" min="40" max="40" id="amount" name="amount">
        </div>

        <div class="mb-3">
            <input type="checkbox" checked="checked" value="yes" name="exclude_duplicates" id="exclude_duplicates">
            <label for="exclude_duplicates" class="form-label">Exclude duplicate addresses (because each user can only win once each round).</label>
        </div>

        <div class="mb-4">
            <label for="sort_by" class="form-label">Sort By</label>
            <select required class="form-select" name="sort_by" id="sort_by">
                <option value="user_id">User ID</option>
                <option selected="selected" value="ticket">Ticket Number</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@section('scripts')
    <script>
        $("#round_id").change(function() {
            let selected = $("#round_id option:selected");
            let min = selected.attr('data-min');
            let max = selected.attr('data-max');

            $("#min").val(min);
            $("#max").val(max);
        });
    </script>
@endsection