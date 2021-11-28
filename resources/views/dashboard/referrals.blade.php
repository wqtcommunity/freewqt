@extends('layouts.dashboard', ['page_title' => 'referrals'])

@section('content')
    @if( ! $real_referrals)
        <div class="alert alert-warning">You have been flagged as we believe you are creating fake referrals for yourself to increase your chances!<br>This is a normal routine to make sure the system stays fair.<br><br>If you haven't done anything wrong, please don't worry, you still have a chance to win with your <strong>non-referral</strong> tickets!</div>
    @else
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Referral Link</h5>
                <div class="card-text">
                    @if($all_done === true)
                        Use the following link to invite people to the project and earn more chance for each round!
                        <span id="ref_link_copy" class="link-box">{{ config('app.url') }}/?referrer={{ $incremented_ref_id }}</span>
                        <button class="btn btn-sm my-1 btn-secondary" onclick="copyRef()" type="button">Copy</button>
                    @else
                        <span class="d-block alert alert-warning">Please complete all your tasks to activate your referral link for this round (previous rounds are unaffected).</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="alert alert-info my-4">Please note, for top-referrer rewards, only referrals who have <strong>correctly</strong> completed their tasks will be counted.</div>

        <h6 class="my-3">Important referral rules for this round (previous rounds are unaffected):</h6>
        <ul style="font-size:0.8rem;">
            <li>As we've detected some users trying to abuse our honest and fair system, from now on only if you have completed all your tasks correctly you can use your referral link (previous referrals are unaffected)</li>
            <li>To participate in Top Referrers program, only referrals that have completed all their tasks <strong>correctly</strong> will be counted (this will be applied before amount distribution).</li>
            <li>To keep this fair for all legitimate users, if we believe you are creating fake referrals for yourself, your account will be excluded from the final list.</li>
            <li>Even if you win as a top referrer, but your tasks aren't done correctly, you won't be included in the list of winners.</li>
        </ul>

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

        <div class="row mb-5">
            <div class="col-12 col-lg-8">
                <h6 class="mt-4">Referrals for each round</h6>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Round</th>
                        <th class="text-center">Referrals Successfully Signed Up</th>
                    </tr>
                    @php $total_refs = 0; @endphp
                    @foreach($round_stats as $round)
                        @php $total_refs += $round->referrals; @endphp
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
                        <td class="text-center">{{ $total_refs }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
@endsection