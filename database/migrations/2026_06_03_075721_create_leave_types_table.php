<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Leave Types — CL, SL, EL, WFH, Custom types
 * Admin can configure these.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();             // "Casual Leave", "Sick Leave"
            $table->string('code', 10)->unique();          // "CL", "SL", "EL", "WFH"
            $table->integer('days_per_year')->default(12); // Total allowed days per year
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
