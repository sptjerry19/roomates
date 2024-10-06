<?php

namespace App\Http\Requests\cms\Users;

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
            'phone' => 'nullable|regex:/^0[0-9]{9}$/',
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|string',
            'sex' => 'nullable|boolean',
            'address' => 'nullable|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'status' => 'nullable|boolean',
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
            'required' => 'trường :attribute là bắt buộc',
            'string' => 'trường :attribute phải là chuỗi ký tự',
            'max' => 'trường :attribute chỉ có tối đa :max ký tự',
            'boolean' => 'trường :attribute phải là true hoặc false',
            'regex' => 'trường :attribute không đúng định dạng cho phép',
        ];
    }
}
