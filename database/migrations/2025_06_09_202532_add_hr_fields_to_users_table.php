<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // HR-specific fields
            $table->string('employee_code', 50)->unique();
        
            $table->string('first_name')->after('name');
            $table->string('last_name')->after('first_name');
            $table->string('phone_primary', 20)->nullable()->after('email');
            $table->date('hire_date')->nullable()->after('phone_primary');

            $table->foreignId('department_id')->nullable()->after('hire_date')->constrained()->nullOnDelete();
            $table->foreignId('employment_type_id')->nullable()->after('department_id')->constrained()->nullOnDelete();
            $table->string('job_title')->nullable()->after('employment_type_id');
            $table->foreignId('manager_id')->nullable()->after('job_title')->constrained('users')->nullOnDelete();

            $table->enum('employment_status', ['Active', 'Inactive', 'Terminated', 'On Leave', 'Probation'])->default('Probation')->after('manager_id');

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'employee_code','first_name', 'last_name',
                'phone_primary', 'hire_date', 'job_title', 'employment_status'
            ]);

            $table->dropSoftDeletes();

            $table->dropConstrainedForeignId('department_id');
            $table->dropConstrainedForeignId('employment_type_id');
            $table->dropConstrainedForeignId('manager_id');
        });
    }
};
