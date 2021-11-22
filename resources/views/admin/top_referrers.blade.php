@extends('layouts.admin_dashboard', ['page_title' => 'top_referrers'])

@section('content')
    @if(request('round_id'))
        <div class="alert alert-info">Filtered for Round {{ request('round_id') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Round</th>
            <th>User ID</th>
            <th>Wallet Address</th>
            <th>Referrals</th>
        </tr>
        </thead>
        <tbody>
        @foreach($round_stats as $stat)
            <tr>
                <td>{{ $stat->round_id }}</td>
                <td><a href="{{ route('admin.dashboard.users',['search_by' => 'id','search' => $stat->user_id]) }}">{{ $stat->user_id }}</a></td>
                <td>{{ $stat->wallet_address }}</td>
                <td>{{ $stat->referrals }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if( ! request('export_for_round'))
        {{ $round_stats->links() }}
    @endif

    <form method="GET" class="my-5" action="{{ route('admin.dashboard.top_referrers') }}">
        <label for="round">Filter By Round ID</label>
        <input id="round" type="number" min="1" max="4" name="round_id" class="form-inline">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
    <form method="GET" class="my-5" action="{{ route('admin.dashboard.top_referrers') }}">
        <label for="round">Export Top 3 Winners for Round</label>
        <input id="round" type="number" min="1" max="4" name="export_for_round" class="form-inline">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
@endsection