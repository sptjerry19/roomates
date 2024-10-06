<?php

namespace App\Http\Requests\Admin\Area;

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
            "name" => "required|string|max:255",
            "order_number" => 'nullable|integer',
            "shop_id" => "required|integer|exists:m_shop,id",
            'tables' => 'nullable|array',
            'tables.*.id' => 'nullable|integer',
            'tables.*.table_number' => 'nullable|string',
            'tables.*.status' => 'nullable|string',
            'tables.*.table_type' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'order_number.integer' => 'Số đơn hàng phải là một số nguyên.',

            'shop_id.required' => 'Trường shop_id là bắt buộc.',
            'shop_id.integer' => 'shop_id phải là một số nguyên.',
            'shop_id.exists' => 'shop_id không tồn tại trong bảng m_shop.',

            'tables.array' => 'Trường tables phải là một mảng.',

            'tables.*.id.integer' => 'Mỗi bảng trong tables phải có một id hợp lệ và là một số nguyên.',
            'tables.*.table_number.string' => 'Mỗi bảng trong tables phải có một số bàn hợp lệ và là một chuỗi ký tự.',
            'tables.*.status.string' => 'Trạng thái của mỗi bảng trong tables phải là một chuỗi ký tự.',
            'tables.*.table_type.string' => 'Loại bảng của mỗi bảng trong tables phải là một chuỗi ký tự.',
        ];
    }
}