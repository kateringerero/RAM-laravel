<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TblSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TblScheduleController extends Controller
{

    public function index(Request $request)
        {
            $schedules = TblSchedule::with('user')->get();
            if ($request->wantsJson()) {
                return response()->json(['schedules' => $schedules]);
            }
            return view('schedules.index', compact('schedules'));
        }

    //KENTH - inayos ko yung switch cases, handled_by, at redirect route
    public function updateStatus(Request $request, $reference_id)
    {
        $appointment = TblSchedule::where('reference_id', $reference_id)->firstOrFail();
        $appointment->status = $request->status;

        $user = auth()->user();
        $appointment->handled_by = $user->user_id;

        $appointment->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['message' => 'Appointment status updated successfully.']);
            }

        return back()->with('success', 'Appointment status updated successfully.');
    }
    //KENTH

     //KENTH
     public function showAppointments()
     {
         $schedules = TblSchedule::with('user')->get();
         return view('manage_appointments.index', compact('schedules'));
     }
     //KENTH

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

         // return response()->json(['message' => 'Schedule created successfully', 'schedule' => $schedule], 201);
         // return redirect()->route('manage_appointments.index')->with('success', 'Status updated successfully.');
         request()->session()->flash('success', 'Status updated successfully.');
         return redirect()->back();
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

    public function editReschedule($reference_id)
        {
            $schedule = TblSchedule::where('reference_id', $reference_id)->firstOrFail();
            return view('schedules.reschedule', compact('schedule'));
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

    public function viewSchedules()
        {
            // $schedules = TblSchedule::all();
            $schedules = TblSchedule::with('user')->get();


            return response()->json($schedules);
        }

            public function showDashboard()
                {
                    $userRole = auth()->user()->role;

                    switch ($userRole) {
                        case 'admin':
                            return view('admin');
                        case 'superadmin':
                            return view('superadmin');
                        default:
                            return view('user');
                    }
                }

                public function handler()
                    {
                        $schedules = TblSchedule::with('user', 'handler')->get();
                        return $this->belongsTo(TblUser::class, 'handled_by', 'user_id');
                    }

// ANDROID
    public function createScheduleAndroid(Request $request)
            {
                $validator = Validator::make($request->all(), [
                    'creator_id' => 'required|string',
                    'reference_id' => 'required|string',
                    'scheduled_date' => 'required|date',
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                    'purpose' => 'required|string',

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
                            $schedule->status = "pending";
                            $schedule->handled_by = 'unassigned';
                            $schedule->save();

                return response()->json(['message' => 'Schedule created successfully', 'schedule' => $schedule], 201);
            }

    public function getAppointmentsByCreatorId(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'creator_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $creatorId = $request->input('creator_id');

            // Assuming you want to retrieve schedules for a specific creator
            $appointments = TblSchedule::where('creator_id', $creatorId)
                                        ->select('reference_id', 'scheduled_date', 'start_time', 'purpose', 'status')
                                        ->get();

            return response()->json(['message' => 'Appointments retrieved successfully', 'appointments' => $appointments], 200);
        }



    public function deleteScheduleAndroid(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'creator_id' => 'required|string',
                'reference_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Find the schedule to delete
            $schedule = TblSchedule::where('reference_id', $request->reference_id)->first();

            if (!$schedule) {
                return response()->json(['message' => 'Schedule not found'], 404);
            }

            // Delete the schedule
            $schedule->delete();

            return response()->json(['message' => 'Schedule deleted successfully'], 200);
        }
}
