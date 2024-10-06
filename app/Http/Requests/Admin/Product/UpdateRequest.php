<?php

namespace App\Http\Requests\Admin\Product;

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
            'code' => 'required|string|max:20',
            'category_id' => 'nullable|exists:m_category,id',
            'unit_type' => 'required|string',
            'shop_id' => 'nullable|array|exists:m_shop,id',
            'image' => 'nullable|string',
            'price' => 'required|numeric',
            'vat_fee' => 'nullable',
            'description' => 'nullable|string',
            'sources' => 'nullable|array',
            'sources.*.id' => 'required|integer|exists:m_source,id',
            'sources.*.price' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'code.required' => 'Mã là bắt buộc.',
            'code.string' => 'Mã phải là một chuỗi ký tự.',
            'code.max' => 'Mã không được vượt quá 20 ký tự.',

            'category_id.exists' => 'ID danh mục không tồn tại.',

            'unit_type.required' => 'Loại đơn vị là bắt buộc.',

            'shop_id.array' => 'Shop ID phải là một mảng.',
            'shop_id.exists' => 'Shop ID không tồn tại.',

            'image.string' => 'Đường dẫn hình ảnh phải là một chuỗi ký tự.',

            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là một số.',

            // 'vat_fee.integer' => 'Phí VAT phải là một số nguyên.',

            'description.string' => 'Mô tả phải là một chuỗi ký tự.',

            'source_id.array' => 'Source ID phải là một mảng.',
            'source_id.exists' => 'Source ID không tồn tại.',

            'sources.array' => 'Source ID phải là một mảng.',
            'sources.*.id.exists' => 'Source ID không tồn tại.',
        ];
    }
}
