<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\ApiResponseResource;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\ForgotPasswordRequest;
use App\Http\Requests\API\Auth\VerifyOtpRequest;
use App\Http\Requests\API\Auth\ResetPasswordRequest;


class AuthController extends Controller
{
   
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return ApiResponseResource::success($user, 'User registered successfully.');
    }

   
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return ApiResponseResource::error(null, 'Invalid credentials.')
                ->response()->setStatusCode(401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token',)->plainTextToken;

        $data = [
            'user' => $user,
            'access_token' => $token,
        ];

        return ApiResponseResource::success($data, 'Login successful.');
    }

   
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponseResource::success(null, 'Successfully logged out.');
    }

    
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        
   
        $otp = random_int(100000, 999999);
        
       
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

       
        Mail::to($user->email)->send(new SendOtpMail((string)$otp, $user->name));

        return ApiResponseResource::success(null, 'An OTP has been sent to your email address.');
    }

    
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

        if (!$user || now()->isAfter($user->otp_expires_at)) {
            return ApiResponseResource::error(null, 'Invalid or expired OTP.')
                ->response()->setStatusCode(422);
        }
        
        // Optionally, clear the OTP after successful verification if it's a one-time use code for this step
        // $user->update(['otp' => null, 'otp_expires_at' => null]);

        return ApiResponseResource::success(null, 'OTP has been verified successfully.');
    }

   
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

        
        if (!$user || now()->isAfter($user->otp_expires_at)) {
            return ApiResponseResource::error(null, 'Invalid or expired OTP.')
                ->response()->setStatusCode(422);
        }

       
        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

      
        $user->tokens()->delete();

        return ApiResponseResource::success(null, 'Your password has been reset successfully.');
    }
}