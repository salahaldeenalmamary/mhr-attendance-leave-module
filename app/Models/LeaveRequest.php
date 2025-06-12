<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
     protected $fillable = [
        'employee_id', 'leave_type_id', 'start_date', 'end_date',
        'requested_days', 'reason', 'status',
        'approver_id', 'approver_comments',
    ];
protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    'created_at' => 'datetime',
];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
