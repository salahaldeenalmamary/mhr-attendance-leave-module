<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\LeaveRequest\StoreLeaveRequest;
use App\Http\Resources\ApiResponseResource;
use App\Http\Resources\LeaveRequestResource;
use App\Models\LeaveRequest;
use App\Models\LeaveType;

class LeaveRequestController extends Controller
{
    public function getBalances()
    {
        $user = auth()->user();
        $balances = LeaveType::all()->map(function ($type) use ($user) {
            $taken = $user->leaveRequests()
                ->where('leave_type_id', $type->id)
                ->whereIn('status', ['Approved', 'Pending'])
                ->sum('requested_days');

            return [
                'leave_type_id' => $type->id,
                'leave_type_name' => $type->name,
            
                'taken' => (float) $taken,
                'available' => $type->default_annual_entitlement - $taken,
            ];
        });
        return ApiResponseResource::success($balances, 'Leave balances retrieved.');
    }


    public function store(StoreLeaveRequest $request)
    {
        $leaveRequest = auth()->user()->leaveRequests()->create($request->validated());
        return ApiResponseResource::success(new LeaveRequestResource($leaveRequest), 'Leave request submitted.')
            ->response()->setStatusCode(201);
    }

  
    public function index(Request $request)
    {
        $query = auth()->user()->leaveRequests()->with('leaveType')->latest();

        $query->when($request->query('status'), fn($q, $s) => $q->where('status', $s));
        $query->when($request->query('start_date'), fn($q, $d) => $q->whereDate('start_date', '>=', $d));

        return ApiResponseResource::success(
            LeaveRequestResource::collection($query->paginate(15))
        );
    }


    public function show(LeaveRequest $leave_request)
    {

        return ApiResponseResource::success(
            new LeaveRequestResource($leave_request->load('leaveType'))
        );
    }


    public function cancel(LeaveRequest $leave_request)
    {

        $leave_request->update(['status' => 'Cancelled']);

        return ApiResponseResource::success(
            new LeaveRequestResource($leave_request),
            'Leave request has been cancelled.'
        );
    }
}
