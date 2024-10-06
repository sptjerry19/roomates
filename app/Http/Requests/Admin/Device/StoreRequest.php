<?php

namespace App\Http\Requests\Admin\Device;

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
            'device_name' => 'required|string|max:255|unique:devices,device_name',
            'device_type' => 'required|string|in:POS,POS MINI,PDA,KDS',
            'shop_id' => 'required|integer|exists:m_shop,id',
        ];
    }

    public function messages(): array
    {
        return [
            'device_name.required' => 'Tên thiết bị là bắt buộc.',
            'device_name.string' => 'Tên thiết bị phải là một chuỗi ký tự.',
            'device_name.max' => 'Tên thiết bị không được vượt quá 255 ký tự.',

            'device_type.required' => 'Loại thiết bị là bắt buộc.',
            'device_type.string' => 'Loại thiết bị phải là một chuỗi ký tự.',
            'device_type.in' => 'Loại thiết bị phải là một trong các giá trị: POS, POS MINI, PDA, KDS.',

            'shop_id.required' => 'Mã cửa hàng là bắt buộc.',
            'shop_id.integer' => 'Mã cửa hàng phải là một số nguyên.',
            'shop_id.exists' => 'Cửa hàng được chọn không tồn tại.',
        ];
    }
}
