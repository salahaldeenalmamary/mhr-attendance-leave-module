<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
    // app/Http/Requests/StoreProductRequest.php
public function rules(): array
{
    return [
        'name' => ['required', 'string', 'max:255', 'unique:products,name'], // 'name' IS required
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        'description' => ['nullable', 'string'],
        'price' => ['required', 'numeric', 'min:0.01'], // 'price' IS required
        'category_id' => ['nullable', 'exists:categories,id']
    ];
}
}
