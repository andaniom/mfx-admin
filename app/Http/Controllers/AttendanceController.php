<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    //
    public function index(Request $request)
    {
        $today = Carbon::today();
        $userId = auth()->id();

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $attendance = Attendance::where('user_id', auth()->id());

        if ($start_date) {
            $attendance = $attendance->whereDate('date', '>=', $start_date);
        }

        if ($end_date) {
            $attendance = $attendance->whereDate('date', '<=', $end_date);
        }

        $attendances = $attendance->orderBy('date', 'DESC')->paginate(5);

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
        }

        return view('attendance.index', compact('attendances', 'is_check_in', 'is_check_out'));
    }

    public function checkIn(Request $request)
    {
        $today = Carbon::today();
        $userId = auth()->id();

        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            if ($attendance->is_check_in) {
                session()->flash('error', 'You have already checked in today!');
                return redirect()->back()->with('error', 'You have already checked in today!');
            }
            $officeStart = '09:00:00';
            $isLate = Carbon::now()->toTimeString() > $officeStart;
            $late_time = null;
            if ($isLate) {
                $difference = strtotime(Carbon::now()->toTimeString()) - strtotime($officeStart);
                $late_time = $difference / 60;
            }

            $attendance->user_id = auth()->id();
            $attendance->check_in = Carbon::now()->toTimeString();
            $attendance->is_check_in = true;
            $attendance->is_late = $isLate;
            $attendance->late_time = $late_time;
            $attendance->save();
        } else {
            session()->flash('error', 'You have already checked in today!');
            return redirect()->back()->with('error', 'You have already checked in today!');
        }

        session()->flash('success', 'Check-in Successful');
        return redirect()->back()->with('message', 'Check-in successful!');
    }

    public function checkOut(Request $request)
    {
        // Code to handle check-out request
        $today = Carbon::today();
        $userId = auth()->id();

        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            if (!$attendance->is_check_in) {
                session()->flash('error', 'You have already checked in today!');
                return redirect()->back()->with('error', 'You have not checked in today!');
            }
            if ($attendance->is_check_out) {
                session()->flash('error', 'You have already checked out today!');
                return redirect()->back()->with('error', 'You have already checked out today!');
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

        session()->flash('success', 'Check-out Successful');
        return redirect()->back()->with('error', 'You have not checked in today!');
    }
}
