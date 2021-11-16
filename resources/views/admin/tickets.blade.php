@extends('layouts.admin_dashboard', ['page_title' => 'tickets'])

@section('content')
    <h5 class="text-center alert alert-info">All Tickets</h5>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>User ID</th>
            <th>Round</th>
            <th>Type</th>
            <th>Ticket</th>
        </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->user_id }}</td>
                    <td>{{ $ticket->round_id }}</td>
                    <td>{{ $ticket->type }}</td>
                    <td>{{ $ticket->ticket }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tickets->links() }}
@endsection