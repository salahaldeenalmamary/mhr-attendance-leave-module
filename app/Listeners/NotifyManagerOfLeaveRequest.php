<?php

namespace App\Listeners;

use App\Events\LeaveRequestSubmitted;
use App\Models\User; 
use App\Notifications\NewLeaveRequestForApproval;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyManagerOfLeaveRequest implements ShouldQueue
{
    use InteractsWithQueue;


    const APPROVER_ROLE = 'Manager';

    /**
     * Handle the "LeaveRequestSubmitted" event.
     *
     * @param \App\Events\LeaveRequestSubmitted $event
     * @return void
     */
    public function handle(LeaveRequestSubmitted $event): void
    {
      $leaveRequest = $event->leaveRequest->load(['employee', 'leaveType']);

        $leaveRequest = $event->leaveRequest;

        $managers = User::role(self::APPROVER_ROLE)->get();

        // 2. Check if any managers were found.
        if ($managers->isEmpty()) {
            // If no users have the 'Manager' role, this is a critical configuration error.
            Log::error(
                "CRITICAL: Could not find any users with the '" . self::APPROVER_ROLE . "' role to notify for leave request [ID: {$leaveRequest->id}]. The request requires manual attention."
            );
            return; 
        }

       
        foreach ($managers as $manager) {
            $manager->notify(new NewLeaveRequestForApproval($leaveRequest));
        }

     
        Log::info(
            "Notified " . $managers->count() . " users with the '" . self::APPROVER_ROLE . "' role about a new leave request [ID: {$leaveRequest->id}]."
        );
    }
}
