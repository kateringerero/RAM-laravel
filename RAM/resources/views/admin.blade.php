@extends('layout')

@section('sidebar-options')
    <li><a href="{{ route('manage-appointments') }}">Manage Appointments</a></li>
    <li><a href="{{ route('my-account') }}">My Account/Profile</a></li>
@endsection

@section('content')
<div class="appointments">
    <div class="appointmentbox">
        <h3></h3>
        {{-- searchbar start --}}
        {{-- <div class="container">
            <form action="{{ route('dashboard') }}" method="GET" class="form-inline">
                <input type="text" name="search" placeholder="Search appointments..." class="form-control mb-2 mr-sm-2" required>
                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>
        </div> --}}
         {{-- searchbar end --}}
        <div class="scrollable-table">
        @if($schedules->isNotEmpty())
            <div class="container-dashboard-appointments">
                <h2>Appointments</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Creator ID</th>
                            <th>Reference ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Scheduled Date</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Handled By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->id }}</td>
                            <td>{{ $schedule->creator_id }}</td>
                            <td>{{ $schedule->reference_id }}</td>
                            <td>{{ optional($schedule->user)->first_name }} {{ optional($schedule->user)->last_name }}</td>
                            <td>{{ optional($schedule->user)->email_address }}</td>
                            <td>{{ $schedule->scheduled_date }}</td>
                            <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                            <td>{{ $schedule->purpose }}</td>
                            <td>{{ $schedule->status }}</td>
                            <td>{{ optional($schedule->handler)->first_name }} {{ optional($schedule->handler)->last_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @else
            <p>No schedules found.</p>
        @endif
    </div>
    </div>
</div>
<div class="appointments">
<div class = "statistics">
    <div class = "stats">
        <p>releasing</p>
    </div>
    <div class = "stats">
        <p>releasing</p>
    </div>
    <div class = "stats">
        <p>approved</p>
    </div>
</div>
</div>

@endsection
