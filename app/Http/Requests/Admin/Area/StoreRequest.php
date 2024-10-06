<?php

namespace App\Http\Requests\Admin\Area;

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
            "name" => "required|string|max:255",
            "order_number" => 'nullable|integer',
            "shop_id" => "required|integer|exists:m_shop,id",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'order_number.integer' => 'Số thứ tự phải là một số nguyên.',

            'shop_id.required' => 'Chi nhánh là bắt buộc.',
            'shop_id.integer' => 'Chi nhánh phải là một số nguyên.',
            'shop_id.exists' => 'Chi nhánh không tồn tại.',
        ];
    }
}
