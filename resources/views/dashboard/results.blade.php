@extends('layouts.dashboard', ['page_title' => 'results'])

@section('content')
    <div class="alert alert-info">IMPORTANT: Rewards will be distributed directly to BSC addresses a week after all rounds end. If you have won, please be patient!</div>
    <table class="table table-responsive table-striped table-bordered">
        <thead>
            <tr>
                <th>Round</th>
                <th>Your Tickets</th>
                <th>Referrals</th>
                <th>Won?</th>
            </tr>
        </thead>
        <tbody>
        @foreach($user_round_stats as $round_stats)
            <tr>
                <td>{{ $round_stats->round_id }}</td>
                <td>{{ $round_stats->tickets }}</td>
                <td>{{ $round_stats->referrals }}</td>
                <td>@if($round_stats->won)<strong class="text-success">Yes!</strong> <small class="text-success">({{ $round_stats->won_amount ?? '-' }})</small>@else - @endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection