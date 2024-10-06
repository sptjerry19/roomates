<?php

namespace App\Http\Controllers\admin\Storage;

use App\Helpers\ApiResponse;
use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Unit\StoreRequest;
use App\Http\Requests\Admin\Unit\UpdateRequest;
use App\Http\Resources\Admin\Unit\UnitCollection;
use App\Http\Resources\Admin\Unit\UnitResource;
use App\Models\Admin\Storage\Unit;
use App\Services\Admin\Unit\UnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnitController extends Controller
{
    protected $unitService;
    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $params = $request->validate([
                'keyword' => 'nullable|string',
                'status' => 'nullable|boolean',
            ]);
            $units = $this->unitService->getUnits($params);
            return ApiResponse::success(new UnitCollection($units), __('message.storage.unit.getlist_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.storage.unit.getlist_fail'), 500);
        }
    }

    public static function generateCode()
    {
        try {
            do {
                $code = '#TYPE-' . Common::generateCode(6);

                $codeExists = Unit::query()->where('code', $code)->exists();
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
    public function store(StoreRequest $request)
    {
        // try {
        $params = $request->validated();
        $unit = $this->unitService->createUnit($params);
        if (!$unit) {
            return ApiResponse::error(__('message.storage.unit.create_fail'), 500);
        }
        return ApiResponse::success(new UnitResource($unit), __('message.storage.unit.create_success'));
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
    public function update(UpdateRequest $request, string $id)
    {
        $params = $request->validated();
        $unit = $this->unitService->updateUnit($params, $id);
        if (!$unit) {
            return ApiResponse::error(__('message.storage.unit.update_fail'), 500);
        }
        return ApiResponse::success(new UnitResource($unit), __('message.storage.unit.update_success'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $params = $request->validate([
            'status' => 'nullable|boolean',
        ], [
            'status.boolean' => 'Trạng thái phải là true hoặc false.',
        ]);
        $status = $params['status'] ?? false;
        $unit = $this->unitService->updateStatusUnit($id, $status);
        if (!$unit) {
            return ApiResponse::error(__('message.storage.unit.update_fail'), 500);
        }
        return ApiResponse::success([], __('message.storage.unit.update_success'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
