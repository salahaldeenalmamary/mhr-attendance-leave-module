<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->date('attendance_date');
            $table->time('clock_in_time')->nullable();
            $table->time('clock_out_time')->nullable();
            $table->enum('status', ['Present', 'Absent', 'On Approved Leave', 'Holiday', 'Weekend'])->default('Absent');
            $table->text('notes')->nullable();
            $table->enum('source', ['Biometric', 'Manual Entry', 'GPS'])->default('Manual Entry');
            $table->timestamps();

            $table->unique(['employee_id', 'attendance_date'], 'uk_user_attendance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
