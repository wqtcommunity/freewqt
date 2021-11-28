@extends('layouts.dashboard', ['page_title' => 'tickets'])

@section('content')
    <h5 class="text-center alert alert-secondary">If you have any questions please read our <a href="{{ route('pages.faq') }}">FAQ page</a></h5>
    <table id="dataTable" class="table table-bordered table-responsive table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Round</th>
            <th class="text-center">Ticket Number</th>
            <th>Type</th>
            <th>Won?</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($round_tickets as $round)
            @if($real_referrals !== true && $round->type === 'referral')
                <tr>
                    <td>{{ ($round_tickets->currentpage()-1) * $round_tickets->perpage() + $loop->index + 1 }}</td>
                    <td style="text-decoration: line-through;text-decoration-color:red;text-decoration-thickness:2px;">Obtained on Round {{ $round->round_id }}</td>
                    <td class="text-center"><small style="text-decoration: line-through;text-decoration-color:red;text-decoration-thickness:2px;">{{ $round->ticket }}</small><br><small class="text-info" style="text-decoration:none !important;">Pending Manual Check, because you have been flagged as automatic checks indicate you are creating fake referrals.</small></td>
                    <td class="text-center" style="text-decoration: line-through;text-decoration-color:red;text-decoration-thickness:2px;">{{ ucwords($round->type) }}</td>
                    <td class="text-center" style="text-decoration: line-through;text-decoration-color:red;text-decoration-thickness:2px;">@if($round->round_id < $last_round_id)<a href="{{ route('dashboard.results') }}"><small>Check Results</small></a>@else - @endif</td>
                    <td class="text-center" style="text-decoration: line-through;text-decoration-color:red;text-decoration-thickness:2px;">
                        {{ $round->created_at->format('Y-m-d') }}
                        <small class="d-md-block">{{ $round->created_at->format('H:i A') }}</small>
                    </td>
                </tr>
            @else
                <tr>
                    <td>{{ ($round_tickets->currentpage()-1) * $round_tickets->perpage() + $loop->index + 1 }}</td>
                    <td>Obtained on Round {{ $round->round_id }}</td>
                    <td class="text-center">{{ $round->ticket }}</td>
                    <td class="text-center">{{ ucwords($round->type) }}</td>
                    <td class="text-center">@if($round->round_id < $last_round_id)<a href="{{ route('dashboard.results') }}"><small>Check Results</small></a>@else - @endif</td>
                    <td class="text-center">
                        {{ $round->created_at->format('Y-m-d') }}
                        <small class="d-md-block">{{ $round->created_at->format('H:i A') }}</small>
                    </td>
                </tr>
            @endif
        @endforeach
        @if($round_tickets->isEmpty())
            <tr><td colspan="6">No Tickets Yet...</td></tr>
        @endif
        </tbody>
    </table>

    {{ $round_tickets->links() }}
@endsection