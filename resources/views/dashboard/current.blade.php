@extends('layouts.dashboard', ['page_title' => 'current_airdrop'])

@section('content')
    @if($current_round['id'] > 1)
        <div class="alert alert-info">Round #{{ $current_round['id'] - 1 }} has ended, and Round #{{ $current_round['id'] }} has just started!</div>
    @endif
    <h5 class="alert alert-secondary text-center">Round {{ $current_round['id'] }}<br><small style="font-weight:normal;">Rewards distribution date for all rounds (if you win): 19th December 2021</small></h5>
    @if($current_round['remaining_time_ms'] < 1)
        <div class="alert alert-info">It appears that the countdown timer has reached 0!<br><br><strong>Please wait 24 hours</strong> for the results to be calculated.</div>
    @endif
    <section id="countdown" class="mb-5">
        <span class="d-block next">Block will be mined in approximately:</span>
        <div id="time" class="mt-1"></div>
        <br>
        <span class="next">Rewards <small class="text-secondary">(Amount will be split between all winners)</small></span>
        <div id="rewards" class="fw-bold">{{ $current_round['rewards'] }}</div>
        <br>
        <span class="next">Predefined Block Number:</span>
        <br>
        <a href="https://bscscan.com/block/{{ $current_round['block_number'] }}" target="_blank">https://bscscan.com/block/{{ $current_round['block_number'] }}</a>
        <br><br>
        <span class="next">Description:</span>
        <div id="rewards">{{ $current_round['description'] }}</div>
        <br>
    </section>
    @if($current_round['id'] > 1)
        <a href="{{ route('dashboard.results') }}" class="d-block btn btn-secondary my-5">Check Previous Round Results</a>
    @endif
    @if($current_round['id'] < 4)
        <div class="alert alert-info"><small>Please note that the timer will reset to 7 days again once this round ends, but if you win in a round, your reward will be recorded and distributed on 19th December, 2021.</small></div>
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <script>
        $(function () {
            function getRemainingTime() {
                return new Date(new Date().valueOf() + {{ $current_round['remaining_time_ms'] }});
            }

            $('#time').countdown(getRemainingTime(), function(event) {
                var $this = $(this).html(event.strftime(''
                    + '<span class="h1 font-weight-bold">%D</span> Day%!d'
                    + '<span class="h1 font-weight-bold">%H</span> Hr'
                    + '<span class="h1 font-weight-bold">%M</span> Min'
                    + '<span class="h1 font-weight-bold">%S</span> Sec'));
            });
        });
    </script>
@endsection