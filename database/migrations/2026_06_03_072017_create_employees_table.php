<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Employees Table — Core table as per SOW
 * 
 * Stores:
 * - Personal Details (name, gender, DOB, contact, address)
 * - Employment Details (employee code, department, designation, manager, joining date, status)
 * 
 * RELATIONSHIPS (Foreign Keys):
 * employees.user_id        → users.id       (1 employee = 1 login user)
 * employees.department_id  → departments.id (1 employee belongs to 1 department)
 * employees.designation_id → designations.id(1 employee has 1 designation)
 * employees.manager_id     → users.id       (1 employee has 1 reporting manager)
 * 
 * MERN comparison:
 * In MongoDB you'd use ref + populate for relationships.
 * In MySQL we use foreign keys — database ENFORCES the relationship!
 * If department is deleted, you can't have orphan employees.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Link to users table (login account)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Personal Details
            $table->string('employee_code')->unique();       // e.g., EMP001
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            // Employment Details
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignId('designation_id')->nullable()->constrained('designations')->onDelete('set null');
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('joining_date')->nullable();
            $table->enum('employment_status', ['active', 'inactive', 'terminated', 'resigned'])->default('active');

            // Profile photo
            $table->string('profile_photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
