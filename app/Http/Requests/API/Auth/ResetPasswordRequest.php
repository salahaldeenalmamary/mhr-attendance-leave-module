<?php

namespace App\Http\Requests\API\Auth;

use \App\Http\Requests\API\ApiRequest;

class ResetPasswordRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'email' => 'required|string|email|exists:users,email',
        'otp' => 'required|string|min:6|max:6',
        'password' => 'required|string|min:8|confirmed',
    ];
    }

     public function messages(): array
    {
        return [
            'otp.required' => 'The OTP is required to reset your password.',
            'email.exists' => 'No account was found with this email .',
            'password.required' => 'A new password is required.',
            'password.min' => 'The new password must be at least 8 characters long.',
            'password.confirmed' => 'The new password confirmation does not match.',
        ];
    }
}
