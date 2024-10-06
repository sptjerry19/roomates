<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\Common;
use App\Http\Requests\POS\Area\UpdateRequest;
use App\Http\Requests\POS\Area\CreateRequest;
use App\Models\Admin\Area;
use App\Services\Pos\Area\AreaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AreaController extends Controller
{
    protected $areaService;

    public function __construct(AreaService $areaService)
    {
        $this->areaService = $areaService;
    }
    public function getList(Request $request)
    {
        try {
            $data = $this->areaService->getList($request);
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
                'company_id' => $user->company_id,
                'area_code' => '#AREA-' . Common::generateCode(4),
            ];
            $area = Area::create($data);

            DB::commit();
            return ApiResponse::success($area, __('Tạo mới khu vực thành công'));

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return ApiResponse::error("Tạo mới khu vực thất bại.", 500);
        }
    }

    public function updateArea(UpdateRequest $request, $id)
    {
        $data = Area::find($id);
        $user = auth()->user();
        DB::beginTransaction();
        try {
            $dataUpdate = [
                'name' => $request['name'],
                'user_id' => $user->id,
                'shop_id' => $user->shop_id,
            ];

            $data->update($dataUpdate);

            DB::commit();
            return ApiResponse::success($data, __('Cập nhập khu vực thành công'));

        } catch (\Throwable $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return ApiResponse::error("Cập nhập khu vực thất bại.", 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $area = Area::find($id);

            if (!$area) {
                return ApiResponse::error("Đã có lỗi xảy ra. Vui lòng thử lại.", 404);
            }

            $area->areaShopAttrs()->detach();
            $area->delete();

            DB::commit();
            return ApiResponse::success($area, __('Xóa khu vực thành công'));
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            return ApiResponse::error('Xóa khu vực thất bại', 500);
        }
    }
}
