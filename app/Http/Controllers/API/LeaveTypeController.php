<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResponseResource;
use App\Http\Resources\LeaveTypeResource;
use App\Models\LeaveType;
class LeaveTypeController extends Controller
{
    
    public function index()
    {
        return ApiResponseResource::success(
            LeaveTypeResource::collection(LeaveType::all())
        );
    }


}
