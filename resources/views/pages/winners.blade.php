@extends('layouts.pages', ['pg' => 'pages'])

@section('head')
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
    <style>
        #winnersTab .nav-link{
            color: #405575;
        }
        #winnersTab .nav-link:hover{
            border-bottom: 0;
        }
        #winnersTab .nav-link.active{
            border-top: 3px solid #BBB !important;
            font-weight: bold;
        }
        #amount_date {
            right:0;
            top:10px;
        }
        #amount_date strong {
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .dataTables_length {
                text-align: left !important;
                margin-bottom: 0.5rem;
            }
            .dataTables_filter {
                text-align: left !important;
            }

            #amount_date {
                top: -100px !important;
                left: 0;
                text-align: center !important;
            }
        }
    </style>
@endsection

@section('content')
    @include('pages.includes._nav')
    <div class="container">
        <section class="mt-5 mb-3 py-2">
            <h2 class="text-center">WQT AirDrop <strong class="text-info">Winners</strong></h2>
        </section>
        <ul class="nav nav-tabs position-relative" id="winnersTab">
            <span id="amount_date" class="text-end position-absolute">Amount Distribution: <strong>19th December, 2021</strong></span>
            <li class="nav-item" role="presentation">
                <a class="nav-link @if(request('round', 1) == 1) active @endif" id="round1-tab" href="{{ route('pages.winners',['round' => 1]) }}">Round #1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request('round', 1) == 2) active @endif" id="round2-tab" href="{{ route('pages.winners',['round' => 2]) }}">Round #2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request('round', 1) == 3) active @endif" id="round3-tab" href="{{ route('pages.winners',['round' => 3]) }}">Round #3</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request('round', 1) == 4) active @endif" id="round4-tab" href="{{ route('pages.winners',['round' => 4]) }}">Round #4</a>
            </li>
        </ul>
        <div style="background:#FFF;" class="tab-content p-3 border-1 border-top-0 border table-responsive" id="winnersTabContent">
            @if($winners !== false)
                <div class="tab-pane fade show active" id="round1">
                    <ul class="nav nav-pills justify-content-center" id="roundTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" aria-current="page" id="airdrop_winners_tab" data-bs-toggle="tab" data-bs-target="#airdrop_winners" type="button" role="tab" aria-controls="airdrop_winners" aria-selected="true">AirDrop Winners</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" aria-current="page" id="lottery_winners_tab" data-bs-toggle="tab" data-bs-target="#lottery_winners" type="button" role="tab" aria-controls="lottery_winners" aria-selected="true">Lottery Winners</button>
                        </li>
                        @if(isset($winners['top_referrers'], $winners['referrer_stats']))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" aria-current="page" id="top_referrers_tab" data-bs-toggle="tab" data-bs-target="#top_referrers" type="button" role="tab" aria-controls="top_referrers" aria-selected="true">Top Referrers</button>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content" id="roundTabContent">
                        <div class="tab-pane fade show active" id="airdrop_winners" role="tabpanel" aria-labelledby="airdrop_winners">
                            <div class="alert alert-info text-center my-2">Important: Some of the users that had provided invalid data in task input or undo their tasks (e.g. they didn't actually retweet or they undid it) are excluded from the list below, as well as duplicate winners as each user can only win one AirDrop each round (you can win up to 4 times but in 4 rounds).</div>
                            <table id="airdrop_winners_table" class="table table-borderless table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th>Ticket #</th>
                                    <th>Wallet Address</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($winners['airdrop'] as $winner)
                                    <tr>
                                        <td>{{ $winner->ticket }}</td>
                                        <td>{{ $winner->wallet_address }}</td>
                                        <td>{{ intval($winner->won_amount) }} WQT</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade show" id="lottery_winners" role="tabpanel" aria-labelledby="lottery_winners">
                            <table id="lottery_winners_table" class="table table-borderless table-striped">
                                <thead>
                                <tr>
                                    <th>Ticket #</th>
                                    <th>Wallet Address</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($winners['lottery'] as $winner)
                                        <tr>
                                            <td>{{ $winner->ticket }}</td>
                                            <td>{{ $winner->wallet_address }}</td>
                                            <td>{{ intval($winner->won_amount) }} WQT</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(isset($winners['top_referrers'], $winners['referrer_stats']))
                            <div class="tab-pane fade show" id="top_referrers" role="tabpanel" aria-labelledby="top_referrers">
                                <div class="alert alert-info text-center my-2">Please note that top referrers are selected based on referrals brought <strong>each round</strong>, so the following winners will start from 0 on next round, just like other users.</div>
                                <table id="top_referrers_table" class="table table-borderless table-striped">
                                    <thead>
                                    <tr>
                                        <th>Wallet Address</th>
                                        <th>Total Referrals</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($winners['top_referrers'] as $winner)
                                            <tr>
                                                <td>{{ $winner->wallet_address }}</td>
                                                <td>{{ $winners['referrer_stats'][$winner->user_id] ?? '' }}</td>
                                                <td>{{ intval($winner->won_amount) }} WQT</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="tab-pane fade show active" id="round{{ $round_id }}">Results will be shared ~24 hours after the round completes! @if($current_round_id < 4) <br> <a href="{{ route('login') }}">You can login and complete the tasks to participate in the current round!</a> @endif </div>
            @endif
        </div>
    </div>

    @include('pages.includes._footer')

    @section('scripts')
    <script>
        $(document).ready( function () {
            $('#airdrop_winners_table').DataTable({"order": [],"pageLength": 50});
            $('#lottery_winners_table').DataTable({"order": []});
            $('#top_referrers_table').DataTable({"order": [1, 'desc']});
        });
    </script>
    @endsection
@endsection