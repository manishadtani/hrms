<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Attendance Model
 * 
 * Key feature: Working hours auto-calculation
 * When clock_out is set, working_hours is automatically calculated.
 */
class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'clock_in',
        'clock_out',
        'working_hours',
        'status',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
        'working_hours' => 'decimal:2',
    ];

    /**
     * Attendance belongs to an Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Auto-calculate working hours when clock_in and clock_out are both set
     * 
     * MERN mein tum manually calculate karte:
     * const hours = (clockOut - clockIn) / (1000 * 60 * 60);
     * 
     * Laravel mein Carbon library se:
     * Carbon::parse($clockIn)->diffInMinutes($clockOut) / 60
     */
    public function calculateWorkingHours()
    {
        if ($this->clock_in && $this->clock_out) {
            $clockIn = Carbon::parse($this->clock_in);
            $clockOut = Carbon::parse($this->clock_out);
            $this->working_hours = round($clockIn->diffInMinutes($clockOut) / 60, 2);
        }
        return $this->working_hours;
    }

    /**
     * Get formatted clock in time
     */
    public function getFormattedClockInAttribute()
    {
        return $this->clock_in ? Carbon::parse($this->clock_in)->format('h:i A') : '-';
    }

    /**
     * Get formatted clock out time
     */
    public function getFormattedClockOutAttribute()
    {
        return $this->clock_out ? Carbon::parse($this->clock_out)->format('h:i A') : '-';
    }
}
