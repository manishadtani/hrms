<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Leave Balances — Tracks how many leaves each employee has per type per year
 * 
 * Example: Employee EMP001 has CL: 12 total, 3 used, 9 remaining
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('leave_type_id')->constrained('leave_types')->onDelete('cascade');
            $table->year('year');                            // 2024, 2025, 2026
            $table->integer('total_days')->default(0);       // Allocated for this year
            $table->integer('used_days')->default(0);        // Used so far
            $table->integer('remaining_days')->default(0);   // total - used
            $table->timestamps();

            // One balance per employee per leave type per year
            $table->unique(['employee_id', 'leave_type_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
