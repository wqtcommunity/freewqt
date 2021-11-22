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
            @if(request('advanced'))
                <th>Action</th>
            @endif
        </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td><a href="{{ route('admin.dashboard.users',['search_by' => 'id','search' => $ticket->user_id]) }}">{{ $ticket->user_id }}</a></td>
                    <td>{{ $ticket->round_id }}</td>
                    <td>{{ $ticket->type }}</td>
                    <td>{{ $ticket->ticket }}</td>
                    @if(request('advanced'))
                        <td>
                            <form method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.dashboard.tickets.action') }}">
                                {{-- Only in case a task gets mistakenly approven --}}
                                @csrf
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <input type="hidden" name="round_id" value="{{ $ticket->round_id }}">
                                <input type="hidden" name="user_id" value="{{ $ticket->user_id }}">
                                <input type="hidden" name="ticket" value="{{ $ticket->ticket }}">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tickets->links() }}

    <form method="GET" action="{{ route('admin.dashboard.tickets') }}">
        <label for="round">Filter By Round ID</label>
        <input id="round" type="number" min="1" max="4" name="round_id" class="form-inline">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
@endsection