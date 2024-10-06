<?php

namespace App\Http\Controllers\admin\Storage;

use App\Helpers\ApiResponse;
use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CommodityGroups\CommodityGroupCollection;
use App\Http\Resources\Admin\CommodityGroups\CommodityGroupResource;
use App\Models\Admin\Storage\CommodityGroup;
use App\Services\Admin\CommodityGroup\CommodityGroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommodityGroupController extends Controller
{
    protected $commodityGroupService;
    public function __construct(CommodityGroupService $commodityGroupService)
    {
        $this->commodityGroupService = $commodityGroupService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // $page = $request->input('page');
            // $limit = $request->input('limit', config('constant.PAGINATION'));
            $params = $request->validate([
                'keyword' => 'nullable|string',
                'status' => 'nullable|boolean',
            ]);
            $commodityGroups = $this->commodityGroupService->getCommodityGroups($params);
            return ApiResponse::success(new CommodityGroupCollection($commodityGroups), __('message.storage.commodityGroup.getlist_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.storage.commodityGroup.getlist_fail'), 500);
        }
    }

    public function generateCode()
    {
        try {
            do {
                $code = '#TYPE-' . Common::generateCode(6);

                $codeExists = CommodityGroup::query()->where('code', $code)->exists();
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
        // try {
        $params = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:commodity_groups',
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi hợp lệ.',
            'code.required' => 'Mã là bắt buộc.',
            'code.string' => 'Mã phải là một chuỗi hợp lệ.',
            'code.unique' => 'Mã đã tồn tại trong cơ sở dữ liệu.',
        ]);
        $commodityGroup = $this->commodityGroupService->createCommodityGroup($params);
        if (!$commodityGroup) {
            return ApiResponse::error(__('message.storage.commodityGroup.create_fail'), 500);
        }
        return ApiResponse::success(new CommodityGroupResource($commodityGroup), __('message.storage.commodityGroup.create_success'));
        // } catch (\Exception $e) {
        //     Log::error($e->getMessage());
        //     return ApiResponse::error(__('message.storage.commodityGroup.create_fail'), 500);
        // }
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
        $params = $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi hợp lệ.',
        ]);
        $commodityGroup = $this->commodityGroupService->updateCommodityGroup($params, $id);
        if (!$commodityGroup) {
            return ApiResponse::error(__('message.storage.commodityGroup.update_fail'), 500);
        }
        return ApiResponse::success(new CommodityGroupResource($commodityGroup), __('message.storage.commodityGroup.update_success'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $params = $request->validate([
            'status' => 'nullable|boolean',
        ], [
            'status.boolean' => 'Trạng thái phải là true hoặc false.',
        ]);
        $status = $params['status'] ?? false;
        $commodityGroup = $this->commodityGroupService->updateStatusCommodityGroup($id, $status);
        if (!$commodityGroup) {
            return ApiResponse::error(__('message.storage.commodityGroup.update_fail'), 500);
        }
        return ApiResponse::success([], __('message.storage.commodityGroup.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
