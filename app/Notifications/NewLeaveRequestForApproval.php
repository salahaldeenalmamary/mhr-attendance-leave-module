<?php

namespace App\Notifications;

use App\Models\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeaveRequestForApproval extends Notification
{
    use Queueable;

    protected $leaveRequest;

    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    
    public function via(object $notifiable): array
    {
       
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $employeeName = $this->leaveRequest->user->name;
        $leaveType = $this->leaveRequest->leaveType->name;
        $url = url('/dashboard/leave-requests/' . $this->leaveRequest->id); 

        return (new MailMessage)
                    ->subject("New Leave Request from {$employeeName}")
                    ->line("A new leave request has been submitted by {$employeeName} for your approval.")
                    ->line("Type: {$leaveType}")
                    ->line("Dates: {$this->leaveRequest->start_date->format('M d, Y')} to {$this->leaveRequest->end_date->format('M d, Y')}")
                    ->action('View Request', $url)
                    ->line('Thank you for your attention to this matter.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'leave_request_id' => $this->leaveRequest->id,
            'employee_name' => $this->leaveRequest->user->name,
            'message' => 'A new leave request requires your approval.',
        ];
    }
}