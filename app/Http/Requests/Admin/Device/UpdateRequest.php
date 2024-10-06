<?php

namespace App\Http\Requests\Admin\Device;

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
            'device_name' => 'required|string|max:255',
            'device_type' => 'required|string|in:POS,POS MINI,PDA,KDS',
            'shop_id' => 'required|integer|exists:m_shop,id',
            'machine_type' => 'required|string|in:Server,Workstation', // Thay đổi 'AnotherType' nếu cần
            'configure_KDS_notification' => 'required|string|in:Not_displayed,Notifications_KDS_device,All_notifications',
            'hide_categories' => 'array',
            'hide_categories.*' => 'integer|exists:m_category,id', // Giả sử có bảng `categories` với trường `id`
            'setting_area' => 'required|array',
            'setting_area.id' => 'required|integer|exists:setting_areas,id', // Giả sử có bảng `areas` với trường `id`
            'setting_area.columns' => 'required|integer|min:1',
            'setting_area.area_management' => 'required|boolean',
            'setting_area.activate_screen_2' => 'required|boolean',
            'setting_area.display_button_POS' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'device_name.required' => 'Tên thiết bị là bắt buộc.',
            'device_name.string' => 'Tên thiết bị phải là một chuỗi ký tự.',
            'device_name.max' => 'Tên thiết bị không được vượt quá 255 ký tự.',
            'device_type.required' => 'Loại thiết bị là bắt buộc.',
            'device_type.string' => 'Loại thiết bị phải là một chuỗi ký tự.',
            'device_type.in' => 'Loại thiết bị phải là một trong những giá trị: POS, POS MINI, PDA, KDS.',
            'shop_id.required' => 'ID cửa hàng là bắt buộc.',
            'shop_id.integer' => 'ID cửa hàng phải là một số nguyên.',
            'shop_id.exists' => 'ID cửa hàng không tồn tại trong bảng cửa hàng.',
            'machine_type.required' => 'Loại máy là bắt buộc.',
            'machine_type.string' => 'Loại máy phải là một chuỗi ký tự.',
            'machine_type.in' => 'Loại máy phải là một trong những giá trị: Server, Workstation.',
            'configure_KDS_notification.required' => 'Cấu hình thông báo KDS là bắt buộc.',
            'configure_KDS_notification.string' => 'Cấu hình thông báo KDS phải là một chuỗi ký tự.',
            'configure_KDS_notification.in' => 'Cấu hình thông báo KDS phải là một trong những giá trị: Not_displayed, Displayed.',
            'hide_categories.array' => 'Danh sách ẩn danh mục phải là một mảng.',
            'hide_categories.*.integer' => 'Mỗi ID danh mục trong danh sách ẩn phải là một số nguyên.',
            'hide_categories.*.exists' => 'Mỗi ID danh mục trong danh sách ẩn phải tồn tại trong bảng danh mục.',
            'setting_area.required' => 'Khu vực cài đặt là bắt buộc.',
            'setting_area.array' => 'Khu vực cài đặt phải là một mảng.',
            'setting_area.id.required' => 'ID khu vực cài đặt là bắt buộc.',
            'setting_area.id.integer' => 'ID khu vực cài đặt phải là một số nguyên.',
            'setting_area.id.exists' => 'ID khu vực cài đặt không tồn tại trong bảng khu vực.',
            'setting_area.columns.required' => 'Số cột là bắt buộc.',
            'setting_area.columns.integer' => 'Số cột phải là một số nguyên.',
            'setting_area.columns.min' => 'Số cột phải ít nhất là 1.',
            'setting_area.area_management.required' => 'Quản lý khu vực là bắt buộc.',
            'setting_area.area_management.boolean' => 'Quản lý khu vực phải là đúng hoặc sai.',
            'setting_area.activate_screen_2.required' => 'Kích hoạt màn hình 2 là bắt buộc.',
            'setting_area.activate_screen_2.boolean' => 'Kích hoạt màn hình 2 phải là đúng hoặc sai.',
            'setting_area.display_button_POS.required' => 'Hiển thị nút POS là bắt buộc.',
            'setting_area.display_button_POS.boolean' => 'Hiển thị nút POS phải là đúng hoặc sai.',
        ];
    }
}
