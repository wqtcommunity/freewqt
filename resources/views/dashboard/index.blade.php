@extends('layouts.dashboard', ['page_title' => 'dashboard'])

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-one">
                <div class="card-body">
                    <h5 class="card-title">Current Round</h5>
                    <p class="card-text">
                        Round #{{ $last_round->id ?? 1 }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Your Tickets</h5>
                    <p class="card-text">
                        You have {{ $user_stats->tickets ?? 0 }} tickets for this round.
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
                        You can earn more free tickets by inviting others using the following link (You currently have {{ $user_stats->referrals ?? 0 }} referrals on this round)
                        <span class="link-box">{{ config('app.url') }}/?referrer={{ $incremented_ref_id }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection