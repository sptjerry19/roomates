<?php

namespace App\Http\Requests\POS\Order;

use Illuminate\Foundation\Http\FormRequest;

class ChangeTableRequest extends FormRequest
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
            'area_id' => 'required|numeric',
            'table_id' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc.',
            'numeric' => ':attribute phải là số.',
        ];
    }

    public function attributes(): array
    {
        return [
            'area_id' => 'Khu vực',
            'table_id' => 'Bàn',
        ];
    }
}
