<?php

namespace App\Http\Requests\Admin\CardTable;

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
            'card_tables' => 'required|array|min:1',
            'card_tables.*.id' => 'nullable|integer|exists:m_card_table,id',
            'card_tables.*.name' => 'required|string|max:255',
            'card_tables.*.status' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'card_tables.required' => 'Danh sách thẻ là bắt buộc.',
            'card_tables.array' => 'Danh sách thẻ phải là một mảng.',
            'card_tables.*.id.integer' => 'ID của mỗi thẻ phải là một số nguyên.',
            'card_tables.*.name.required' => 'Mỗi thẻ phải có một tên.',
        ];
    }
}
