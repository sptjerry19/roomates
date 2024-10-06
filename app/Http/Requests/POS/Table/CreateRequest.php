<?php

namespace App\Http\Requests\POS\Table;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $user = auth('api')->user();
        return [
            'table_number' => [
                'required',
                'max:255',
                Rule::unique('m_table')->where(function ($query) use ($user) {
                    return $query->where('shop_id', $user->shop_id);
                }),
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute là bắt buộc',
            'max' => ':attribute chỉ có tối đa :max ký tự',
            'unique' => ':attribute đã tồn tại.',
        ];
    }

    public function attributes(): array
    {
        return [
            'table_number' => 'Tên bàn',
        ];
    }
}
