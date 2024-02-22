@extends('layout')

@section('content')
@if($schedules->isNotEmpty())
        <div class="container-manage-appointments">
            <h2>Manage Appointments</h2>
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
                        <th>Actions</th>
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
                        <td>
                            <!-- KENTH - inayos ko lang ulit switches -->
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
                            <!-- KENTH -->
                        </td>
                        <td>{{ optional($schedule->handler)->first_name }} {{ optional($schedule->handler)->last_name }} </td>
                        <td>
                            <form action="{{ route('appointments.updateStatus', ['reference_id' => $schedule->reference_id]) }}" method="POST">
                                @csrf
                                <select name="status" required onchange="this.form.submit()">
                                    <option value="">Change Status</option>
                                    <option value="approved">Approve</option>
                                    <option value="released">Release</option>
                                    <option value="follow-up">Follow Up</option>
                                    <option value="rescheduled">Reschedule</option>
                                    <option value="done">Done</option>
                                </select>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif


@endsection
