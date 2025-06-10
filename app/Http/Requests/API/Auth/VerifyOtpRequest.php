<?php

namespace App\Http\Requests\API\Auth;

use \App\Http\Requests\API\ApiRequest;

class VerifyOtpRequest extends ApiRequest
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
        ];
    }


    public function messages(): array
    {
        return [
            'email.exists' => 'No account was found with this email address.',
            'otp.required' => 'The OTP is required.',
            'otp.min' => 'The OTP must be 6 digits.',
            'otp.max' => 'The OTP must be 6 digits.',
        ];
    }
}
