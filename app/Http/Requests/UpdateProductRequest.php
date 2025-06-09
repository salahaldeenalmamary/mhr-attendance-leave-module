<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
   
    public function authorize(): bool
    {
 
        $product = $this->route('product');


        return $this->user()->can('update', $product);
    }

   
    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'name' => ['required', 'string', 'max:255', 'unique:products,name,' . $productId],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'category_id' => ['nullable', 'exists:categories,id']
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'The product name cannot be empty.',
            'name.unique' => 'Another product with this name already exists.',
            'price.min' => 'The price must be positive.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('name')) {
            $this->merge([
                'name' => strip_tags($this->name),
            ]);
        }
        if ($this->has('description')) {
            $this->merge([
                'description' => strip_tags($this->description),
            ]);
        }
    }
}
