@extends('layouts.admin_dashboard', ['page_title' => 'test_winning_tickets'])

@section('content')
    <form method="POST" class="mb-4" action="{{ route('admin.dashboard.test_winning_tickets.action') }}">
        @csrf
        <div class="mb-3">
            <label for="winners" class="form-label">List of Tickets (JSON)</label>
            <textarea rows="8" required name="winners" id="winners" class="form-control mb-3">{{ old('winners') }}</textarea>
            <span class="form-text">Import Format (json):</span>
            <br>
            <code><pre>[<br>&#9;{"ticket":"1fa166baf064", "amount":"1.25"},<br>&#9;{"ticket":"3e3230b91bf8", "amount":"2.00"}<br>]</pre></code>
        </div>
        <div class="mb-3">
            <input type="checkbox" value="yes" name="duplicates_only" id="duplicates_only">
            <label for="duplicates_only" class="form-label">Only display duplicate addresses (because each user can only win once each round).</label>
        </div>
        <div class="mb-3">
            <input type="checkbox" value="yes" name="exclude_duplicates" id="exclude_duplicates">
            <label for="exclude_duplicates" class="form-label">Exclude duplicate addresses (because each user can only win once each round).</label>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection