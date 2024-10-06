<?php

namespace App\Http\Requests\Admin\Option;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'allowed_dishes' => 'required|boolean',
            'allow_min' => 'nullable|integer',
            'allow_max' => 'nullable|integer',
            'products' => 'nullable|array',
            'options' => 'nullable|array',
            'options.*.id' => 'nullable|integer',
            'options.*.name' => 'nullable|string',
            'options.*.price' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc',
            'string' => ':attribute phải là chuỗi ký tự',
            'max' => ':attribute chỉ có tối đa :max ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên option',
        ];
    }
}
