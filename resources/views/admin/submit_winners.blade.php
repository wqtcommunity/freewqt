@extends('layouts.admin_dashboard', ['page_title' => 'submit_winners'])

@section('content')
    <form method="POST" class="mb-4" action="{{ route('admin.dashboard.submit_winners') }}">
        @csrf
        <div class="mb-4">
            <label for="round_id" class="form-label">Round</label>
            <select required class="form-select" name="round_id" id="round_id">
                <option></option>
                @foreach($rounds as $round)
                    @if($round->id < ($current_round_id - 1))
                        @continue
                    @endif
                    <option @if(old('round_id') == $round->id) selected @endif value="{{ $round->id }}">Round {{ $round->id }} (Rewards: {{ $round->rewards }}, Block: #{{ $round->block_number }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="winners" class="form-label">Winners</label>
            <textarea rows="8" required name="winners" id="winners" class="form-control mb-3">{{ old('winners') }}</textarea>
            <span class="form-text">Import Format (json):</span>
            <br>
            <code><pre>[<br>&#9;{"ticket":"1fa166baf064", "amount":"1.25"},<br>&#9;{"ticket":"3e3230b91bf8", "amount":"2.00"}<br>]</pre></code>
        </div>
        <div class="mb-3">
            <input type="checkbox" value="yes" checked="checked" name="check_previous_round_tickets" id="check_previous_round_tickets">
            <label for="check_previous_round_tickets" class="form-label">Check Previous round tickets too, if we want previous round participants to also win.</label>
        </div>
        <div class="mb-3">
            <input type="checkbox" value="yes" name="override_40_limit" id="override_40_limit">
            <label for="override_40_limit" class="form-label">Override 40 WQT limit (used for <strong>submitting Lottery and Referral Winners</strong>)</label>
        </div>
        <div class="mb-3">
            <input type="checkbox" value="yes" name="override_user_stats" id="override_user_stats">
            <label for="override_user_stats" class="form-label">Override User Stats - If not checked, users that have won anything else on this round will be skipped.</label>
        </div>
        <div class="mb-3">
            <input type="checkbox" checked value="yes" name="even_create_user_stats" id="even_create_user_stats">
            <label for="even_create_user_stats" class="form-label">Create User Stats Row if doesn't exist - Warning, only use if absolutely necessary</label>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection