<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = ['name', 'description', 'default_annual_entitlement', 'requires_approval', 'is_paid'];

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
