@extends('layouts.admin_dashboard', ['page_title' => 'submit_winners'])

@section('content')
    <form method="POST" class="mb-4" action="{{ route('admin.dashboard.submit_winners') }}">
        @csrf
        <div class="mb-4">
            <label for="round_id" class="form-label">Round</label>
            <select required class="form-select" name="round_id" id="round_id">
                <option></option>
                @foreach($rounds as $round)
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

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection