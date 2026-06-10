<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Attendance Table — Daily attendance records
 * 
 * Each row = 1 employee's attendance for 1 day
 * 
 * MERN equivalent:
 * attendanceSchema = new Schema({
 *     employee: { type: ObjectId, ref: 'Employee' },
 *     date: Date,
 *     clock_in: Date,
 *     clock_out: Date,
 *     status: { type: String, enum: ['present','absent','half_day','leave','holiday'] }
 * });
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('date');                                    // Attendance date
            $table->time('clock_in')->nullable();                    // In-Time (e.g., 09:30:00)
            $table->time('clock_out')->nullable();                   // Out-Time (e.g., 18:30:00)
            $table->decimal('working_hours', 5, 2)->default(0);      // Auto-calculated hours
            $table->enum('status', [
                'present', 'absent', 'half_day', 'leave', 'holiday'
            ])->default('present');
            $table->text('remarks')->nullable();                     // Admin notes / corrections
            $table->timestamps();

            // Unique constraint: 1 employee can have only 1 attendance per day
            $table->unique(['employee_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
