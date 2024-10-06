<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\POS\CardTable\CreateRequest;
use App\Http\Requests\POS\CardTable\UpdateRequest;
use App\Models\Admin\CardTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CardTableController extends Controller
{
    public function getList()
    {
        try {
            $companyId = auth('api')->user()->company_id;
            $shopId = auth('api')->user()->shop_id;

            $data = CardTable::where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })->where('status', 'active')->get();
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
            $names = $request['name'];
            $userId = $user->id;
            $shopId = $user->shop_id;

            // Kiểm tra số lượng thẻ bàn hiện tại trong shop
            $currentCardTableCount = CardTable::where('shop_id', $shopId)->count();

            // Giới hạn tối đa 1000 thẻ bàn
            if ($currentCardTableCount + count($names) > 1000) {
                return ApiResponse::error('Số lượng thẻ bàn đã đạt giới hạn tối đa 1000.', 400);
            }

            $existingNames = CardTable::where('shop_id', $shopId)
                ->whereIn('name', $names)
                ->pluck('name')
                ->toArray();

            $duplicateNames = array_intersect($names, $existingNames);
            if (count($duplicateNames) > 0) {
                return ApiResponse::error('Thẻ đã tồn tại: ' . implode(', ', $duplicateNames), 400);
            }

            foreach ($names as $name) {
                $data = [
                    'name' => $name,
                    'user_id' => $userId,
                    'shop_id' => $shopId,
                    'company_id' => $user->company_id,
                ];

                $cardTable = CardTable::create($data);
            }

            DB::commit();
            return ApiResponse::success($cardTable, __('Tạo mới thẻ bàn thành công'));

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return ApiResponse::error("Tạo mới thẻ bàn thất bại.", 500);
        }
    }


    public function updateCardTable(UpdateRequest $request, $id)
    {
        $data = CardTable::find($id);
        $user = auth()->user();
        DB::beginTransaction();
        try {
            $dataUpdate = [
                'name' => $request['name'],
                'user_id' => $user->id,
                'shop_id' => $user->shop_id,
                'status' => $request['status'] ?? 'active',
            ];

            $data->update($dataUpdate);

            DB::commit();
            return ApiResponse::success($data, __('Cập nhập thẻ bàn thành công'));

        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return ApiResponse::error("Cập nhập thẻ bàn thất bại.", 500);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $ids = $request->input('ids');

            $cardTables = CardTable::whereIn('id', $ids)->get();

            if ($cardTables->isEmpty()) {
                return ApiResponse::error("Không tìm thấy thẻ bàn nào với ID được cung cấp.", 404);
            }

            CardTable::whereIn('id', $ids)->delete();

            DB::commit();
            return ApiResponse::success($cardTables, __('Xóa thẻ bàn thành công'));
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            return ApiResponse::error('Xóa thẻ bàn thất bại', 500);
        }
    }
}
