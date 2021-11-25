@extends('layouts.dashboard', ['page_title' => 'results'])

@section('content')

    @if($won_amount > 0)
        <div class="alert alert-success"><h1>Congratulations!</h1><br>You have won a total of <strong class="alert alert-info p-1">{{ $won_amount }} WQT</strong><br><br>Please message on our telegram community <a href="https://t.me/WorkQuestChat" target="_blank">@WorkQuestChat</a> and let others know about it!<br><br>You will receive your WQT in your BSC wallet address on <strong class="alert alert-info p-1">19th December, 2021</strong></div>
    @else
        @if($test_if_up) Hello! @endif
        <div class="alert alert-info">IMPORTANT: Rewards will be distributed directly to winning BSC addresses on <span style="color:#000;font-weight:bold;">19th December, 2021</span>.<br>If you have won in a round, <strong>please be patient</strong>.</div>

        @if($remaining_hours > 0)
            <div class="alert alert-warning">Please wait up to another <strong>{{ $remaining_hours }} hours</strong> for the results of Round #{{ $previous_round_id }} to be calculated, then check again.</div>
        @endif
    @endif

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
                <td>
                    @if($round_stats->won)
                        <strong class="text-success">Yes!</strong> <small class="text-success">@if($round_stats->won_amount && $round_stats->won_amount > 0)({{ bcmul('1', "{$round_stats->won_amount}", 0) }} WQT)@endif</small>
                    @elseif($previous_round_id)
                        @if($previous_round_id == $round_stats->round_id && $remaining_hours > 0)
                            <span class="text-secondary">Please wait {{ $remaining_hours }} hours.
                        @elseif($previous_round_id <= $round_stats->round_id && $round_stats->round_id !== $last_round_id)
                            No
                        @else
                            -
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection