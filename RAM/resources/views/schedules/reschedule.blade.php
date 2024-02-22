@extends('layout')

@section('content')
<div class="container">
    <h2>Reschedule Appointment</h2>
    <form action="{{ route('schedules.updateReschedule', $schedule->reference_id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="scheduled_date">Scheduled Date</label>
            <input type="date" class="form-control" id="scheduled_date" name="scheduled_date" required value="{{ $schedule->scheduled_date }}">
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" required value="{{ $schedule->start_time }}">
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" required value="{{ $schedule->end_time }}">
        </div>
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea class="form-control" id="notes" name="notes"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Reschedule</button>
    </form>
</div>
@endsection
