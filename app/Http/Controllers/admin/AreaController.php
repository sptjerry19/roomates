<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Area\StoreRequest;
use App\Http\Requests\Admin\Area\UpdateRequest;
use App\Http\Resources\Admin\Area\AreaResource;
use App\Http\Resources\Admin\Area\ListAreaCollection;
use App\Services\Admin\Area\AreaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
{
    protected $areaService;
    public function __construct(AreaService $areaService)
    {
        $this->areaService = $areaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $page = $request->input('page');
            $limit = $request->input('limit', config('constant.PAGINATION'));
            $params = $request->validate([
                'keyword' => 'nullable|string',
                'shop_id' => 'nullable|integer',
            ]);
            $areas = $this->areaService->getAreas($params, $page, $limit);
            return ApiResponse::success(new ListAreaCollection($areas), __('message.success.area.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.area.get_list_fail'), 500);
        }
    }

    public function detail(Request $request, string $id)
    {
        try {
            $area = $this->areaService->find($id);
            return ApiResponse::success(new AreaResource($area), __('message.success.area.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.area.get_list_fail'), 500);
        }
    }

    public function listArea()
    {
        try {
            $areas = $this->areaService->listArea();
            foreach ($areas as $area) {
                $area->branch = $area->shop->name;
            }
            return ApiResponse::success(($areas), __('message.success.area.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.area.get_list_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $fields = $request->validated();

            $area = $this->areaService->createArea($fields);

            return ApiResponse::success(new AreaResource($area), __('message.success.area.created_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.area.created_fail'), 500);
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
    public function update(UpdateRequest $request, string $id)
    {
        // try {
        $fields = $request->validated();

        return $this->areaService->updateArea($fields, $id);

        // return ApiResponse::success(new AreaResource($area), __('message.success.area.updated_success'));
        // } catch (\Exception $e) {
        //     Log::error($e->getMessage());
        //     return ApiResponse::error(__('message.error.area.updated_fail'), 500);
        // }
    }

    /**
     * Update status the specified resource in storage.
     */
    public function updateStatusArea(Request $request, string $id)
    {
        try {
            $field = $request->validate([
                'status' => 'nullable|boolean'
            ]);
            $status = $field['status'] ?? false;
            $area = $this->areaService->updateStatusArea($id, $status);

            return ApiResponse::success([], __('message.success.area.update_status_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.area.update_status_fail'), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
