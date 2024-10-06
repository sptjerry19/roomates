<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\POS\Table\CreateRequest;
use App\Http\Requests\POS\Table\UpdateRequest;
use App\Models\Admin\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
{
    public function getList()
    {
        $companyId = auth('api')->user()->company_id;
        $shopId = auth('api')->user()->shop_id;

        try {
            $data = Table::where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })->get();


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
            $names = $request['table_number'];
            $userId = $user->id;
            $shopId = $user->shop_id;
            $areaId = $request['area_id'];
            $tableType = $request['table_type'];

        // Kiểm tra số lượng bàn hiện tại trong shop
        $currentTableCount = Table::where('shop_id', $shopId)->count();

        // Giới hạn tối đa 1000 bàn
        if ($currentTableCount + count($names) > 1000) {
            return ApiResponse::error('Số lượng bàn đã đạt giới hạn tối đa 1000.', 400);
        }

        $existingNames = Table::where('shop_id', $shopId)
            ->whereIn('table_number', $names)
            ->pluck('table_number')
            ->toArray();

        $duplicateNames = array_intersect($names, $existingNames);
        if (count($duplicateNames) > 0) {
            return ApiResponse::error('Bàn đã tồn tại: ' . implode(', ', $duplicateNames), 400);
        }
            foreach ($names as $index => $name) {
                $data = [
                    'table_number' => $name,
                    'user_id' => $userId,
                    'shop_id' => $shopId,
                    'area_id' => $areaId,
                    'table_type' => $tableType[$index],
                    'company_id' => $user->company_id
                ];

                $table = Table::create($data);
            }
            DB::commit();
            return ApiResponse::success($table, __('Tạo mới bàn thành công'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return ApiResponse::error("Tạo mới bàn thất bại.", 500);
        }
    }

    public function updateTable(UpdateRequest $request, $id)
    {
        $data = Table::find($id);
        $user = auth()->user();
        DB::beginTransaction();
        try {
            $dataUpdate = [
                'table_number' => $request['table_number'],
                'user_id' => $user->id,
                'area_id' => $request['area_id'],
                'table_type' => $request['table_type'],
                'shop_id' => $user->shop_id,
                'status' => $request['status'] ?? 'available',
            ];

            $data->update($dataUpdate);

            DB::commit();
            return ApiResponse::success($data, __('Cập nhập bàn thành công'));
        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return ApiResponse::error("Cập nhập bàn thất bại.", 500);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $ids = $request->input('ids');

            $tables = Table::whereIn('id', $ids)->get();

            if ($tables->isEmpty()) {
                return ApiResponse::error("Không tìm thấy bàn nào với ID được cung cấp.", 404);
            }

            Table::whereIn('id', $ids)->delete();

            DB::commit();
            return ApiResponse::success($tables, __('Xóa bàn thành công'));
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            return ApiResponse::error('Xóa bàn thất bại', 500);
        }
    }
}
