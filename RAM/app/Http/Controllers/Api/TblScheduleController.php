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
            $query = TblSchedule::query();

            $role = auth()->user()->role;

            switch ($role) {
                case 'superadmin':
                    $viewName = 'superadmin';
                    break;
                case 'admin':
                    $viewName = 'admin';
                    break;
                case 'user':
                    $viewName = 'user';
                    break;
                default:
                    $viewName = 'default';
                    break;
            }

            // search
            $search = $request->input('search', '');

            if (!empty($search)) {
                $query->where(function ($query) use ($search) {
                    $query->where('reference_id', 'like', '%' . $search . '%')
                          ->orWhere('creator_id', 'like', '%' . $search . '%')
                          ->orWhereHas('user', function ($query) use ($search) {
                              $query->where('last_name', 'like', '%' . $search . '%')
                                    ->orWhere('first_name', 'like', '%' . $search . '%')
                                    ->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'like', '%' . $search . '%');
                          });
                });
            }

            // sort
            $sortField = $request->input('sort_field');
                $sortOrder = $request->input('sort_order', 'asc'); // Default to ascending if not specified
                $statusFilter = $request->input('status_filter');

                if ($sortField) {
                    $query->orderBy($sortField, $sortOrder);
                }

                if ($statusFilter) {
                    $query->where('status', $statusFilter);
                }

                $paginatedSchedules = $query->paginate(6)->appends([
                    'search' => $search,
                    'sort_field' => $sortField,
                    'sort_order' => $sortOrder,
                    'status_filter' => $statusFilter,
                ]);

            // paginate
            $paginatedSchedules = $query->paginate(6);

            // analytics
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $statusCounts = TblSchedule::selectRaw("status, COUNT(*) as count")
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->groupBy('status')
                    ->get()
                    ->keyBy('status')
                    ->map(function ($row) {
                        return $row->count;
                    });

            $pendingApprovalsCount = $statusCounts['pending'] ?? 0;
            $approvedCount = $statusCounts['approved'] ?? 0;
            $releasedCount = $statusCounts['released'] ?? 0;

            return view($viewName, compact('paginatedSchedules', 'pendingApprovalsCount', 'approvedCount', 'releasedCount', 'search'));
        }

        // view for # of appointments - pending
        public function getPendingApprovalsCount()
        {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $pendingApprovalsCount = TblSchedule::where('status', 'pending')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();

            return $pendingApprovalsCount;
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


    public function showAppointments(Request $request)
        {
            $search = $request->input('search', '');
            $sort = $request->input('sort', 'scheduled_date');
            $direction = $request->input('direction', 'asc');

            $query = TblSchedule::query();

            if (!empty($search)) {
                $query->where(function ($query) use ($search) {
                    $query->where('reference_id', 'like', '%' . $search . '%')
                          ->orWhere('creator_id', 'like', '%' . $search . '%')
                          ->orWhereHas('user', function ($query) use ($search) {
                              $query->where('last_name', 'like', '%' . $search . '%')
                                    ->orWhere('first_name', 'like', '%' . $search . '%')
                                    ->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'like', '%' . $search . '%');
                          });
                });
            }


            if ($sort == 'month') {
                $query->select('*', DB::raw('MONTH(scheduled_date) as month'), DB::raw('YEAR(scheduled_date) as year'))
                      ->groupBy('month', 'year')
                      ->orderBy('year', 'asc')
                      ->orderBy('month', 'asc');
            }

            $schedules = $query->paginate(6)->withQueryString();

            return view('manage_appointments.index', compact('schedules', 'search'));
        }


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

            $appointments = TblSchedule::where('creator_id', $creatorId)
                                        ->select('reference_id', 'scheduled_date', 'start_time', 'purpose', 'status')
                                        ->get();

            return response()->json(['message' => 'Appointments retrieved successfully', 'appointments' => $appointments], 200);
        }



        public function deleteScheduleAndroid(Request $request)
            {
                $validator = Validator::make($request->all(), [
                'reference_id' => 'required|string',
                ]);

                if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
                }

                $schedule = TblSchedule::where('reference_id', $request->reference_id)->first();

                if (!$schedule) {
                return response()->json(['message' => 'Schedule not found'], 404);
                }

                $schedule->delete();

                return response()->json(['message' => 'Schedule deleted successfully'], 200);
            }

            // update schedule for android
            public function updateScheduleAndroid(Request $request, $reference_id)
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
                $appointment->save();

                return response()->json(['message' => 'Appointment rescheduled successfully']);
            }


}
