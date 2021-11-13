@extends('layouts.dashboard', ['page_title' => 'referrals'])

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Your Referral Link</h5>
            <p class="card-text">
                Use the following link to invite people to the project and earn more chance for each round!
                <span class="link-box">{{ config('app.url') }}/?referrer={{ $incremented_ref_id }}</span>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-8">
            <h6 class="mt-4">Referrals for each round</h6>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Round</th>
                    <th class="text-center">Referrals Signed Up</th>
                </tr>
                @foreach($round_stats as $round)
                    <tr>
                        <td>Round #{{ $round->round_id }}</td>
                        <td class="text-center">{{ $round->referrals }}</td>
                    </tr>
                @endforeach
                @if($round_stats->isEmpty())
                    <tr><td colspan="2">No Referrals</td></tr>
                @endif
            </table>
        </div>
        <div class="col-12 col-lg-4">
            <h6 class="mt-4">Total Referrals</h6>
            <table class="table table-bordered table-striped">
                <tr>
                    <th class="text-center">For All Rounds</th>
                </tr>
                <tr>
                    <td class="text-center">{{ auth()->user()->total_referrals }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection