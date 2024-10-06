<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class CostProductRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:m_product,id',
            'option' => 'required|string|in:S,M,L,XL,XXL,XXXL',
            'merchandises' => 'required|array|min:1',
            'merchandises.*.merchandise_id' => 'required|integer|exists:merchandises,id',
            'merchandises.*.quantity' => 'required|integer|min:1',
            'merchandises.*.expense' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'ID sản phẩm là bắt buộc.',
            'product_id.integer' => 'ID sản phẩm phải là một số nguyên.',
            'product_id.exists' => 'ID sản phẩm không tồn tại trong cơ sở dữ liệu.',

            'option.required' => 'Tùy chọn là bắt buộc.',
            'option.string' => 'Tùy chọn phải là một chuỗi.',
            'option.in' => 'Tùy chọn phải là: S, M, L, XL, XXL, XXXL.',

            'merchandises.required' => 'Danh sách hàng hóa là bắt buộc.',
            'merchandises.array' => 'Danh sách hàng hóa phải là một mảng.',
            'merchandises.min' => 'Danh sách hàng hóa phải có ít nhất 1 mục.',

            'merchandises.*.merchandise_id.required' => 'ID hàng hóa là bắt buộc.',
            'merchandises.*.merchandise_id.integer' => 'ID hàng hóa phải là số nguyên.',
            'merchandises.*.merchandise_id.exists' => 'ID hàng hóa không tồn tại trong cơ sở dữ liệu.',

            'merchandises.*.quantity.required' => 'Số lượng là bắt buộc.',
            'merchandises.*.quantity.integer' => 'Số lượng phải là số nguyên.',
            'merchandises.*.quantity.min' => 'Số lượng phải lớn hơn 0.',

            'merchandises.*.expense.required' => 'Chi phí là bắt buộc.',
            'merchandises.*.expense.numeric' => 'Chi phí phải là một số.',
            'merchandises.*.expense.min' => 'Chi phí phải lớn hơn hoặc bằng 0.',
        ];
    }
}
