<?php

namespace App\Http\Requests\Admin\Source;

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
            'name' => 'nullable|string|max:255',  // Nguồn (VD: Shopee Food), có thể để trống
            'shop_id' => 'required|integer|exists:m_shop,id',  // Chi nhánh áp dụng (phải là ID hợp lệ từ bảng shops)
            'refund_percentage' => 'required|numeric|between:0,100',  // Phần trăm hoa hồng trả sản, giá trị từ 0 đến 100
            'bill_type' => 'required|string|max:255',  // Kiểu in hóa đơn cho khách hàng, có thể là chuỗi (VD: giấy, điện tử)
            'payment_method' => 'required|string|max:255',  // Hình thức thanh toán, có thể để trống
            'require_partner_code' => 'required|boolean',  // Có yêu cầu nhập mã đối tác hay không (1: Có, 0: Không)
            'revenue_includes_shipping' => 'required|boolean',  // Tính phí vận chuyển vào doanh thu hay không (1: Có, 0: Không)
            'source_id' => 'nullable|integer|exists:m_source,id',

            // Cấu hình giá menu
            'menu_price_increase_percentage' => 'nullable|numeric',  // Tăng giá menu theo phần trăm (0 đến 100%)
            'value' => 'nullable',  // Tăng giá menu theo phần trăm (0 đến 100%)

            // Cấu hình chi phí hỗ trợ marketing
            'marketing_support_percentage' => 'required|numeric|between:0,100',  // Phần trăm chi phí hỗ trợ marketing
            'voucher_code' => 'required|string|max:255',  // Mã voucher, có thể là chuỗi
            'marketing_start_date' => 'required|date_format:Y-m-d',  // Ngày bắt đầu chiến dịch marketing
            'marketing_end_date' => 'required|date_format:Y-m-d|after_or_equal:marketing_start_date',  // Ngày kết thúc chiến dịch, phải sau hoặc bằng ngày bắt đầu

            // Ngày áp dụng trong chiến dịch (các giá trị này phải là boolean)
            'apply_on_mon' => 'required|boolean',  // Thứ 2
            'apply_on_tue' => 'required|boolean',  // Thứ 3
            'apply_on_wed' => 'required|boolean',  // Thứ 4
            'apply_on_thu' => 'required|boolean',  // Thứ 5
            'apply_on_fri' => 'required|boolean',  // Thứ 6
            'apply_on_sat' => 'required|boolean',  // Thứ 7
            'apply_on_sun' => 'required|boolean',  // Chủ nhật

            // Khung giờ áp dụng (các giờ từ 0 đến 23 phải là boolean)
            'apply_hours' => 'required|array',  // Mảng chứa các giờ từ 0 đến 23
            'apply_hours.*' => 'required|boolean',  // Từng giờ phải là giá trị boolean (1: Có áp dụng, 0: Không áp dụng)
        ];
    }

    public function messages(): array
    {
        return [
            // Tên nguồn
            'name.string' => 'Tên nguồn phải là chuỗi ký tự.',
            'name.max' => 'Tên nguồn không được vượt quá 255 ký tự.',

            // Chi nhánh áp dụng
            'shop_id.required' => 'Chi nhánh áp dụng là bắt buộc.',
            'shop_id.integer' => 'Chi nhánh áp dụng phải là số nguyên.',
            'shop_id.exists' => 'Chi nhánh áp dụng không tồn tại trong hệ thống.',

            // Phần trăm hoa hồng
            'refund_percentage.required' => 'Phần trăm hoa hồng là bắt buộc.',
            'refund_percentage.numeric' => 'Phần trăm hoa hồng phải là số.',
            'refund_percentage.between' => 'Phần trăm hoa hồng phải nằm trong khoảng từ 0 đến 100.',

            // Kiểu in hóa đơn
            'bill_type.required' => 'Kiểu in hóa đơn là bắt buộc.',
            'bill_type.string' => 'Kiểu in hóa đơn phải là chuỗi ký tự.',
            'bill_type.max' => 'Kiểu in hóa đơn không được vượt quá 255 ký tự.',

            // Phương thức thanh toán
            'payment_method.required' => 'Phương thức thanh toán là bắt buộc.',
            'payment_method.string' => 'Phương thức thanh toán phải là chuỗi ký tự.',
            'payment_method.max' => 'Phương thức thanh toán không được vượt quá 255 ký tự.',

            // Yêu cầu mã đối tác
            'require_partner_code.required' => 'Bạn phải chọn có yêu cầu mã đối tác hay không.',
            'require_partner_code.boolean' => 'Giá trị yêu cầu mã đối tác phải là đúng hoặc sai.',

            // Doanh thu bao gồm phí vận chuyển
            'revenue_includes_shipping.required' => 'Bạn phải chọn có tính phí vận chuyển vào doanh thu hay không.',
            'revenue_includes_shipping.boolean' => 'Giá trị doanh thu bao gồm phí vận chuyển phải là đúng hoặc sai.',

            // Tăng giá menu
            'menu_price_increase_percentage.numeric' => 'Phần trăm tăng giá menu phải là số.',
            'menu_price_increase_percentage.between' => 'Phần trăm tăng giá menu phải nằm trong khoảng từ 0 đến 100.',

            // Chi phí hỗ trợ marketing
            'marketing_support_percentage.required' => 'Phần trăm chi phí hỗ trợ marketing là bắt buộc.',
            'marketing_support_percentage.numeric' => 'Phần trăm chi phí hỗ trợ marketing phải là số.',
            'marketing_support_percentage.between' => 'Phần trăm chi phí hỗ trợ marketing phải nằm trong khoảng từ 0 đến 100.',

            // Mã voucher
            'voucher_code.required' => 'Mã voucher là bắt buộc.',
            'voucher_code.string' => 'Mã voucher phải là chuỗi ký tự.',
            'voucher_code.max' => 'Mã voucher không được vượt quá 255 ký tự.',

            // Ngày bắt đầu/ kết thúc chiến dịch
            'marketing_start_date.required' => 'Ngày bắt đầu chiến dịch marketing là bắt buộc.',
            'marketing_start_date.date' => 'Ngày bắt đầu phải là ngày hợp lệ.',
            'marketing_end_date.required' => 'Ngày kết thúc chiến dịch marketing là bắt buộc.',
            'marketing_end_date.date' => 'Ngày kết thúc phải là ngày hợp lệ.',
            'marketing_end_date.after_or_equal' => 'Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.',

            // Ngày áp dụng
            'apply_on_mon.required' => 'Bạn phải chọn có áp dụng cho thứ 2 hay không.',
            'apply_on_mon.boolean' => 'Giá trị áp dụng cho thứ 2 phải là đúng hoặc sai.',
            'apply_on_tue.required' => 'Bạn phải chọn có áp dụng cho thứ 3 hay không.',
            'apply_on_tue.boolean' => 'Giá trị áp dụng cho thứ 3 phải là đúng hoặc sai.',
            'apply_on_wed.required' => 'Bạn phải chọn có áp dụng cho thứ 4 hay không.',
            'apply_on_wed.boolean' => 'Giá trị áp dụng cho thứ 4 phải là đúng hoặc sai.',
            'apply_on_thu.required' => 'Bạn phải chọn có áp dụng cho thứ 5 hay không.',
            'apply_on_thu.boolean' => 'Giá trị áp dụng cho thứ 5 phải là đúng hoặc sai.',
            'apply_on_fri.required' => 'Bạn phải chọn có áp dụng cho thứ 6 hay không.',
            'apply_on_fri.boolean' => 'Giá trị áp dụng cho thứ 6 phải là đúng hoặc sai.',
            'apply_on_sat.required' => 'Bạn phải chọn có áp dụng cho thứ 7 hay không.',
            'apply_on_sat.boolean' => 'Giá trị áp dụng cho thứ 7 phải là đúng hoặc sai.',
            'apply_on_sun.required' => 'Bạn phải chọn có áp dụng cho Chủ nhật hay không.',
            'apply_on_sun.boolean' => 'Giá trị áp dụng cho Chủ nhật phải là đúng hoặc sai.',

            // Khung giờ áp dụng
            'apply_hours.required' => 'Khung giờ áp dụng là bắt buộc.',
            'apply_hours.array' => 'Khung giờ áp dụng phải là mảng.',
            'apply_hours.*.boolean' => 'Mỗi khung giờ áp dụng phải là giá trị đúng hoặc sai.',
        ];
    }
}
