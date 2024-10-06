<?php

namespace App\Http\Requests\Admin\Table;

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
            'shop_id' => 'required|integer|exists:m_shop,id',
            'area_id' => 'required|integer||exists:m_area,id',
            'quanlity' => 'nullable|integer|min:1',
            'table_type' => 'required|string',
            'stt' => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'area_id.required' => 'Trường khu vực là bắt buộc.',
            'area_id.integer' => 'Khu vực phải là một số nguyên.',
            'area_id.exists' => 'Khu vực được chọn không tồn tại.',

            'shop_id.required' => 'Chi nhánh là bắt buộc.',
            'shop_id.integer' => 'Chi nhánh phải là một số nguyên.',
            'shop_id.exists' => 'Chi nhánh không tồn tại.',

            'name.required' => 'Tên bàn là bắt buộc.',
            'name.string' => 'Tên bàn phải là một chuỗi ký tự.',
            'name.max' => 'Tên bàn không được vượt quá 255 ký tự.',

            'quanlity.integer' => 'Số lượng phải là một số nguyên.',
            'quanlity.min' => 'Số lượng phải ít nhất là 1.',

            'table_type.required' => 'Loại bàn là bắt buộc.',
            'table_type.string' => 'Loại bàn phải là một chuỗi ký tự.',

            'stt.integer' => 'Số thứ tự là kiểu số nguyên.',
        ];
    }
}
