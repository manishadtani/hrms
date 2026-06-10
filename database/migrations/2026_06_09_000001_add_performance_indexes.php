<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add performance indexes on frequently queried columns.
     * This helps handle 200+ concurrent users efficiently.
     */
    public function up(): void
    {
        // Attendance - date is used in every date-range filter
        Schema::table('attendances', function (Blueprint $table) {
            $table->index('date');
            $table->index('status');
        });

        // Leave requests - status and dates used in every filter/dashboard
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
        });

        // Employees - employment_status filtered on every list page
        Schema::table('employees', function (Blueprint $table) {
            $table->index('employment_status');
        });

        // Holidays - date used in year filters and calendar
        Schema::table('holidays', function (Blueprint $table) {
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['date']);
            $table->dropIndex(['status']);
        });

        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['start_date']);
            $table->dropIndex(['end_date']);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex(['employment_status']);
        });

        Schema::table('holidays', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });
    }
};
