<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TblSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TblScheduleController extends Controller
{

    public function createSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'creator_id' => 'required|string',
            'reference_id' => 'required|string',
            'scheduled_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string',
            'status' => 'required|string', 
        ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $schedule = new TblSchedule();
            $schedule->creator_id = $request->creator_id;
            $schedule->reference_id = $request->reference_id;
            $schedule->scheduled_date = $request->scheduled_date;
            $schedule->start_time = $request->start_time;
            $schedule->end_time = $request->end_time;
            $schedule->purpose = $request->purpose;
            $schedule->status = $request->status;
            $schedule->handled_by = 'unassigned';
            $schedule->save();

        return response()->json(['message' => 'Schedule created successfully', 'schedule' => $schedule], 201);
    }

    public function approveAppointment($reference_id)
    {
        $appointment = TblSchedule::where('reference_id', $reference_id)->first();

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->status = 'approved';
        $appointment->handled_by = auth()->user()->user_id;
        $appointment->save();

        return response()->json(['message' => 'Appointment approved successfully']);
    }


    public function rescheduleAppointment(Request $request, $reference_id)
    {
        $request->validate([
            'scheduled_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $appointment = TblSchedule::where('reference_id', $reference_id)->first();

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->scheduled_date = $request->scheduled_date;
        $appointment->start_time = $request->start_time;
        $appointment->end_time = $request->end_time;
        $appointment->status = 'rescheduled';
        $appointment->handled_by = auth()->user()->user_id; 
        $appointment->save();

        return response()->json(['message' => 'Appointment rescheduled successfully']);
    }


    public function followUpAppointment($reference_id)
    {
        $appointment = TblSchedule::where('reference_id', $reference_id)->first();

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->status = 'follow-up';
        $appointment->handled_by = auth()->user()->user_id;
        $appointment->save();

        return response()->json(['message' => 'Appointment marked for follow-up']);
    }



    public function releaseAppointment($reference_id)
    {
        $appointment = TblSchedule::where('reference_id', $reference_id)->first();

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->status = 'released';
        $appointment->handled_by = auth()->user()->user_id;
        $appointment->save();

        return response()->json(['message' => 'Appointment released successfully']);
    }

}
