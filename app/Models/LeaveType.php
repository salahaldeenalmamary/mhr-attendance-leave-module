<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = ['name', 'description','requires_approval', 'is_paid'];

    public static function fromAttributes(
    string $name,
    ?string $description = null,
  
    bool $requiresApproval = true,
    bool $isPaid = true
): static {
    return new static([
        'name' => $name,
        'description' => $description,
       
        'requires_approval' => $requiresApproval,
        'is_paid' => $isPaid,
    ]);
}

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

}


