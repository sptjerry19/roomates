<?php

namespace App\Http\Requests\POS\Customer;

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
            'name' => 'required|string|max:255',
            'uuid' => 'nullable',
            'sex'=> 'required',
            'phone'=> [
                'required',
                'max:12',
                Rule::unique('m_customer', 'phone')->ignore($this->route('id')),
            ],
            'address'=> 'nullable',
            'date_of_birth'=> 'required|date',
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc',
            'string' => ':attribute phải là chuỗi ký tự',
            'max' => ':attribute chỉ có tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên khách hàng',
            'sex' => 'Giới tính',
            'phone' => 'Số điện thoại',
            'date_of_birth' => 'Ngày sinh',
        ];
    }
}
