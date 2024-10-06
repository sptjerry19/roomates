<?php

namespace App\Http\Requests\POS\UsageType;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name' => 'required|string|unique:m_usage_type,name','max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc',
            'string' => ':attribute phải là chuỗi ký tự',
            'unique' => ':attribute đã tồn tại.',
            'max' => ':attribute chỉ có tối đa :max ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên loại dùng',
        ];
    }
}
