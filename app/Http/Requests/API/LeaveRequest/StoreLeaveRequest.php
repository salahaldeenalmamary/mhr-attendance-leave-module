<?php

namespace App\Http\Requests\API\LeaveRequest;

use \App\Http\Requests\API\ApiRequest;

class StoreLeaveRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }
    public function rules(): array
    {
        return [
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'requested_days'=>'required|int'

        ];
    }

    public function messages(): array
    {
        return [
            'leave_type_id.required' => 'You must select a leave type.',
            'start_date.after_or_equal' => 'The start date cannot be in the past.',
            'end_date.after_or_equal' => 'The end date must be on or after the start date.',
        ];
    }
}
