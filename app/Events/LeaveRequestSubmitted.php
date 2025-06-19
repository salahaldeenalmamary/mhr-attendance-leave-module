<?php

namespace App\Events;

use App\Models\LeaveRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The newly submitted leave request instance.
     *
     * @var \App\Models\LeaveRequest
     */
    public $leaveRequest;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\LeaveRequest $leaveRequest
     * @return void
     */
    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }
}