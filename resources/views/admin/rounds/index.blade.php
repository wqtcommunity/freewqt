@extends('layouts.admin_dashboard', ['page_title' => 'rounds'])

@section('content')
    <table id="dataTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Block</th>
                <th>Resulting Block Hash</th>
                <th>Current</th>
                <th>Tasks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rounds as $round)
                <tr>
                    <td>Round {{ $round->id }}</td>
                    <td><a href="https://bscscan.com/block/{{ $round->block_number }}" target="_blank">{{ $round->block_number }}</a></td>
                    <td><small>{{ $round->resulting_hash ?? '-' }}</small></td>
                    <td>@if($round->active) Yes @else - @endif</td>
                    <td><a href="{{ route('admin.dashboard.rounds.tasks.index', $round->id) }}">Tasks</a></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Are you sure?');" action="{{ route('admin.dashboard.rounds.activate', $round->id) }}">
                            @csrf
                            @method('PATCH')
                            @if( ! $round->active && ! $round->completed)<button type="submit" class="btn btn-sm btn-primary">Set Active</button>@endif
                            <a class="btn btn-sm btn-secondary" href="{{ route('admin.dashboard.rounds.edit', $round->id) }}">Edit</a>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.dashboard.rounds.create') }}" class="btn btn-primary my-4">Add New Round</a>
@endsection