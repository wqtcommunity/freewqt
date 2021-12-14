@extends('layouts.dashboard', ['page_title' => 'dashboard'])

@section('content')

    @if($subscribed !== true)
        @include('subscription_form', ['auto_modal' => true])
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card bg-one">
                <div class="card-body">
                    <h5 class="card-title">Current Round</h5>
                    <p class="card-text">
                        @if($last_round->id > 4)
                            Ended
                        @else
                            Round #{{ $last_round->id ?? 1 }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Your Tickets</h5>
                    <p class="card-text">
                        @if($last_round->id > 4)
                            -
                        @else
                            @if($real_referrals)
                                You have {{ $user_stats->tickets ?? 0 }} tickets for this round.
                            @else
                                You have {{ ($user_stats->tickets ?? 0) - ($user_stats->referrals) }} approved tickets for this round.
                                <span class="d-block text-info" style="font-size:0.8rem;">Your referral tickets ({{ $user_stats->referrals }}) are flagged as possibly fake and not applied.</span>
                            @endif
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-md-12">
            <div class="card bg-">
                <div class="card-body">
                    <h5 class="card-title">Referrals</h5>
                    <p class="card-text">
                        @if($all_done === true || $last_round->id > 4)
                            You can earn more free tickets by inviting others using the following link (You currently have {{ $user_stats->referrals ?? 0 }} referrals on this round)
                            <span class="link-box">{{ config('app.url') }}/?referrer={{ $incremented_ref_id }}</span>
                        @else
                            <span class="d-block alert alert-warning">Please complete all your tasks to activate your referral link for this round (previous rounds are unaffected).</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection