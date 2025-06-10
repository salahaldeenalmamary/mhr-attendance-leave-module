<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('department') ? $this->route('department')->id : null;
        return [
            'name' => 'required|string|max:255|unique:departments,name,' . $departmentId,
            'description' => 'nullable|string|max:1000',
        ];
    }
}
