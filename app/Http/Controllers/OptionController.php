<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\POS\Option\CreateRequest;
use App\Http\Requests\POS\Option\UpdateRequest;
use App\Models\Admin\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OptionController extends Controller
{
    public function getList()
    {
        try {
            $data = Option::with('optionsAttrs')->get();
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
            $option = Option::create($data);

            if (!empty($request['values'])) {
                $optionsData = [];
                foreach ($request['values'] as $item) {
                    $optionsData[] = [
                        'value' => $item['value'],
                        'price' => $item['price'],
                    ];
                }
                $option->optionsAttrs()->createMany($optionsData);
            }

            DB::commit();
            return ApiResponse::success($option, __('Tạo mới option thành công'));

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return ApiResponse::error("Tạo mới option thất bại.", 500);
        }
    }

    public function updateOption(UpdateRequest $request, $id)
    {
        $data = Option::find($id);
        $user = auth()->user();
        DB::beginTransaction();
        try {
            $option = Option::findOrFail($id);
            $option->update([
                'name' => $request['name'],
                'user_id' => $user->id,
                'shop_id' => $user->shop_id,
            ]);

            $option->optionsAttrs()->delete();

            if (!empty($request['values'])) {
                $optionsData = [];
                foreach ($request['values'] as $item) {
                    $optionsData[] = [
                        'value' => $item['value'],
                        'price' => $item['price'],
                    ];
                }
                $option->optionsAttrs()->createMany($optionsData);
            }
            DB::commit();
            return ApiResponse::success($data, __('Cập nhập option thành công'));

        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return ApiResponse::error("Cập nhập option thất bại.", 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $option = Option::find($id);

            if (!$option) {
                return ApiResponse::error("Đã có lỗi xảy ra. Vui lòng thử lại.", 404);
            }
            $option->optionsAttrs()->delete();
            $option->delete();

            DB::commit();
            return ApiResponse::success($option, __('Xóa option thành công'));
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            return ApiResponse::error('Xóa option thất bại', 500);
        }
    }
}
