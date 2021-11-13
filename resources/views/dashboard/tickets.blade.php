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
            <tr>
                <td>{{ ($round_tickets->currentpage()-1) * $round_tickets->perpage() + $loop->index + 1 }}</td>
                <td>Only for Round {{ $round->round_id }}</td>
                <td class="text-center">{{ $round->ticket }}</td>
                <td class="text-center">{{ ucwords($round->type) }}</td>
                <td class="text-center">@if($round->won)<strong class="text-success">Yes!</strong> <small class="text-success">({{ $round->won_amount ?? '-' }})</small>@else - @endif</td>
                <td class="text-center">
                    {{ $round->created_at->format('Y-m-d') }}
                    <small class="d-md-block">{{ $round->created_at->format('H:i A') }}</small>
                </td>
            </tr>
        @endforeach
        @if($round_tickets->isEmpty())
            <tr><td colspan="6">No Tickets Yet...</td></tr>
        @endif
        </tbody>
    </table>

    {{ $round_tickets->links() }}
@endsection