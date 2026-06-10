<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // "Republic Day", "Diwali"
            $table->date('date');                           // Holiday date
            $table->enum('type', ['national', 'regional', 'company', 'optional'])->default('company');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['date', 'name']);               // No duplicate holiday on same date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
