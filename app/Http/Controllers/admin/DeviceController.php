<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Device\StoreRequest;
use App\Http\Requests\Admin\Device\UpdateRequest;
use App\Http\Resources\Admin\Device\DeviceCollection;
use App\Http\Resources\Admin\Device\DeviceResource;
use App\Services\Admin\Device\DeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{
    protected $deviceService;
    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
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
                'device_type' => 'nullable|string',
            ]);
            $devices = $this->deviceService->getDevices($params, $page, $limit);
            return ApiResponse::success(new DeviceCollection($devices), __('message.success.device.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.device.get_list_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $fields = $request->validated();
            $device = $this->deviceService->createDevice($fields);
            return ApiResponse::success($device, __('message.success.device.created_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.device.create_fail'), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        try {
            $device = $this->deviceService->find($id);
            if (!$device) {
                return ApiResponse::error(__('message.error.device.detail_fail'), 500);
            }
            return ApiResponse::success(new DeviceResource($device), __('message.success.device.detail_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.device.detail_fail'), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $fields = $request->validated();
            $device = $this->deviceService->updateDevice($id, $fields);
            return ApiResponse::success($device, __('message.success.device.updated_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.device.updated_fail'), 500);
        }
    }

    public function updateStatusDevice(Request $request, string $id)
    {
        try {
            $field = $request->validate([
                'status' => 'nullable|boolean',
            ]);
            $status = $field['status'] ?? false;
            $device = $this->deviceService->updateStatusDevice($id, $status);
            return ApiResponse::success($device, __('message.success.device.updated_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.device.updated_fail'), 500);
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
