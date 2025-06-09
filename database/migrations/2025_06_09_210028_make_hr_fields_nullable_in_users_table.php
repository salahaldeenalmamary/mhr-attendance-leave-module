<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('employee_code', 50)->nullable()->change();
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('job_title')->nullable()->change();
            $table->enum('employment_status', ['Active', 'Inactive', 'Terminated', 'On Leave', 'Probation'])
                ->nullable()
                ->default(null)
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert changes (nullable => not nullable)
            $table->string('employee_code', 50)->nullable(false)->change();
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
            $table->string('job_title')->nullable(false)->change();
            $table->enum('employment_status', ['Active', 'Inactive', 'Terminated', 'On Leave', 'Probation'])
                ->default('Probation')
                ->nullable(false)
                ->change();
        });
    }
};
