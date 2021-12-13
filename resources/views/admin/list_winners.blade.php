@extends('layouts.admin_dashboard', ['page_title' => 'list_winners'])

@section('content')
    <a href="?csv=true" class="btn btn-primary btn-sm float-end">Export CSV (address,amount)</a>
    <table id="dataTable" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Round</th>
            <th>User ID</th>
            <th>Tickets</th>
            <th>Wallet Address</th>
            <th>Won Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($winners as $winner)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $winner->round_id }}</td>
                <td><a href="{{ route('admin.dashboard.users',['search_by' => 'id','search' => $winner->user_id]) }}">{{ $winner->user_id }}</a></td>
                <td>{{ $winner->tickets }}</td>
                <td><small>{{ $winner->wallet_address }}</small></td>
                <td><strong>{{ $winner->won_amount }} WQT</strong></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <form method="GET" class="my-5" action="{{ route('admin.dashboard.list_winners') }}">
        <label for="round">Filter By Round ID</label>
        <input id="round" type="number" min="1" max="4" name="round_id" class="form-inline">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    @if(request('roll_back'))
        <form class="my-5" action="{{ route('admin.dashboard.roll_back_a_winner') }}" method="POST">
            @csrf
            Roll Back a Winner (if happened by mistake)<br>
            <input required type="number" name="round_id" value="" placeholder="Round ID">
            <input required type="number" name="user_id" value="" placeholder="User ID">
            <input required type="password" name="pass" value="" placeholder="Password">
            <button type="submit" class="btn btn-sm btn-danger">Roll Back</button>
        </form>
    @endif
@endsection