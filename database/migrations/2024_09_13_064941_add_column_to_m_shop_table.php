<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('m_shop', function (Blueprint $table) {
            $table->string('logo')->nullable();
            $table->string('background')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('provinces')->onDelete('set null'); // Khóa ngoại liên kết đến bảng provinces
            $table->date('license_expiry')->nullable(); // Thời hạn bản quyền
            $table->text('description')->nullable(); // Giới thiệu
            $table->string('bank_name'); // Ngân hàng
            $table->string('bank_account_number'); // Số tài khoản
            $table->string('bank_account_holder'); // Tên tài khoản
            $table->boolean('qr_code_status')->default(false); // Tình trạng mã QR
            $table->boolean('bill_payment_approval_required')->default(false); // Yêu cầu phê duyệt khi thanh toán bill
            $table->boolean('sales_report_approval_required')->default(false); // Yêu cầu phê duyệt khi xem doanh thu
            $table->boolean('custom_item_creation_approval_required')->default(false); // Cho phép tạo món tùy chọn bằng nhập mã PIN hoặc gửi yêu cầu phê duyệt
            $table->boolean('service_fee_approval_required')->default(false); // Cho phép nhập phí dịch vụ bằng nhập mã PIN hoặc gửi yêu cầu phê duyệt
            $table->boolean('order_discount_approval_required')->default(false); // Yêu cầu phê duyệt khi nhập giảm giá
            $table->boolean('order_cancel_approval_required')->default(false); // Yêu cầu phê duyệt khi hủy đơn
            $table->boolean('order_history_approval_required')->default(false); // Cho phép xem lịch sử order bằng nhập mã PIN hoặc gửi yêu cầu phê duyệt
            $table->boolean('table_transfer_approval_required')->default(false); // Cho phép chuyển bàn, tách bill, gộp bill bằng nhập mã PIN hoặc gửi yêu cầu phê duyệt
            $table->string('pin_code'); // Mã PIN bảo mật
            $table->integer('pin_code_length')->default(8); // Độ dài mã PIN
            $table->boolean('auto_change_pin')->default(false); // Tự động thay đổi mã PIN khi sử dụng
            $table->string('voucher_id')->nullable(); // Tên voucher
            $table->integer('pos_alert_time')->nullable(); // Thời gian cảnh báo sau khi mở ca trên máy POS
            $table->time('opening_time')->nullable(); // Giờ mở cửa
            $table->time('closing_time')->nullable(); // Giờ đóng cửa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_shop', function (Blueprint $table) {
            $table->dropColumn([
                'logo',
                'background',
                'phone',
                'email',
                'province_id',
                'license_expiry',
                'description',
                'bank_name',
                'bank_account_number',
                'bank_account_holder',
                'qr_code_status',
                'bill_payment_approval_required',
                'sales_report_approval_required',
                'custom_item_creation_approval_required',
                'service_fee_approval_required',
                'order_discount_approval_required',
                'order_cancel_approval_required',
                'order_history_approval_required',
                'table_transfer_approval_required',
                'pin_code',
                'pin_code_length',
                'auto_change_pin',
                'voucher_id',
                'pos_alert_time',
                'opening_time',
                'closing_time',
            ]);
        });
    }
};
