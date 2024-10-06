<?php

namespace App\Http\Requests\Admin\CardTable;

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
            'quantity' => 'required|integer|min:1',
            'shop_id' => 'required|integer|exists:m_shop,id',
        ];
    }

    public function messages(): array
    {
        return [
            'shop_id.required' => 'Chi nhánh là bắt buộc.',
            'shop_id.integer' => 'Chi nhánh phải là một số nguyên.',
            'shop_id.exists' => 'Chi nhánh không tồn tại.',

            'quanlity.integer' => 'Số lượng phải là một số nguyên.',
            'quanlity.min' => 'Số lượng phải ít nhất là 1.',
        ];
    }
}
