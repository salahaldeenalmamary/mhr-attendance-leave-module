<?php

namespace App\Http\Requests\API\Auth;

use \App\Http\Requests\API\ApiRequest;

class ForgotPasswordRequest extends ApiRequest
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
      return ['email' => 'required|string|email|exists:users,email'];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Please enter the email address for your account.',
            'email.exists' => 'No account was found with this email address.',
        ];
    }
}
