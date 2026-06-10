<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Departments Table
 * 
 * MERN equivalent (Mongoose Schema):
 * const departmentSchema = new Schema({
 *     name: { type: String, required: true, unique: true },
 *     description: String,
 *     is_active: { type: Boolean, default: true },
 * }, { timestamps: true });
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();                                    // Auto-increment ID (like MongoDB _id)
            $table->string('name')->unique();                // Department name (e.g., "IT", "HR")
            $table->text('description')->nullable();         // Optional description
            $table->boolean('is_active')->default(true);     // Soft active/inactive
            $table->timestamps();                            // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
