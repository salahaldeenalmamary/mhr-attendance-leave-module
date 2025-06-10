<?php

namespace App\Http\Requests\API\Auth;

use \App\Http\Requests\API\ApiRequest;

class LoginRequest extends ApiRequest
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
        'email' => 'required|string|email',
        'password' => 'required|string',
    ];
    }

     public function messages(): array
    {
        return [
           
            'email.required' => 'The email address is required.',

           
            'email.email' => 'Please provide a valid email address.',

          
            'password.required' => 'The password is required to log in.',
        ];
    }
}
