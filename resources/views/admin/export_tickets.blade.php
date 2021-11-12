@extends('layouts.admin_dashboard', ['page_title' => 'export_tickets'])

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.dashboard.export_tickets.generate') }}">
            @csrf
            <label for="round">Round ID:</label>
            <select id="round" name="round_id" class="form-select">
                <option value=""></option>
                @foreach($rounds as $round)
                    <option value="{{ $round->id }}">Round {{ $round->id }}</option>
                @endforeach
            </select>

            <div class="form-check my-2">
                <input class="form-check-input" checked="checked" type="checkbox" name="only_address_ticket" value="1" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Export only wallet address and ticket
                </label>
            </div>
            <button class="mt-2 btn btn-primary">Export JSON</button>
        </form>
    </div>
@endsection