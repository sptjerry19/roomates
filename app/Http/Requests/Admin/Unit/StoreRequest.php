<?php

namespace App\Http\Requests\Admin\Unit;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'quantity' => 'required|integer|min:1',
            'mass_type' => 'required|string|in:gram,kg,ml,lit|max:10',
            'code' => 'required|string|unique:units,code',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'quantity.required' => 'Số lượng không được để trống.',
            'quantity.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'mass_type.required' => 'Loại khối lượng không được để trống.',
            'mass_type.string' => 'Loại khối lượng phải là chuỗi ký tự.',
            'mass_type.max' => 'Loại khối lượng không được vượt quá 10 ký tự.',
            'code.required' => 'Mã không được để trống.',
            'code.string' => 'Mã phải là chuỗi ký tự.',
            'code.unique' => 'Mã này đã tồn tại.',
            'mass_type.in' => 'Giá trị của trường mass_type phải là một trong các giá trị: gram, kg, ml, lit.',
        ];
    }
}
