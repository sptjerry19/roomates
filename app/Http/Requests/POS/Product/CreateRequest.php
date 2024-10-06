<?php

namespace App\Http\Requests\POS\Product;

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
            'name' => 'required|string|unique:m_product,name','max:255',
            'price' => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
            'product_code' => 'nullable',
            'category_id' => 'required',
            'unit_type' => 'required',
            'unit_name' => 'nullable',
            'vat_fee'=> 'nullable',
            'image' => 'nullable|string',
            'optionIds' => 'nullable',
            'toppingIds' => 'nullable',
            'description' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống',
            'string' => ':attribute phải là chuỗi ký tự',
            'max' => ':attribute chỉ có tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại.',
            'numeric' => ':attribute phải là số',
            'price.gt' => ':attribute phải lớn hơn 0',
            'price.regex' => ':attribute không đúng định dạng'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên món',
            'price' => "Giá món",
            'image' => 'Ảnh',
            'category_id' => 'Nhóm món',
            'unit_type' => 'Đơn vị tính',
        ];
    }
}
