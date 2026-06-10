<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Employee\AttendanceController as EmployeeAttendanceController;
use App\Http\Controllers\Manager\AttendanceController as ManagerAttendanceController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\Employee\LeaveController as EmployeeLeaveController;
use App\Http\Controllers\Manager\LeaveController as ManagerLeaveController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Employee\ProfileController as EmployeeProfileController;
use App\Http\Controllers\Manager\TeamController as ManagerTeamController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Auth\OtpPasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// OTP Password Reset Routes
Route::get('/password/forgot', [OtpPasswordResetController::class, 'showForgotForm'])->name('password.otp.forgot');
Route::post('/password/otp/send', [OtpPasswordResetController::class, 'sendOtp'])->name('password.otp.send');
Route::get('/password/otp/verify', [OtpPasswordResetController::class, 'showVerifyForm'])->name('password.otp.verify.form');
Route::post('/password/otp/verify', [OtpPasswordResetController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('/password/otp/reset', [OtpPasswordResetController::class, 'showResetForm'])->name('password.otp.reset.form');
Route::post('/password/otp/reset', [OtpPasswordResetController::class, 'resetPassword'])->name('password.otp.reset');

/*
|--------------------------------------------------------------------------
| Shared Routes (All authenticated users)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Change Password
    Route::get('/change-password', [ChangePasswordController::class, 'showForm'])->name('change-password');
    Route::put('/change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');

    // Holiday Calendar (all roles can view)
    Route::get('/holidays', [HolidayController::class, 'calendar'])->name('holidays.calendar');

    // Announcements (all roles can view published)
    Route::get('/announcements', [AnnouncementController::class, 'publicIndex'])->name('announcements.public');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Phase 3: Employee Management
    Route::resource('departments', DepartmentController::class)->except(['show']);
    Route::resource('designations', DesignationController::class)->except(['show']);
    Route::resource('employees', EmployeeController::class);

    // Phase 4: Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::get('/attendance/monthly-report', [AttendanceController::class, 'monthlyReport'])->name('attendance.monthly-report');

    // Phase 5: Leave Management
    Route::resource('leave-types', LeaveTypeController::class)->except(['show']);
    Route::get('/leaves', [LeaveRequestController::class, 'index'])->name('leaves.index');
    Route::put('/leaves/{leaveRequest}/status', [LeaveRequestController::class, 'updateStatus'])->name('leaves.update-status');

    // Phase 6A: Holiday Management
    Route::resource('holidays', HolidayController::class)->except(['show']);

    // Phase 6A: Announcement Management
    Route::resource('announcements', AnnouncementController::class)->except(['show']);

    // Phase 6A: User Management
    Route::resource('users', UserController::class)->except(['show']);
    Route::put('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // Phase 6B: Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/employees', [ReportController::class, 'employees'])->name('reports.employees');
    Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('/reports/leaves', [ReportController::class, 'leaves'])->name('reports.leaves');
    Route::get('/reports/holidays', [ReportController::class, 'holidays'])->name('reports.holidays');

    // Phase 8: Export Routes (Excel & PDF)
    Route::get('/reports/employees/export', [ReportController::class, 'exportEmployees'])->name('reports.employees.export');
    Route::get('/reports/attendance/export', [ReportController::class, 'exportAttendance'])->name('reports.attendance.export');
    Route::get('/reports/leaves/export', [ReportController::class, 'exportLeaves'])->name('reports.leaves.export');
    Route::get('/reports/holidays/export', [ReportController::class, 'exportHolidays'])->name('reports.holidays.export');

    // Phase 7: Role & Permission Management
    Route::resource('roles', RoleController::class)->except(['show']);

    // Phase 7: Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::post('/activity-logs/clear', [ActivityLogController::class, 'clear'])->name('activity-logs.clear');
});

/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/attendance', [ManagerAttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/my', [ManagerAttendanceController::class, 'myAttendance'])->name('attendance.my');

    Route::get('/leaves', [ManagerLeaveController::class, 'index'])->name('leaves.index');
    Route::put('/leaves/{leaveRequest}/status', [ManagerLeaveController::class, 'updateStatus'])->name('leaves.update-status');
    Route::get('/leaves/my', [ManagerLeaveController::class, 'myLeaves'])->name('leaves.my');

    // Phase 6B: Team View
    Route::get('/team', [ManagerTeamController::class, 'index'])->name('team.index');
});

/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');

    Route::get('/attendance', [EmployeeAttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/clock-in', [EmployeeAttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [EmployeeAttendanceController::class, 'clockOut'])->name('attendance.clock-out');

    Route::get('/leaves', [EmployeeLeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/apply', [EmployeeLeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [EmployeeLeaveController::class, 'store'])->name('leaves.store');
    Route::put('/leaves/{leaveRequest}/cancel', [EmployeeLeaveController::class, 'cancel'])->name('leaves.cancel');

    // Phase 6B: Self-Service Profile
    Route::get('/profile', [EmployeeProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [EmployeeProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [EmployeeProfileController::class, 'update'])->name('profile.update');
});
