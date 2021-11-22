@extends('layouts.admin_dashboard', ['page_title' => 'find_lottery_winners'])

@section('content')
    <form method="POST" class="mb-4" action="{{ route('admin.dashboard.find_lottery_winners.action') }}">
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