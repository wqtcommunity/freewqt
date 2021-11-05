@extends('layouts.admin_dashboard', ['page_title' => 'dashboard'])

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-one">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">
                        {{ $total_users ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Round</h5>
                    <p class="card-text">
                        #{{ $round['id'] }} (Block {{ $round['block'] }})
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection