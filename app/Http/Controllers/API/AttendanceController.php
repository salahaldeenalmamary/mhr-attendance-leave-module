<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceRecordResource;
use App\Http\Resources\ApiResponseResource;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{

    public function clockIn(Request $request)
    {
        $employee = auth()->user();
        $today = Carbon::today();


        $existingRecord = $employee->attendances()->where('attendance_date', $today->toDateString())->first();

        if ($existingRecord && $existingRecord->clock_in_time) {
            return ApiResponseResource::error(
                new AttendanceRecordResource($existingRecord),
                'You have already clocked in today.'
            )->response()->setStatusCode(409);
        }


        $attendanceRecord = $employee->attendances()->updateOrCreate(
            ['attendance_date' => $today->toDateString()],
            [
                'clock_in_time' => now(),
                'status' => 'Present',
                'notes' => $request->input('notes'),
                'source' => 'Manual Entry',
            ]
        );

        return ApiResponseResource::success(
            new AttendanceRecordResource($attendanceRecord),
            'Clocked in successfully.'
        )->response()->setStatusCode(201);
    }


    public function clockOut()
    {
        $employee = auth()->user();
        $today = Carbon::today();


        $attendanceRecord = $employee->attendances()->where('attendance_date', $today->toDateString())->first();


        if (!$attendanceRecord || !$attendanceRecord->clock_in_time) {
            return ApiResponseResource::error(null, 'You have not clocked in today.')
                ->response()->setStatusCode(404);
        }


        if ($attendanceRecord->clock_out_time) {
            return ApiResponseResource::error(
                new AttendanceRecordResource($attendanceRecord),
                'You have already clocked out today.'
            )->response()->setStatusCode(409);
        }


        $attendanceRecord->update([
            'clock_out_time' => now()
        ]);

        return ApiResponseResource::success(
            new AttendanceRecordResource($attendanceRecord),
            'Clocked out successfully.'
        );
    }


    public function history(Request $request)
    {
        $query = auth()->user()->attendances()->latest('attendance_date');

        $query->when($request->query('from_date'), function ($q, $date) {
            $q->where('attendance_date', '>=', $date);
        });
        $query->when($request->query('to_date'), function ($q, $date) {
            $q->where('attendance_date', '<=', $date);
        });

        $attendanceHistory = $query->paginate(30);

        return ApiResponseResource::success(
            AttendanceRecordResource::collection($attendanceHistory)
        );
    }
}
