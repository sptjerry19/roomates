<?php

namespace App\Http\Requests\Admin\Shop;

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
            'name' =>  'required|string',
            'address' =>  'required|string',
            'logo' => 'nullable|string', // Logo của cửa hàng (tùy chọn)
            'background' => 'nullable|string', // Hình nền của cửa hàng (tùy chọn)
            'phone' => 'required|string|max:15', // Số điện thoại (tùy chọn)
            'email' => 'nullable|email|max:255', // Email (tùy chọn)
            'province_id' => 'nullable|exists:provinces,id', // ID tỉnh/thành phố (khóa ngoại)
            'license_expiry' => 'nullable|date', // Thời hạn bản quyền (tùy chọn)
            'description' => 'nullable|string', // Giới thiệu cửa hàng (tùy chọn)
            'bank_name' => 'required|string|max:255', // Tên ngân hàng (bắt buộc)
            'bank_account_number' => 'required|string|max:50', // Số tài khoản ngân hàng (bắt buộc)
            'bank_account_holder' => 'required|string|max:255', // Tên chủ tài khoản ngân hàng (bắt buộc)
            'qr_code_status' => 'nullable|string', // Tình trạng mã QR (mặc định là false)
            'bill_payment_approval_required' => 'boolean', // Yêu cầu phê duyệt khi thanh toán hóa đơn (mặc định là false)
            'sales_report_approval_required' => 'boolean', // Yêu cầu phê duyệt khi xem báo cáo doanh thu (mặc định là false)
            'custom_item_creation_approval_required' => 'boolean', // Yêu cầu phê duyệt khi tạo món tùy chọn (mặc định là false)
            'service_fee_approval_required' => 'boolean', // Yêu cầu phê duyệt khi nhập phí dịch vụ (mặc định là false)
            'order_discount_approval_required' => 'boolean', // Yêu cầu phê duyệt khi nhập giảm giá (mặc định là false)
            'order_cancel_approval_required' => 'boolean', // Yêu cầu phê duyệt khi hủy đơn hàng (mặc định là false)
            'order_history_approval_required' => 'boolean', // Yêu cầu phê duyệt khi xem lịch sử đơn hàng (mặc định là false)
            'table_transfer_approval_required' => 'boolean', // Yêu cầu phê duyệt khi chuyển bàn, tách/gộp hóa đơn (mặc định là false)
            'pin_code' => 'required|string|max:255', // Mã PIN bảo mật (bắt buộc)
            'pin_code_length' => 'required|integer|min:4|max:12', // Độ dài của mã PIN (bắt buộc, tối thiểu 4, tối đa 12 ký tự)
            'auto_change_pin' => 'nullable|string|in:none,once,1min,2min', // Tự động thay đổi mã PIN (mặc định là false)
            'pos_alert_time' => 'nullable|integer|min:1', // Thời gian cảnh báo sau khi mở ca trên máy POS (tùy chọn)
            'opening_time' => 'nullable|date_format:H:i', // Giờ mở cửa (tùy chọn)
            'closing_time' => 'nullable|date_format:H:i', // Giờ đóng cửa (tùy chọn)

            'vouchers' => 'nullable|array',
            'vouchers.*.id' => 'nullable|integer',
            'vouchers.*.name' => 'nullable|string',
            'vouchers.*.total_price' => 'nullable|integer',
            'vouchers.*.discount' => 'nullable',
        ];
    }

    /**
     * Custom error messages for validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'province_id.exists' => 'Tỉnh/thành phố không hợp lệ.',
            'license_expiry.date' => 'Ngày hết hạn bản quyền không hợp lệ.',
            'bank_name.required' => 'Tên ngân hàng là bắt buộc.',
            'bank_account_number.required' => 'Số tài khoản ngân hàng là bắt buộc.',
            'bank_account_holder.required' => 'Tên chủ tài khoản ngân hàng là bắt buộc.',
            'pin_code.required' => 'Mã PIN là bắt buộc.',
            'name.required' => 'Tên chi nhánh là bắt buộc.',
            'address.required' => 'Địa chỉ chi nhánh là bắt buộc.',
            'pin_code_length.min' => 'Độ dài mã PIN tối thiểu là 4 ký tự.',
            'pin_code_length.max' => 'Độ dài mã PIN tối đa là 12 ký tự.',
            'voucher_id.max' => 'Tên voucher không được vượt quá 255 ký tự.',
            'pos_alert_time.integer' => 'Thời gian cảnh báo phải là một số nguyên hợp lệ.',
            'opening_time.date_format' => 'Giờ mở cửa không hợp lệ.',
            'closing_time.date_format' => 'Giờ đóng cửa không hợp lệ.',
            'auto_change_pin.in' => 'Tự động thay đổi mã pin phải là: none, once, 1min, 2min '
        ];
    }
}
