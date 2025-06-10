<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;


Route::controller(AuthController::class)->prefix('auth')->group(function () {
    
    
    Route::post('/register', 'register')->name('api.register');
    Route::post('/login', 'login')->name('api.login');
    Route::post('/forgot-password', 'forgotPassword')->name('api.forgot-password');
    Route::post('/verify-otp', 'verifyOtp')->name('api.verify-otp');
    Route::post('/reset-password', 'resetPassword')->name('api.reset-password');

    
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::get('/user', 'userProfile')->name('api.user');
    //     Route::post('/logout', 'logout')->name('api.logout');
    // });
});