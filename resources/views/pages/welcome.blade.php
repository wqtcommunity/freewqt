@extends('layouts.pages', ['pg' => 'pages'])

@section('content')
    @include('pages.includes._nav')

    <section id="intro" class="my-5 py-2">
        <h1><strong>WorkQuest</strong> Airdrops</h1>
        <h2>4 Separate AirDrops in 4 Rounds!<br><small>Read more <a href="https://workquest.medium.com/workquest-three-giveaway-programs-a94c30a0a84e" id="link_wq" target="_blank">here</a></small></h2>
    </section>

    <section id="countdown" class="animate__animated animate__jackInTheBox py-2 mb-5">
        @if($current_round['id'] < 5)
            <img id="join_now" class="animate__animated animate__tada animate__delay-2s" src="{{ asset('assets/img/join_now.svg') }}">
            <span class="next">Time left to join @if($current_round['id'] > 1) Round {{ $current_round['id'] }} <small>(Round {{ $current_round['id'] - 1 }} has ended)</small> @else next airdrop @endif</span>
        @endif
        <div id="time" class="mt-1" onclick='window.location.href = "{{ route('signup') }}"'></div>
        @if($current_round['id'] < 5)
            <div id="hanging_sign">{{ $current_round['rewards'] }} <span>WQT</span><span @if($current_round['id'] > 1) class="text-success animate__animated animate__flash animate__delay-3s" style="font-size:1.3rem;" @endif id="round_number">Round #{{ $current_round['id'] }}</span></div>
        @else
            <div id="hanging_sign">ENDED</div>
        @endif
    </section>

    @include('pages.includes._footer')
@endsection

@section('scripts')
<script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
<script>
    $(function () {
        function getRemainingTime() {
            if({{ $current_round['id'] }} < 5){
                return new Date(new Date().valueOf() + {{ $current_round['remaining_time_ms'] }});
            }
            return 0;
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