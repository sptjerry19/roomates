<?php

namespace App\Http\Resources\Admin\Source;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SourceValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,  // ID của giá trị nguồn
            'company_id' => $this->company_id,  // ID công ty mà giá trị nguồn này thuộc về
            'source' => $this->source ?? null,  // ID nguồn (VD: Shopee, Grab, v.v.)
            'shop' => $this->shop ?? null,  // ID chi nhánh áp dụng (nếu có)
            'name' => $this->name ?? $this->source->name,  // Tên nguồn (VD: Shopee Food)
            'value' => $this->value,  // Giá trị cụ thể (VD: phần trăm chiết khấu)
            'created_at' => $this->created_at,  // Ngày tạo giá trị nguồn
            'updated_at' => $this->updated_at,  // Ngày cập nhật giá trị nguồn
            'refund_percentage' => floatval($this->refund_percentage),  // Phần trăm hoa hồng trả sản (VD: 5.6%)
            'bill_type' => $this->bill_type,  // Loại hóa đơn in cho khách hàng (VD: giấy, điện tử)
            'payment_method' => $this->payment_method,  // Phương thức thanh toán (VD: Trả sau, Trả trước)
            'require_partner_code' => $this->require_partner_code,  // Có yêu cầu nhập mã đối tác hay không (1: Có, 0: Không)
            'revenue_includes_shipping' => $this->revenue_includes_shipping,  // Doanh thu có bao gồm phí vận chuyển không (1: Có, 0: Không)
            'menu_price_increase_percentage' => floatval($this->menu_price_increase_percentage),  // Phần trăm tăng giá menu (VD: 10%)
            'is_vnd' => floatval($this->menu_price_increase_percentage) > 100 ? true : false,
            'marketing_support_percentage' => $this->marketing_support_percentage,  // Phần trăm chi phí hỗ trợ marketing của đối tác
            'voucher_code' => $this->voucher_code,  // Mã voucher áp dụng cho chương trình
            'marketing_start_date' => $this->marketing_start_date,  // Ngày bắt đầu áp dụng hỗ trợ marketing
            'marketing_end_date' => $this->marketing_end_date,  // Ngày kết thúc hỗ trợ marketing
            'apply_on_mon' => $this->apply_on_mon,  // Áp dụng vào thứ 2 (1: Có, 0: Không)
            'apply_on_tue' => $this->apply_on_tue,  // Áp dụng vào thứ 3 (1: Có, 0: Không)
            'apply_on_wed' => $this->apply_on_wed,  // Áp dụng vào thứ 4 (1: Có, 0: Không)
            'apply_on_thu' => $this->apply_on_thu,  // Áp dụng vào thứ 5 (1: Có, 0: Không)
            'apply_on_fri' => $this->apply_on_fri,  // Áp dụng vào thứ 6 (1: Có, 0: Không)
            'apply_on_sat' => $this->apply_on_sat,  // Áp dụng vào thứ 7 (1: Có, 0: Không)
            'apply_on_sun' => $this->apply_on_sun,  // Áp dụng vào chủ nhật (1: Có, 0: Không)
            'apply_hours' => $this->getApplyHours(), // Danh sách các giờ áp dụng từ 0 đến 23 giờ
            'status' => $this->status, // Danh sách các giờ áp dụng từ 0 đến 23 giờ
        ];
    }

    /**
     * Get the apply hours in an array format.
     *
     * @return array
     */
    private function getApplyHours(): array
    {
        $hours = [];
        // Tạo mảng các giờ từ 0 đến 23 và kiểm tra xem giờ nào được áp dụng
        for ($i = 0; $i <= 23; $i++) {
            $hours["apply_hour_$i"] = $this->{"apply_hour_$i"};  // Kiểm tra xem giờ cụ thể có được áp dụng không (1: Có, 0: Không)
        }
        return $hours;
    }
}
