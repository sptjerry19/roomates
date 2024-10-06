<?php

namespace App\Http\Requests\Admin\Merchandise;

use Illuminate\Foundation\Http\FormRequest;

class MerchandiseRequest extends FormRequest
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
            'image' => "nullable|string",
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Raw_materials,Finished_goods',
            'unit_id' => 'required_without:unit|integer|exists:units,id',
            'unit' => 'required_without:unit_id|array',
            'unit.name' => 'required|string|max:255',
            'unit.quantity' => 'required|integer|min:1',
            'unit.mass_type' => 'required|string|max:10',
            'commodity_id' => 'nullable|integer|exists:commodity_groups,id',
            'unit_price' => 'nullable|numeric|min:0',
            'storage' => 'required|array|min:1',
            'storage.*.storage_id' => 'required|integer|exists:m_shop,id',
            'storage.*.quantity' => 'required|integer|min:0',
            'storage.*.total_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'tracking_status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên hàng hóa là bắt buộc.',
            'code.required' => 'Mã hàng hóa là bắt buộc.',
            'code.unique' => 'Mã hàng hóa đã tồn tại.',
            'type.required' => 'Loại hàng hóa là bắt buộc.',
            'type.in' => 'Loại hàng hóa không hợp lệ.',
            'unit_id.required_without' => 'Đơn vị là bắt buộc.',
            'unit_id.integer' => 'Đơn vị là số nguyên.',
            'unit_id.exists' => 'Đơn vị không tồn tại.',
            'commodity_id.integer' => 'Mã hàng hóa phải là số nguyên.',
            'commodity_id.exists' => 'Mã hàng hóa không tồn tại.',
            'unit_price.numeric' => 'Đơn giá phải là số.',
            'unit_price.min' => 'Đơn giá phải lớn hơn hoặc bằng 0.',
            'storage.required' => 'Kho là bắt buộc.',
            'storage.array' => 'Dữ liệu kho phải là mảng.',
            'storage.*.storage_id.required' => 'ID kho là bắt buộc.',
            'storage.*.storage_id.exists' => 'ID kho không tồn tại.',
            'storage.*.quantity.required' => 'Số lượng là bắt buộc.',
            'storage.*.quantity.integer' => 'Số lượng phải là số nguyên.',
            'storage.*.quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'storage.*.total_price.required' => 'Tổng giá là bắt buộc.',
            'storage.*.total_price.numeric' => 'Tổng giá phải là số.',
            'storage.*.total_price.min' => 'Tổng giá phải lớn hơn hoặc bằng 0.',
            'description.string' => 'Mô tả phải là chuỗi.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
            'tracking_status.required' => 'Trạng thái theo dõi là bắt buộc.',
            'tracking_status.boolean' => 'Trạng thái theo dõi phải là kiểu boolean (0 hoặc 1).',

            'unit.name.required' => 'Tên không được để trống.',
            'unit.name.string' => 'Tên phải là chuỗi ký tự.',
            'unit.name.max' => 'Tên không được vượt quá 255 ký tự.',
            'unit.quantity.required' => 'Số lượng không được để trống.',
            'unit.quantity.integer' => 'Số lượng phải là một số nguyên.',
            'unit.quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'unit.mass_type.required' => 'Loại khối lượng không được để trống.',
            'unit.mass_type.string' => 'Loại khối lượng phải là chuỗi ký tự.',
            'unit.mass_type.max' => 'Loại khối lượng không được vượt quá 10 ký tự.',
            'unit.mass_type.in' => 'Giá trị của trường mass_type phải là một trong các giá trị: gram, kg, ml, lit.',
        ];
    }
}
