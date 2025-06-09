<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = [
        'employee_id', 'attendance_date', 'clock_in_time', 'clock_out_time',
        'status', 'notes', 'source',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
