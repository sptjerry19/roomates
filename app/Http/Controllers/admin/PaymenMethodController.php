<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PaymentMethod\PaymentMethodCollection;
use App\Http\Resources\Admin\PaymentMethod\PaymentMethodResource;
use App\Models\Admin\PayBy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymenMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $companyId = auth()->user()->company_id;
            $data = PayBy::query()->where('shop_id', $companyId)->get();
            if (!$data) {
                return ApiResponse::error('message.error.option.get_list_fail', 404);
            }
            return ApiResponse::success(new PaymentMethodCollection($data), __("Lấy thông tin phương thức thanh toán thành công."));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Lấy thông tin phương thức thanh toán thất bại', 500);
        }
    }

    public function generateCode()
    {
        try {
            do {
                $code = '#' . Common::generateCode(6);

                $codeExists = PayBy::query()->where('pay_code', $code)->exists();
            } while ($codeExists);

            $data = [
                'code' => $code,
            ];

            return ApiResponse::success($data, __('message.success.generate_code'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.generate_code'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|string',
                'pay_code' => 'required|string|max:50',
                'payment_fee' => 'required|numeric|min:0',
                'shops' => 'nullable|array',
                'shops.*' => 'integer|exists:m_shop,id',
            ], [
                'name.required' => 'Tên phương thức thanh toán là bắt buộc.',
                'name.string' => 'Tên phương thức thanh toán phải là chuỗi.',
                'name.max' => 'Tên phương thức thanh toán không được vượt quá 255 ký tự.',

                'pay_code.required' => 'Mã thanh toán là bắt buộc.',
                'pay_code.string' => 'Mã thanh toán phải là chuỗi.',
                'pay_code.unique' => 'Mã thanh toán đã tồn tại.',
                'pay_code.max' => 'Mã thanh toán không được vượt quá 50 ký tự.',

                'payment_fee.required' => 'Phí thanh toán là bắt buộc.',
                'payment_fee.numeric' => 'Phí thanh toán phải là số.',
                'payment_fee.min' => 'Phí thanh toán phải lớn hơn hoặc bằng 0.',

                'shops.array' => 'Danh sách cửa hàng phải là mảng.',
                'shops.*.integer' => 'Mã cửa hàng phải là số nguyên.',
                'shops.*.exists' => 'Cửa hàng không hợp lệ.',
            ]);

            $image = isset($fields['image']) ?  Common::uploadbase64Image($fields['image'], 'Payment/image/') : null;
            $pay = PayBy::query()->create([
                'name' => $fields['name'],
                'image' => $fields['image'],
                'pay_code' => $fields['pay_code'],
                'payment_fee' => $fields['payment_fee'],
                'shop_id' => auth()->user()->company_id
            ]);


            $shops = $fields['shops'] ?? null;
            if (!is_null($shops)) {
                if (is_array($shops)) {
                    $pay->shops()->attach($shops);
                } else {
                    $pay->shops()->attach([$shops]);
                }
            }

            return ApiResponse::success(new PaymentMethodResource($pay), __("Tạo mới phương thức thanh toán thành công."));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Tạo mới phương thức thanh toán thất bại', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|string',
                'pay_code' => 'required|string|max:50',
                'payment_fee' => 'required|numeric|min:0',
                'shops' => 'nullable|array',
                'shops.*' => 'integer|exists:m_shop,id',
            ], [
                'name.required' => 'Tên phương thức thanh toán là bắt buộc.',
                'name.string' => 'Tên phương thức thanh toán phải là chuỗi.',
                'name.max' => 'Tên phương thức thanh toán không được vượt quá 255 ký tự.',

                'pay_code.required' => 'Mã thanh toán là bắt buộc.',
                'pay_code.string' => 'Mã thanh toán phải là chuỗi.',
                'pay_code.unique' => 'Mã thanh toán đã tồn tại.',
                'pay_code.max' => 'Mã thanh toán không được vượt quá 50 ký tự.',

                'payment_fee.required' => 'Phí thanh toán là bắt buộc.',
                'payment_fee.numeric' => 'Phí thanh toán phải là số.',
                'payment_fee.min' => 'Phí thanh toán phải lớn hơn hoặc bằng 0.',

                'shops.array' => 'Danh sách cửa hàng phải là mảng.',
                'shops.*.integer' => 'Mã cửa hàng phải là số nguyên.',
                'shops.*.exists' => 'Cửa hàng không hợp lệ.',
            ]);

            $pay = PayBy::query()->findOrFail($id);
            $oldImagePath = $pay->image;

            $image = null; // Đặt giá trị mặc định là null
            if (array_key_exists('image', $fields)) {
                $image = Common::updateProductImage($fields['image'], $oldImagePath, 'Payment/image/');
            }

            $data = [
                'name' => $fields['name'],
                'pay_code' => $fields['pay_code'],
                'payment_fee' => $fields['payment_fee'],
                'shop_id' => auth()->user()->company_id
            ];

            if (!is_null($image)) {
                $data['image'] = $image;
            } elseif (array_key_exists('image', $fields) && is_null($fields['image'])) {
                $data['image'] = null;
            }

            $pay->update($data);

            // Sync shops if provided
            $shops = $fields['shops'] ?? [];
            if (!empty($shops)) {
                $pay->shops()->sync($shops);
            }

            return ApiResponse::success(new PaymentMethodResource($pay), __("Cập nhập phương thức thanh toán thành công."));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Cập nhập phương thức thanh toán thất bại', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updateStatus(Request $request, string $id)
    {
        try {
            $field = $request->validate([
                'status' => 'nullable|boolean'
            ]);
            $status = $field['status'] ?? false;
            $pay = PayBy::query()->findOrFail($id);
            $pay->update([
                'status' => $status
            ]);
            return ApiResponse::success([], __("Cập nhập trạng thái phương thức thanh toán thành công."));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Cập nhập trạng thái phương thức thanh toán thất bại', 500);
        }
    }
}
