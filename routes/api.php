<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LeaveRequestController;
use App\Http\Controllers\API\LeaveTypeController;
use App\Http\Controllers\API\AttendanceController;

Route::controller(AuthController::class)->prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/forgot-password', 'forgotPassword')->name('forgot-password');
    Route::post('/verify-otp', 'verifyOtp')->name('verify-otp');
    Route::post('/reset-password', 'resetPassword')->name('reset-password');
});

Route::middleware('auth:sanctum')->group(function () {



    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');


    Route::prefix('leave')->name('leave.')->group(function () {


        Route::get('/types', [LeaveTypeController::class, 'index'])->name('types.index');


        Route::get('/balances', [LeaveRequestController::class, 'getBalances'])->name('balances');


        Route::prefix('requests')->name('requests.')->group(function () {

            // GET /api/leave/requests
            Route::get('/', [LeaveRequestController::class, 'index'])->name('index');


            Route::post('/', [LeaveRequestController::class, 'store'])->name('store');


            Route::get('/{leave_request}', [LeaveRequestController::class, 'show'])
                ->name('show');

            // middleware('can:view,leave_request'); 


            Route::put('/cancel/{leave_request}', [LeaveRequestController::class, 'cancel'])
                ->name('cancel')
            ;
            //  ->middleware('can:cancel,leave_request')
        });
    });


    Route::prefix('attendance')->name('attendance.')->group(function () {


        Route::post('/clock-in', [AttendanceController::class, 'clockIn'])->name('clock-in');


        Route::post('/clock-out', [AttendanceController::class, 'clockOut'])->name('clock-out');


        Route::get('/history', [AttendanceController::class, 'history'])->name('history');
    });
});
