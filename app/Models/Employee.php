<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * Employee Model — Core model as per SOW
 * 
 * RELATIONSHIPS:
 * - belongsTo User (login account)
 * - belongsTo Department
 * - belongsTo Designation
 * - belongsTo User as Manager (reporting manager)
 * 
 * MERN equivalent:
 * employeeSchema = new Schema({
 *     user: { type: ObjectId, ref: 'User' },
 *     department: { type: ObjectId, ref: 'Department' },
 *     ...
 * });
 * Employee.find().populate('user department designation manager')
 * 
 * Laravel mein:
 * Employee::with(['user', 'department', 'designation', 'manager'])->get()
 */
class Employee extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['first_name', 'last_name', 'department_id', 'designation_id', 'employment_status', 'manager_id'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Employee {$this->full_name} was {$eventName}");
    }

    protected $fillable = [
        'user_id',
        'employee_code',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'address',
        'department_id',
        'designation_id',
        'manager_id',
        'joining_date',
        'employment_status',
        'profile_photo',
    ];

    /**
     * Cast date fields so we can use ->format('d M Y') in Blade
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
    ];

    /**
     * Employee belongs to a User (login account)
     * $employee->user->email
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Employee belongs to a Department
     * $employee->department->name → "IT Department"
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Employee belongs to a Designation
     * $employee->designation->name → "Software Engineer"
     */
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    /**
     * Employee has a Reporting Manager (who is also a User)
     * $employee->manager->name → "Nitin Jain"
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Employee has many attendance records
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Employee has many leave requests
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * Employee has many leave balances
     */
    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }
}
