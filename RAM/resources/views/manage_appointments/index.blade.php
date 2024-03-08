@extends('layout')

@section('content')

        <div class="container-manage-appointments">
            <div class="header-with-search">
                <h2>Manage Appointments</h2>
                {{-- search --}}
                <form action="{{ route('manage_appointments.index') }}" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search by Reference ID, Name..." value="{{ request('search') }}">
                    <button type="submit">Search</button>
                </form>

                {{-- sort --}}
                <div class="dropdown-custom">
                    <button class="btn btn-secondary dropdown-toggle custom-dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="material-symbols-outlined">
                            Sort
                            </span>
                    </button>
                    <div class="dropdown-menu custom-dropdown" aria-labelledby="dropdownMenuButton">
                        <form action="{{ route('manage_appointments.index') }}" method="GET">
                            <div>
                                <span><b>Sort by:</b></span>
                                <label><input type="radio" name="sort_field" value="scheduled_date" {{ request('sort_field') == 'scheduled_date' ? 'checked' : '' }}> Scheduled Date</label>
                                <label><input type="radio" name="sort_field" value="status" {{ request('sort_field') == 'status' ? 'checked' : '' }}> Status</label>
                            </div>

                            <div>
                                <span><b>Order:</b></span>
                                <label><input type="radio" name="sort_order" value="asc" {{ request('sort_order') == 'asc' ? 'checked' : '' }}> Ascending</label>
                                <label><input type="radio" name="sort_order" value="desc" {{ request('sort_order') == 'desc' ? 'checked' : '' }}> Descending</label>
                            </div>

                            <div>
                                <span><b>Sort status by:</b></span>
                                <label><input type="radio" name="status_filter" value="pending" {{ request('status_filter') == 'pending' ? 'checked' : '' }}> Pending</label>
                                <label><input type="radio" name="status_filter" value="released" {{ request('status_filter') == 'for releasing' ? 'checked' : '' }}> For Releasing</label>
                                <label><input type="radio" name="status_filter" value="follow-up" {{ request('status_filter') == 'for follow up' ? 'checked' : '' }}> For Follow-up</label>
                                <label><input type="radio" name="status_filter" value="done" {{ request('status_filter') == 'done' ? 'checked' : '' }}> Done</label>
                                <label><input type="radio" name="status_filter" value="rescheduled" {{ request('status_filter') == 'reschedule' ? 'checked' : '' }}> Reschedule</label>
                            </div>

                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <button class="custom-button" type="submit">Sort</button>
                        </form>
                    </div>
                </div>
            </div>
            @if($paginatedSchedules->isNotEmpty())
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Creator ID</th>
                        <th>Reference ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Scheduled Date</th>
                        <th>Visit Time</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Handled By</th>
                        <th>Actions</th>
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
                        <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                        <td>{{ $schedule->purpose }}</td>
                        <td>
                            <span class="status-block status-{{ str_replace('_', '-', strtolower($schedule->status)) }}">
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
                                    Complete
                                    @break
                                @case("rescheduled_by_user")
                                    Rescheduled by User
                                    @break
                                @case("cancelled")
                                    Cancelled by user
                                    @break
                                @case("cancelled_no_show")
                                    Cancelled - No Show
                                    @break
                                @default
                                    Unknown
                            @endswitch
                        </td>
                        <td>{{ optional($schedule->handler)->first_name }} {{ optional($schedule->handler)->last_name }} </td>
                        <td>
                            <form action="{{ route('appointments.updateStatus', ['reference_id' => $schedule->reference_id]) }}" method="POST">
                                @csrf
                                <select name="status" required onchange="this.form.submit()">
                                    <option value="">Select Status</option>
                                    <option value="approved">Approve</option>
                                    <option value="released">For Releasing</option>
                                    <option value="follow-up">For Follow-up</option>
                                    <option value="rescheduled">Reschedule</option>
                                    <option value="done">Done</option>
                                </select>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $paginatedSchedules->links() }}
        </div>

    @endif

    <script>
        $(document).ready(function() {
       $('.dropdown-toggle').dropdown();
     });
     </script>

@endsection
