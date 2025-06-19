<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->attendance_date->toDateString(),
            
        
            'clock_in_time' => $this->whenNotNull(
                $this->clock_in_time, 
                fn() => $this->clock_in_time->format('H:i:s')
            ),

       
       'clock_out_time' => $this->clock_out_time ? $this->clock_out_time->format('H:i:s') : null,
            'status' => $this->status,
            'notes' => $this->whenNotNull($this->notes),
            'source' => $this->source,
        ];
    }
}