<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Setting;
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

    public function checkIn(Request $request)
    {
        $this->checkDistance($request);
        $today = Carbon::today();
        $userId = auth()->id();

        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->first();

        $setting = Setting::where("name", 'check-in-time')->first();;
        $officeStart = $setting != null ? $setting->value : '09:00:00';
        $isLate = Carbon::now()->toTimeString() > $officeStart;
        $late_time = null;
        if ($isLate) {
            $difference = strtotime(Carbon::now()->toTimeString()) - strtotime($officeStart);
            $late_time = $difference / 60;
        }

        if ($attendance) {
            if ($attendance->is_check_in) {
//                notify()->error('You have already checked in today!');
//                return response()->json([
//                    'success' => false,
//                    'message' => 'You have already checked in today!'
//                ]);
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
        return response()->json([
            'success' => true,
            'message' => 'Check-in Successful.'
        ]);
    }

    public function checkOut(Request $request)
    {
        $this->checkDistance($request);
        // Code to handle check-out request
        $today = Carbon::today();
        $userId = auth()->id();

        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            if (!$attendance->is_check_in) {
                notify()->error('You have already checked in today!');
                return response()->json([
                    'success' => false,
                    'message' => 'You have already checked in today!'
                ]);
            }
            if ($attendance->is_check_out) {
                notify()->error('You have already checked out today!');
                return response()->json([
                    'success' => false,
                    'message' => 'You have already checked out today!'
                ]);
            }

            $setting = Setting::where("name", 'check-out-time')->first();
            $officeEnd = $setting != null ? $setting->value : '17:00:00';
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
        return response()->json([
            'success' => true,
            'message' => 'Check-out Successful'
        ]);
    }

    public function checkDistance(Request $request) {
        $settingLatitude = Setting::where("name", 'latitude')->first();;
        $settingLongitude = Setting::where("name", 'longitude')->first();;
        $latitudeFrom = $request->latitude;
        $longitudeFrom = $request->longitude;
        $latitudeTo = $settingLatitude->value;
        $longitudeTo = $settingLongitude->value;
        $distance = $this->getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
        if ($distance > 1) {
            notify()->error('Not in area');
            return response()->json([
                'success' => false,
                'message' => 'Not in area'
            ]);
        }
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

    function calculateDistanceBetweenTwoAddresses($latitudeFrom, $longitudeFrom,
                                                  $latitudeTo, $longitudeTo)
    {
        $long1 = deg2rad($longitudeFrom);
        $long2 = deg2rad($longitudeTo);
        $lat1 = deg2rad($latitudeFrom);
        $lat2 = deg2rad($latitudeTo);

        //Haversine Formula
        $dlong = $long2 - $long1;
        $dlati = $lat2 - $lat1;

        $val = pow(sin($dlati / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($dlong / 2), 2);

        $res = 2 * asin(sqrt($val));

        $radius = 3958.756;

        Log::info($res * $radius);
        return ($res * $radius);
    }

    function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        Log::info($lat1);
        Log::info($lon1);
        Log::info($lat2);
        Log::info($lon2);
        $radius = 6371; // Earth's radius in km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $radius * $c; // distance between two points in km
        Log::info($distance);
        return $distance;
    }
}
