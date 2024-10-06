<?php

namespace App\Http\Resources\Admin\Shop;

use App\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'logo' => isset($this->logo) ? Common::responseProductImage($this->logo) : null,
            'background' => isset($this->background) ? Common::responseProductImage($this->background) : null,
            'company' => $this->company ?? null,
            'name' => $this->name,
            'phone' => $this->phone ?? null,
            'email' => $this->email ?? null,
            'address' => $this->adress ?? null, // Sửa lại 'adress' thành 'address' cho đúng chính tả
            'province' => $this->province ?? null, // Thành phố/tỉnh
            'description' => $this->description ?? null, // Giới thiệu
            'bank_name' => $this->bank_name, // Ngân hàng
            'bank_account_number' => $this->bank_account_number, // Số tài khoản
            'bank_account_holder' => $this->bank_account_holder, // Tên tài khoản
            'qr_code_status' => $this->qr_code_status, // Tình trạng mã QR
            'bill_payment_approval_required' => $this->bill_payment_approval_required, // Yêu cầu phê duyệt khi thanh toán bill
            'sales_report_approval_required' => $this->sales_report_approval_required, // Yêu cầu phê duyệt khi xem doanh thu
            'custom_item_creation_approval_required' => $this->custom_item_creation_approval_required, // Cho phép tạo món tùy chọn bằng nhập mã PIN hoặc gửi yêu cầu phê duyệt
            'service_fee_approval_required' => $this->service_fee_approval_required, // Cho phép nhập phí dịch vụ bằng nhập mã PIN hoặc gửi yêu cầu phê duyệt
            'order_discount_approval_required' => $this->order_discount_approval_required, // Yêu cầu phê duyệt khi nhập giảm giá
            'order_cancel_approval_required' => $this->order_cancel_approval_required, // Yêu cầu phê duyệt khi hủy đơn
            'order_history_approval_required' => $this->order_history_approval_required, // Cho phép xem lịch sử order bằng nhập mã PIN hoặc gửi yêu cầu phê duyệt
            'table_transfer_approval_required' => $this->table_transfer_approval_required, // Cho phép chuyển bàn, tách bill, gộp bill bằng nhập mã PIN hoặc gửi yêu cầu phê duyệt
            'pin_code' => $this->pin_code, // Mã PIN bảo mật
            'pin_code_length' => $this->pin_code_length, // Độ dài mã PIN
            'auto_change_pin' => $this->auto_change_pin, // Tự động thay đổi mã PIN khi sử dụng
            'pos_alert_time' => $this->pos_alert_time ?? null, // Thời gian cảnh báo sau khi mở ca trên máy POS
            'opening_time' => $this->opening_time ?? null, // Giờ mở cửa
            'closing_time' => $this->closing_time ?? null, // Giờ đóng cửa
            'status' => $this->status ?? null, // Trạng thái
            'voucher' =>  $this->vouchers ?? null, // Voucher
        ];
    }
}
