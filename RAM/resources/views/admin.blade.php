@extends('layout')

@section('content')

<div class="appointments">
    <div class="appointmentbox">
        <h3></h3>
            @if($paginatedSchedules->isNotEmpty())
                <div class="container-dashboard-appointments">
                    <div class="header-with-search">
                        <h2>Appointments</h2>
                        <form action="{{ route('superadmin.dashboard') }}" method="GET" class="search-form">
                            <input type="text" name="search" placeholder="Search by Reference ID, Name..." value="{{ request('search') }}">
                            <button type="submit">Search</button>
                        </form>
                    </div>
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
                            @foreach ($paginatedSchedules as $schedule)
                            <tr>
                                <td>{{ $schedule->id }}</td>
                                <td>{{ $schedule->creator_id }}</td>
                                <td>{{ $schedule->reference_id }}</td>
                                <td>{{ optional($schedule->user)->first_name }} {{ optional($schedule->user)->last_name }}</td>
                                <td>{{ optional($schedule->user)->email_address }}</td>
                                <td>{{ $schedule->scheduled_date }}</td>
                                <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                <td>{{ $schedule->purpose }}</td>
                                <td>
                                    @switch($schedule->status)
                                        @case("approved")
                                            Approved
                                            @break
                                        @case("released")
                                            For Releasing
                                            @break
                                        @case("follow-up")
                                            For Follow-up
                                            @break
                                        @case("rescheduled")
                                            For Reschedule
                                            @break
                                        @case("pending")
                                            Pending
                                            @break
                                        @case("done")
                                            Done
                                            @break
                                        @default
                                            Unknown
                                    @endswitch
                                </td>
                                <td>{{ optional($schedule->handler)->first_name }} {{ optional($schedule->handler)->last_name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            @else
                <p>No schedules found.</p>
            @endif
            {{ $paginatedSchedules->appends(['search' => request('search')])->links() }}

    </div>

</div>
<div class="appointments-stats">
    <div class="statistics">
        <!-- Pending Approvals -->
        <div class="stats">
            <p class="big-number">{{ $pendingApprovalsCount }} <span class="small-text">Pending Approvals</span></p>
            {{-- <p>Pending Approvals</p> --}}
        </div>
        <!-- Approved Appointments -->
        <div class="stats">
            <p class="big-number">{{ $approvedCount }} <span class="small-text">Approved Appointments</span></p>
            {{-- <p>Pending Approvals</p> --}}
        </div>
        <!-- For Releasing Appointments -->
        <div class="stats">
            <p class="big-number">{{ $releasedCount }} <span class="small-text">For Releasing</span></p>
            {{-- <p>Pending Approvals</p> --}}
        </div>
    </div>
</div>
@endsection
