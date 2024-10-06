<?php

namespace App\Http\Requests\POS\Option;

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
            'name' => 'required|string|max:255' . $this->id,
            'values' => 'nullable',
            'price' => 'nullable',
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
