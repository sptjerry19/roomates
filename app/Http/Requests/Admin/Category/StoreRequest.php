<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => [
                'required',
                'string',
                'max:255',
                // Rule::unique('m_category')->where(function ($query) {
                //     return $query->where('company_id', auth()->user()->company_id);
                // })
            ],
            'code' => 'required|string|max:16', // Corrected from 'requiered' to 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên nhóm món là bắt buộc.',
            'name.string' => 'Tên nhóm món phải là một chuỗi ký tự.',
            'name.max' => 'Tên nhóm món không được vượt quá :max ký tự.',
            'name.unique' => 'Tên nhóm món đã tồn tại trong công ty này.', // Thông báo cho quy tắc unique

            'code.required' => 'Mã nhóm món là bắt buộc.',
            'code.string' => 'Mã nhóm món phải là một chuỗi ký tự.',
            'code.max' => 'Mã nhóm món không được vượt quá :max ký tự.',
        ];
    }
}
