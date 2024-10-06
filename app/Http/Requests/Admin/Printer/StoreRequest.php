<?php

namespace App\Http\Requests\Admin\Printer;

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
            'device_id' => 'required|integer|min:0',
            'product_id' => 'required|integer|min:0',
            'vendor_id' => 'required|integer|min:0',
            'connection_type' => 'nullable|in:USB,LAN,Sunmi,KDS',
            'printer_type' => 'nullable|string|max:255',
            'copies' => 'nullable|integer|min:1',
            'paper_size' => 'nullable|integer|min:1',
            'slip_printing' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'device_id.required' => 'Device ID là bắt buộc.',
            'device_id.integer' => 'Device ID phải là một số nguyên.',
            'device_id.min' => 'Device ID phải là số nguyên không âm.',
            'product_id.required' => 'Product ID là bắt buộc.',
            'product_id.integer' => 'Product ID phải là một số nguyên.',
            'product_id.min' => 'Product ID phải là số nguyên không âm.',
            'vendor_id.required' => 'Vendor ID là bắt buộc.',
            'vendor_id.integer' => 'Vendor ID phải là một số nguyên.',
            'vendor_id.min' => 'Vendor ID phải là số nguyên không âm.',
            'connection_type.in' => 'Connection Type phải là một trong những giá trị: USB, LAN, Sunmi, KDS.',
            'printer_type.string' => 'Printer Type phải là chuỗi.',
            'printer_type.max' => 'Printer Type không được vượt quá 255 ký tự.',
            'copies.integer' => 'Số bản sao phải là một số nguyên.',
            'copies.min' => 'Số bản sao phải lớn hơn hoặc bằng 1.',
            'paper_size.integer' => 'Kích thước giấy phải là một số nguyên.',
            'slip_printing.boolean' => 'Slip Printing phải là giá trị boolean.',
        ];
    }
}
