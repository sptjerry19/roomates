<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\POS\Topping\CreateRequest;
use App\Http\Requests\POS\Topping\UpdateRequest;
use App\Models\Admin\Topping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ToppingController extends Controller
{
    public function getList()
    {
        try {
            $shopId = auth('api')->user()->shop_id;
            $data = Topping::where('status', 'active')->when(!is_null($shopId), function ($query) use ($shopId) {
                    return $query->where('shop_id', $shopId);
                })
                ->with(['products' => function($query) {
                    $query->wherePivot('is_topping', true);
                }])
                ->get();
            if (!$data) {
                return ApiResponse::error('Error', 404);
            }
            return ApiResponse::success($data, __('Success'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function create(CreateRequest $request)
    {
        DB::beginTransaction();

        $user = auth('api')->user();
        try {
            $data = [
                'name' => $request['name'],
                'user_id' => $user->id,
                'shop_id' => $user->shop_id,
            ];
            $topping = Topping::create($data);

            if (!empty($request['product_id'])) {
                $productsWithIsTopping = [];
                foreach ($request['product_id'] as $productId) {
                    $productsWithIsTopping[$productId] = ['is_topping' => true];
                }

                $topping->products()->attach($productsWithIsTopping);
            }

            DB::commit();
            return ApiResponse::success($topping, __('Tạo mới topping thành công'));

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return ApiResponse::error("Tạo mới topping thất bại.", 500);
        }
    }

    public function updateTopping(UpdateRequest $request, $id)
    {
        $user = auth()->user();
        DB::beginTransaction();
        try {
            $topping = Topping::findOrFail($id);
            $topping->update([
                'name' => $request['name'],
                'user_id' => $user->id,
                'shop_id' => $user->shop_id,
            ]);

            $topping->products()->detach();
            if (!empty($request['product_id'])) {
                $productsWithIsTopping = [];
                foreach ($request['product_id'] as $productId) {
                    $productsWithIsTopping[$productId] = ['is_topping' => true];
                }

                $topping->products()->attach($productsWithIsTopping);
            }
            DB::commit();
            return ApiResponse::success($topping, __('Cập nhập topping thành công'));

        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return ApiResponse::error("Cập nhập topping thất bại.", 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $option = Topping::find($id);

            if (!$option) {
                return ApiResponse::error("Đã có lỗi xảy ra. Vui lòng thử lại.", 404);
            }
            $option->products()->detach();
            $option->delete();

            DB::commit();
            return ApiResponse::success($option, __('Xóa topping thành công'));
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            return ApiResponse::error('Xóa topping thất bại', 500);
        }
    }
}
