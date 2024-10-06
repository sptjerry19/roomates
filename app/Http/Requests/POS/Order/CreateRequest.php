<?php

namespace App\Http\Requests\POS\Order;

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
            'total_price' => 'required|numeric',
            'usage_type_id' => 'required|numeric',
            'customer_id' => 'nullable',
            'name_customer' => 'nullable|string|max:255',
            'phone_customer' => 'nullable|string','max:12',
            'shipper_id'=> 'nullable',
            'note'=> 'nullable',
            'address' => 'nullable',
            'area_id'=> 'nullable',
            'table_id'=> 'nullable',
            'card_table_id' => 'nullable',
            'products'=> 'nullable',
            'pay_by_id' => 'nullable',
            'options' => 'nullable',
            'toppings' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'max' => ':attribute chỉ có tối đa :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'numeric' => ':attribute phải là số.',
        ];
    }

    public function attributes(): array
    {
        return [
            'usage_type_id' => 'Loại sử dụng',
            'total_price' => 'Tổng tiền',
        ];
    }
}
