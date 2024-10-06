<?php

namespace App\Http\Requests\Admin\Promotion;

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
            'name' => 'required|string|max:255',
            'discount' => 'required|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'time_slots' => 'nullable|array',
            'time_slots.*.start_time' => 'nullable|date_format:H:i',
            'time_slots.*.end_time' => 'nullable|date_format:H:i|after:time_slots.*.start_time',
            'days_of_week' => 'nullable|array',
            'days_of_week.*' => 'nullable|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',

            'products' => 'required|array',
            'products.*' => 'integer|distinct',

            'shops' => 'required|array',
            'shops.*' => 'integer|distinct',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên chương trình khuyến mãi là bắt buộc.',
            'name.string' => 'Tên chương trình khuyến mãi phải là chuỗi ký tự.',
            'name.max' => 'Tên chương trình khuyến mãi không được vượt quá 255 ký tự.',

            'discount.required' => 'Phần trăm giảm giá là bắt buộc.',
            'discount.integer' => 'Phần trăm giảm giá phải là một số nguyên.',
            'discount.min' => 'Phần trăm giảm giá phải lớn hơn hoặc bằng 0.',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',

            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',

            'time_slots.required' => 'Khung giờ áp dụng là bắt buộc.',
            'time_slots.array' => 'Khung giờ áp dụng phải là một mảng.',

            'time_slots.*.start_time.required' => 'Giờ bắt đầu là bắt buộc.',
            'time_slots.*.start_time.date_format' => 'Giờ bắt đầu không đúng định dạng, định dạng phải là HH:mm.',

            'time_slots.*.end_time.required' => 'Giờ kết thúc là bắt buộc.',
            'time_slots.*.end_time.date_format' => 'Giờ kết thúc không đúng định dạng, định dạng phải là HH:mm.',
            'time_slots.*.end_time.after' => 'Giờ kết thúc phải sau giờ bắt đầu.',

            'days_of_week.array' => 'Các ngày trong tuần phải là một mảng.',
            'days_of_week.*.required' => 'Ngày trong tuần là bắt buộc.',
            'days_of_week.*.string' => 'Ngày trong tuần phải là chuỗi ký tự.',
            'days_of_week.*.in' => 'Ngày trong tuần phải là một trong các giá trị: Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday.',

            'products.required' => 'Danh sách sản phẩm là bắt buộc.',
            'products.*.integer' => 'ID sản phẩm phải là số nguyên.',
            'products.*.distinct' => 'ID sản phẩm không được trùng lặp.',

            'shops.required' => 'Danh sách cửa hàng là bắt buộc.',
            'shops.*.integer' => 'ID cửa hàng phải là số nguyên.',
            'shops.*.distinct' => 'ID cửa hàng không được trùng lặp.',
        ];
    }
}
