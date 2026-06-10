<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * View own attendance records with monthly summary
     */
    public function index(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile not found.');
        }

        $month = $request->filled('month') ? $request->month : Carbon::now()->format('Y-m');
        $startDate = Carbon::parse($month)->startOfMonth();
        $endDate = Carbon::parse($month)->endOfMonth();

        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        // Monthly summary
        $summary = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'half_day' => $attendances->where('status', 'half_day')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'total_hours' => $attendances->sum('working_hours'),
        ];

        // Today's attendance
        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->where('date', Carbon::today())
            ->first();

        return view('employee.attendance.index', compact('attendances', 'summary', 'month', 'todayAttendance', 'employee'));
    }

    /**
     * Validate if user is at office location (IP or GPS)
     *
     * @return true|string  Returns true if allowed, or error message string
     */
    private function validateLocation(Request $request)
    {
        $mode = env('CLOCK_IN_RESTRICTION', 'both');

        // No restriction
        if ($mode === 'none') {
            return true;
        }

        $allowedIps = array_map('trim', explode(',', env('OFFICE_ALLOWED_IPS', '127.0.0.1')));
        $officeLat = (float) env('OFFICE_LAT', 0);
        $officeLng = (float) env('OFFICE_LNG', 0);
        $radiusMeters = (float) env('OFFICE_RADIUS_METERS', 200);

        // Get client IP
        // ORIGINAL: $clientIp = $request->ip();
        $clientIp = '72.229.28.185'; // DEMO: New York, USA IP (uncomment above for production)
        $ipMatch = in_array($clientIp, $allowedIps);

        // Get GPS from form
        $userLat = $request->input('latitude');
        $userLng = $request->input('longitude');
        $gpsProvided = $userLat && $userLng;
        $gpsMatch = false;

        if ($gpsProvided && $officeLat && $officeLng) {
            $distance = $this->calculateDistance($officeLat, $officeLng, (float)$userLat, (float)$userLng);
            $gpsMatch = $distance <= $radiusMeters;
        }

        // Validation logic based on mode
        switch ($mode) {
            case 'ip':
                if (!$ipMatch) {
                    return 'Clock in/out is only allowed from office network. Your IP: ' . $clientIp;
                }
                return true;

            case 'gps':
                if (!$gpsProvided) {
                    return 'Location access is required. Please allow location permission in your browser and try again.';
                }
                if (!$gpsMatch) {
                    $distance = $this->calculateDistance($officeLat, $officeLng, (float)$userLat, (float)$userLng);
                    return 'You are ' . round($distance) . 'm away from office. Clock in/out is only allowed within ' . $radiusMeters . 'm of office.';
                }
                return true;

            case 'both':
            default:
                // Either IP match OR GPS match is sufficient
                if ($ipMatch) {
                    return true; // On office network — GPS not needed
                }
                if ($gpsProvided && $gpsMatch) {
                    return true; // GPS within radius
                }
                if (!$gpsProvided) {
                    return 'You are not on the office network (IP: ' . $clientIp . '). Please allow location access to verify you are at the office.';
                }
                $distance = $this->calculateDistance($officeLat, $officeLng, (float)$userLat, (float)$userLng);
                return 'You are ' . round($distance) . 'm away from office. Clock in/out is only allowed from office network or within ' . $radiusMeters . 'm of office.';
        }
    }

    /**
     * Calculate distance between two GPS coordinates using Haversine formula
     *
     * @return float Distance in meters
     */
    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Clock In — Record today's in-time
     */
    public function clockIn(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee profile not found.');
        }

        // Location validation
        $locationCheck = $this->validateLocation($request);
        if ($locationCheck !== true) {
            return redirect()->back()->with('error', $locationCheck);
        }

        // Check if already clocked in today
        $today = Attendance::where('employee_id', $employee->id)
            ->where('date', Carbon::today())
            ->first();

        if ($today) {
            return redirect()->back()->with('error', 'You have already clocked in today!');
        }

        Attendance::create([
            'employee_id' => $employee->id,
            'date' => Carbon::today(),
            'clock_in' => Carbon::now()->format('H:i:s'),
            'status' => 'present',
        ]);

        return redirect()->back()->with('success', 'Clocked in successfully at ' . Carbon::now()->format('h:i A'));
    }

    /**
     * Clock Out — Record today's out-time & calculate working hours
     */
    public function clockOut(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee profile not found.');
        }

        // Location validation
        $locationCheck = $this->validateLocation($request);
        if ($locationCheck !== true) {
            return redirect()->back()->with('error', $locationCheck);
        }

        $today = Attendance::where('employee_id', $employee->id)
            ->where('date', Carbon::today())
            ->first();

        if (!$today) {
            return redirect()->back()->with('error', 'You have not clocked in today!');
        }

        if ($today->clock_out) {
            return redirect()->back()->with('error', 'You have already clocked out today!');
        }

        $today->clock_out = Carbon::now()->format('H:i:s');
        $today->calculateWorkingHours();

        // Auto-set half day if worked less than 4 hours
        if ($today->working_hours < 4) {
            $today->status = 'half_day';
        }

        $today->save();

        return redirect()->back()->with('success', 'Clocked out successfully at ' . Carbon::now()->format('h:i A') . '. Worked: ' . $today->working_hours . ' hours');
    }
}
