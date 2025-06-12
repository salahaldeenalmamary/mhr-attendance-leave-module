<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id' => $this->id,
            'start_date' => $this->start_date->toDateString(),
            'end_date' => $this->end_date->toDateString(),
            'requested_days' =>$this->requested_days,
            'reason' => $this->reason,
            'status' => $this->status,
            'rejection_reason' => $this->when($this->status === 'Rejected', $this->rejection_reason),
            'submitted_on' => $this->created_at->toDateTimeString(),
            'leave_type' => new LeaveTypeResource($this->whenLoaded('leaveType')),
        ];
    }
}
