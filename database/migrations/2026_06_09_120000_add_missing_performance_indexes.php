<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add missing indexes for columns used in WHERE/ORDER BY
 * but not yet indexed — identified during performance audit.
 */
return new class extends Migration
{
    public function up(): void
    {
        // announcements.status — filtered in every dashboard + public view
        if (Schema::hasColumn('announcements', 'status')) {
            Schema::table('announcements', function (Blueprint $table) {
                $table->index('status', 'idx_announcements_status');
            });
        }

        // announcements.published_at — used in orderBy/latest
        if (Schema::hasColumn('announcements', 'published_at')) {
            Schema::table('announcements', function (Blueprint $table) {
                $table->index('published_at', 'idx_announcements_published_at');
            });
        }

        // holidays.is_active — filtered in every holiday query
        if (Schema::hasColumn('holidays', 'is_active')) {
            Schema::table('holidays', function (Blueprint $table) {
                $table->index('is_active', 'idx_holidays_is_active');
            });
        }

        // leave_balances.year — filtered by current year in dashboard/leaves
        if (Schema::hasColumn('leave_balances', 'year')) {
            Schema::table('leave_balances', function (Blueprint $table) {
                $table->index('year', 'idx_leave_balances_year');
            });
        }
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex('idx_announcements_status');
        });
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex('idx_announcements_published_at');
        });
        Schema::table('holidays', function (Blueprint $table) {
            $table->dropIndex('idx_holidays_is_active');
        });
        Schema::table('leave_balances', function (Blueprint $table) {
            $table->dropIndex('idx_leave_balances_year');
        });
    }
};
