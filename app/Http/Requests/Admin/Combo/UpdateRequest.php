<?php

namespace App\Http\Requests\Admin\Combo;

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
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'vat' => 'nullable|min:0',
            'code' => 'required|string|max:50',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'time_slots' => 'nullable|array',
            'time_slots.*.start' => 'nullable|string|date_format:H:i',
            'time_slots.*.end' => 'nullable|string|date_format:H:i|after:time_slots.*.start',
            'days_of_week' => 'nullable|array',
            'days_of_week.*' => 'nullable|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'status' => 'required|integer|in:0,1',
            'shops' => 'nullable|array',
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer|exists:m_product,id',
            'products.*.price_combo' => 'required|integer|min:0',
            'products.*.quanlity' => 'required|integer|min:1',
            'products.*.options' => 'nullable|array',
            'products.*.options.*.option_id' => 'nullable|integer|exists:m_option,id',
            'products.*.options.*.value' => 'nullable|string|max:255',
            'products.*.group_toppings' => 'nullable|array',
            'products.*.group_toppings.*.id' => 'nullable|integer',
            'products.*.group_toppings.*.name' => 'nullable|string',
            'products.*.group_toppings.*.toppings' => 'nullable|array',
            'products.*.group_toppings.*.toppings.*.topping_id' => 'nullable|integer|exists:m_product,id',
            'products.*.group_toppings.*.toppings.*.quanlity' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên combo là bắt buộc.',
            'name.string' => 'Tên combo phải là một chuỗi.',
            'name.max' => 'Tên combo không được vượt quá 255 ký tự.',

            'price.required' => 'Giá là bắt buộc.',
            'price.integer' => 'Giá phải là một số nguyên.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',

            'vat.required' => 'VAT là bắt buộc.',
            'vat.integer' => 'VAT phải là một số nguyên.',
            'vat.min' => 'VAT phải lớn hơn hoặc bằng 0.',

            'code.required' => 'Mã là bắt buộc.',
            'code.string' => 'Mã phải là một chuỗi.',
            'code.max' => 'Mã không được vượt quá 50 ký tự.',

            'description.required' => 'Mô tả là bắt buộc.',
            'description.string' => 'Mô tả phải là một chuỗi.',

            'image.string' => 'Hình ảnh phải là một chuỗi.',
            'image.max' => 'Hình ảnh không được vượt quá 255 ký tự.',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',

            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',

            'time_slots.required' => 'Danh sách thời gian là bắt buộc.',
            'time_slots.array' => 'Danh sách thời gian phải là một mảng.',

            'time_slots.*.start.required' => 'Thời gian bắt đầu là bắt buộc.',
            'time_slots.*.start.string' => 'Thời gian bắt đầu phải là một chuỗi.',
            'time_slots.*.start.date_format' => 'Thời gian bắt đầu phải theo định dạng H:i.',

            'time_slots.*.end.required' => 'Thời gian kết thúc là bắt buộc.',
            'time_slots.*.end.string' => 'Thời gian kết thúc phải là một chuỗi.',
            'time_slots.*.end.date_format' => 'Thời gian kết thúc phải theo định dạng H:i.',
            'time_slots.*.end.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',

            'days_of_week.required' => 'Danh sách ngày trong tuần là bắt buộc.',
            'days_of_week.array' => 'Danh sách ngày trong tuần phải là một mảng.',
            'days_of_week.*.in' => 'Ngày trong tuần không hợp lệ.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.integer' => 'Trạng thái phải là một số nguyên.',
            'status.in' => 'Trạng thái không hợp lệ.',

            'shops.array' => 'Danh sách cửa hàng phải là một mảng.',

            'products.required' => 'Danh sách sản phẩm là bắt buộc.',
            'products.array' => 'Danh sách sản phẩm phải là một mảng.',

            'products.*.product_id.required' => 'Mã sản phẩm là bắt buộc.',
            'products.*.product_id.integer' => 'Mã sản phẩm phải là một số nguyên.',
            'products.*.product_id.exists' => 'Mã sản phẩm không tồn tại.',

            'products.*.price_combo.required' => 'Giá combo là bắt buộc.',
            'products.*.price_combo.integer' => 'Giá combo phải là một số nguyên.',
            'products.*.price_combo.min' => 'Giá combo phải lớn hơn hoặc bằng 0.',

            'products.*.quanlity.required' => 'Số lượng là bắt buộc.',
            'products.*.quanlity.integer' => 'Số lượng phải là một số nguyên.',
            'products.*.quanlity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',

            'products.*.options.array' => 'Tùy chọn phải là một mảng.',

            'products.*.options.*.option_id.integer' => 'Mã tùy chọn phải là một số nguyên.',
            'products.*.options.*.option_id.exists' => 'Mã tùy chọn không tồn tại.',

            'products.*.options.*.value.string' => 'Giá trị tùy chọn phải là một chuỗi.',
            'products.*.options.*.value.max' => 'Giá trị tùy chọn không được vượt quá 255 ký tự.',

            'products.*.group_toppings.array' => 'Topping phải là một mảng.',

            'products.*.group_toppings.*.toppings.topping_id.integer' => 'Mã topping phải là một số nguyên.',
            'products.*.group_toppings.*.toppings.topping_id.exists' => 'Mã topping không tồn tại.',

            'products.*.group_toppings.*.toppings.quanlity.integer' => 'Số lượng topping phải là một số nguyên.',
            'products.*.group_toppings.*.toppings.quanlity.min' => 'Số lượng topping phải lớn hơn hoặc bằng 1.',
        ];
    }
}