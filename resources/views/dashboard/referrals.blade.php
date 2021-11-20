@extends('layouts.dashboard', ['page_title' => 'referrals'])

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Your Referral Link</h5>
            <p class="card-text">
                Use the following link to invite people to the project and earn more chance for each round!
                <span id="ref_link_copy" class="link-box">{{ config('app.url') }}/?referrer={{ $incremented_ref_id }}</span>
                <button class="btn btn-sm my-1 btn-secondary" onclick="copyRef()" type="button">Copy</button>
            </p>
        </div>
    </div>
    <script>
        function copyRef() {
            var range = document.createRange();
            range.selectNode(document.getElementById("ref_link_copy"));
            window.getSelection().removeAllRanges(); // clear current selection
            window.getSelection().addRange(range); // to select text
            document.execCommand("copy");
            window.getSelection().removeAllRanges();// to deselect
        }
    </script>

    <div class="alert alert-secondary">We have exciting rewards for our Top Referrers on each round separately, you can read more on our <a target="_blank" href="https://workquest.medium.com/workquest-three-giveaway-programs-a94c30a0a84e">medium page</a>.<br>Even if you win top-referrer reward on a round, you can still win on next rounds if you have higher referrals than others on that round.</div>

    <div class="row mb-5">
        <div class="col-12 col-lg-12">
            <h6 class="mt-4">Referrals for each round</h6>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Round</th>
                    <th class="text-center">Referrals Successfully Signed Up</th>
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
    </div>
@endsection