@extends('layouts.admin_dashboard', ['page_title' => 'list_winners'])

@section('content')
    <table id="dataTable" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Round</th>
            <th>User ID</th>
            <th>Wallet Address</th>
            <th>Tickets</th>
            <th>Won Amount</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($winners as $winner)
            <tr>
                <td>{{ $winner->round_id }}</td>
                <td>{{ $winner->user_id }}</td>
                <td><small>{{ $winner->wallet_address }}</small></td>
                <td>{{ $winner->tickets }}</td>
                <td>{{ $winner->won_amount }} WQT</td>
                <td><a class="btn btn-sm btn-primary" href="{{ route('admin.dashboard.users') }}?search_by=id&search={{ $winner->user_id }}">Search</a</td>
            </tr>
        @endforeach
        </tbody>
    </table>

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