<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    //
    public function index(Request $request)
    {
        $today = Carbon::today();
        $userId = auth()->id();

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $attendances = Attendance::where('user_id', auth()->id());

        if ($start_date) {
            $attendances = $attendances->whereDate('date', '>=', $start_date);
        }

        if ($end_date) {
            $attendances = $attendances->whereDate('date', '<=', $end_date);
        }

        $attendances = $attendances->orderBy('date', 'DESC')->paginate(5);

        if ($request->input('action') == "download") {
            $pdf = PDF::loadView('attendance.attendance_summary_pdf', compact('attendances'));
            return $pdf->download('attendance_summary_' . auth()->user()->name . '.pdf');
        } else {
            $attendance = Attendance::where('user_id', $userId)
                ->whereDate('date', $today)
                ->first();

            $is_check_in = true;
            $is_check_out = true;
            if ($attendance) {
                if (!$attendance->is_check_in) {
                    $is_check_in = false;
                } else if (!$attendance->is_check_out) {
                    $is_check_out = false;
                }
            } else {
                $is_check_in = false;
            }
            return view('attendance.index', compact('attendances', 'is_check_in', 'is_check_out'));
        }
    }

    public function checkIn(): \Illuminate\Http\RedirectResponse
    {
        notify()->success('Check-in');
        $today = Carbon::today();
        $userId = auth()->id();

        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->first();

        $officeStart = '09:00:00';
        $isLate = Carbon::now()->toTimeString() > $officeStart;
        $late_time = null;
        if ($isLate) {
            $difference = strtotime(Carbon::now()->toTimeString()) - strtotime($officeStart);
            $late_time = $difference / 60;
        }

        if ($attendance) {
            if ($attendance->is_check_in) {
                notify()->error('You have already checked in today!');
                return redirect()->back();
            }

            $attendance->user_id = $userId;
            $attendance->check_in = Carbon::now()->toTimeString();
            $attendance->is_check_in = true;
            $attendance->is_late = $isLate;
            $attendance->late_time = $late_time;
        } else {
            $attendance = new Attendance;
            $attendance->user_id = $userId;
            $attendance->check_in = Carbon::now()->toTimeString();
            $attendance->is_check_in = true;
            $attendance->is_late = $isLate;
            $attendance->late_time = $late_time;
            $attendance->date = Carbon::now()->toDateString();
        }
        $attendance->save();

        notify()->success('Check-in Successful.');
        return redirect()->back();
    }

    public function checkOut(): \Illuminate\Http\RedirectResponse
    {
        // Code to handle check-out request
        $today = Carbon::today();
        $userId = auth()->id();

        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            if (!$attendance->is_check_in) {
                notify()->error('You have already checked in today!');
                return redirect()->back();
            }
            if ($attendance->is_check_out) {
                notify()->error('You have already checked out today!');
                return redirect()->back();
            }

            $officeEnd = '17:00:00';
            $isEarlyOut = Carbon::now()->toTimeString() < $officeEnd;
            $earlyOutTime = null;
            if ($isEarlyOut) {
                $difference = strtotime($officeEnd) - strtotime(Carbon::now()->toTimeString());
                $earlyOutTime = $difference / 60;
            }

            $attendance->check_out = Carbon::now()->toTimeString();
            $attendance->is_check_out = true;
            $attendance->is_early_out = $isEarlyOut;
            $attendance->early_out_time = $earlyOutTime;
            $attendance->save();
        }

        notify()->success('Check-out Successful.');
        return redirect()->back()->with('error', 'You have not checked in today!');
    }

    public function generatePDF(Request $request): \Illuminate\Http\Response
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $attendances = Attendance::where('user_id', auth()->id());

        if ($start_date) {
            $attendances = $attendances->whereDate('date', '>=', $start_date);
        }

        if ($end_date) {
            $attendances = $attendances->whereDate('date', '<=', $end_date);
        }

        $attendances = $attendances->orderBy('date', 'DESC');

        $pdf = PDF::loadView('attendance.attendance_summary_pdf', compact('attendances'));
        return $pdf->download('attendance_summary.pdf');
    }

    private function generateAttendanceSummaryPdf($attendances): string
    {
        $pdf = PDF::loadView('attendance.attendance_summary_pdf', ['attendances' => $attendances]);
        $pdfFilePath = storage_path('app/public/attendance_summary.pdf');
        $pdf->save($pdfFilePath);

        return $pdfFilePath;
    }

    public function admin(Request $request)
    {
        $users = User::all();

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $userId = $request->user_id;

        $attendances = Attendance::query();

//        if (!$userId) {
//            $users[0];
//        }

        $attendances = $attendances->where('user_id', $userId);

        if ($start_date) {
            $attendances = $attendances->whereDate('date', '>=', $start_date);
        }

        if ($end_date) {
            $attendances = $attendances->whereDate('date', '<=', $end_date);
        }

        $attendances = $attendances->orderBy('date', 'DESC')->paginate(5);

        if ($request->input('action') == "download") {
            $pdf = PDF::loadView('attendance.attendance_summary_pdf', compact('attendances'));
            return $pdf->download('attendance_summary_' . auth()->user()->name . '.pdf');
        } else {
            return view('attendance.admin', compact('users', 'attendances'));
        }
    }
}
