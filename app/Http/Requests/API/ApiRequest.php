<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Resources\ApiResponseResource;

/**
 * Base request class for all API form requests.
 */
abstract class ApiRequest extends FormRequest
{
   
    abstract public function rules();

   
   

   
    protected function failedValidation(Validator $validator)
    {
        $response = ApiResponseResource::error(
            $validator->errors(), 
            'The given data was invalid. Please check the errors.'
        )->response()->setStatusCode(422);

        throw new HttpResponseException($response);
    }

    
}