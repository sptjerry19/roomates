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
        Schema::table('source_values', function (Blueprint $table) {
            // Thông tin cơ bản
            $table->string('name')->nullable()->change();                // Nguồn (VD: Shopee Food)
            $table->unsignedBigInteger('shop_id')->nullable();        // Chi nhánh áp dụng (VD: Tất cả chi nhánh)
            $table->decimal('refund_percentage', 5, 2)->nullable(); // Phần trăm hoa hồng trả sản (%)
            $table->string('bill_type')->nullable();             // Kiểu in hóa đơn cho khách hàng
            $table->string('payment_method')->nullable();        // Hình thức thanh toán (VD: Trả sau)
            $table->boolean('require_partner_code')->nullable(); // Yêu cầu nhập mã hóa đơn đối tác (1: Có, 0: Không)
            $table->boolean('revenue_includes_shipping')->nullable(); // Tính phí vận chuyển vào doanh thu (1: Có, 0: Không)

            // Cấu hình giá menu
            $table->decimal('menu_price_increase_percentage', 5, 2)->nullable(); // Tăng giá toàn bộ menu theo %

            // Cấu hình chi phí hỗ trợ marketing
            $table->decimal('marketing_support_percentage', 5, 2)->nullable();   // Chi phí đối tác hỗ trợ marketing (%)
            $table->string('voucher_code')->nullable();               // Mã voucher tạo cho chương trình
            $table->date('marketing_start_date')->nullable();                     // Thời gian áp dụng hỗ trợ marketing (bắt đầu)
            $table->date('marketing_end_date')->nullable();                       // Thời gian áp dụng hỗ trợ marketing (kết thúc)

            // Ngày áp dụng trong chiến dịch
            $table->boolean('apply_on_mon')->default(false);  // Thứ 2
            $table->boolean('apply_on_tue')->default(false);  // Thứ 3
            $table->boolean('apply_on_wed')->default(false);  // Thứ 4
            $table->boolean('apply_on_thu')->default(false);  // Thứ 5
            $table->boolean('apply_on_fri')->default(false);  // Thứ 6
            $table->boolean('apply_on_sat')->default(false);  // Thứ 7
            $table->boolean('apply_on_sun')->default(false);  // Chủ nhật

            // Khung giờ áp dụng
            for ($i = 0; $i <= 23; $i++) {
                $table->boolean("apply_hour_$i")->default(false);
            }

            $table->boolean('status')->default(true);

            $table->foreign('shop_id')->references('id')->on('m_shop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('source_values', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn([
                'shop_id',
                'refund_percentage',
                'bill_type',
                'payment_method',
                'require_partner_code',
                'revenue_includes_shipping',
                'menu_price_increase_percentage',
                'marketing_support_percentage',
                'voucher_code',
                'marketing_start_date',
                'marketing_end_date',
                'apply_on_mon',
                'apply_on_tue',
                'apply_on_wed',
                'apply_on_thu',
                'apply_on_fri',
                'apply_on_sat',
                'apply_on_sun',
                'status'
            ]);

            // Xóa từng cột apply_hour từ 0 đến 23
            for ($i = 0; $i <= 23; $i++) {
                $table->dropColumn("apply_hour_$i");
            }
        });
    }
};
