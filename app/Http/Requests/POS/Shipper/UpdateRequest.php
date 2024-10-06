<?php

namespace App\Http\Requests\POS\Shipper;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'required|string','max:255',
            'image' => 'nullable|string',
            'phone'=> [
                'required',
                'max:12',
                Rule::unique('m_shipper', 'phone')->ignore($this->route('id')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
            'string' => ':attribute phải là chuỗi ký tự',
            'max' => ':attribute chỉ có tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên shipper',
            'image' => 'Avatar',
            'phone' => 'Số điện thoại',
        ];
    }
}
