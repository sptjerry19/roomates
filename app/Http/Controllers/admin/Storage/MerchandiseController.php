<?php

namespace App\Http\Controllers\admin\Storage;

use App\Helpers\ApiResponse;
use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Merchandise\MerchandiseRequest;
use App\Http\Requests\Admin\Merchandise\StoreRequest;
use App\Http\Resources\Admin\Merchandise\MerchandiseCollection;
use App\Http\Resources\Admin\Merchandise\MerchandiseResource;
use App\Models\Admin\Storage\Unit;
use App\Services\Admin\Merchandise\MerchandiseService;
use App\Services\Admin\Unit\UnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MerchandiseController extends Controller
{
    protected $merchandiseService;
    protected $unitService;
    public function __construct(MerchandiseService $merchandiseService, UnitService $unitService)
    {
        $this->merchandiseService = $merchandiseService;
        $this->unitService = $unitService;
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
                'commodity_id' => 'nullable|integer',
                'storage_id' => 'nullable|integer',
                'status' => 'nullable|boolean',
            ]);

            $merchandises = $this->merchandiseService->getMerchandises($params, $page, $limit);

            return ApiResponse::success(new MerchandiseCollection($merchandises), __('message.storage.merchandise.getlist_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.storage.merchandise.getlist_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $params = $request->validated();

            if (isset($params['unit'])) {
                $unit = $params['unit'];
                do {
                    $code = '#TYPE-' . Common::generateCode(6);

                    $codeExists = Unit::query()->where('code', $code)->exists();
                } while ($codeExists);

                $data = [
                    'name' =>  $unit['name'],
                    'quantity' =>  $unit['quantity'],
                    'mass_type' =>  $unit['mass_type'],
                    'code' => $code,
                ];

                $unitNew = $this->unitService->createUnit($data);

                $params['unit_id'] = $unitNew->id;
            }

            $merchandise = $this->merchandiseService->createMerchandise($params);

            return ApiResponse::success(new MerchandiseResource($merchandise), __('message.storage.merchandise.create_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.storage.merchandise.create_fail'), 500);
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
    public function update(MerchandiseRequest $request, string $id)
    {
        try {
            $params = $request->validated();

            if (isset($params['unit'])) {
                $unit = $params['unit'];
                do {
                    $code = '#TYPE-' . Common::generateCode(6);

                    $codeExists = Unit::query()->where('code', $code)->exists();
                } while ($codeExists);

                $data = [
                    'name' =>  $unit['name'],
                    'quantity' =>  $unit['quantity'],
                    'mass_type' =>  $unit['mass_type'],
                    'code' => $code,
                ];

                $unitNew = $this->unitService->createUnit($data);

                $params['unit_id'] = $unitNew->id;
            }

            $merchandise = $this->merchandiseService->updateMerchandise($params, $id);

            return ApiResponse::success(new MerchandiseResource($merchandise), __('message.storage.merchandise.update_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.storage.merchandise.update_fail'), 500);
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        try {
            $field = $request->validate([
                'status' => 'nullable|boolean',
            ]);
            $status = $field['status'] ?? false;
            $merchandise = $this->merchandiseService->updateStatusMerchandise($id, $status);
            return ApiResponse::success([], __('message.storage.merchandise.update_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.storage.merchandise.update_fail'), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $merchandise = $this->merchandiseService->findOrFail($id);
            $merchandise->delete();
            return ApiResponse::success([], __('message.storage.merchandise.deleted_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.storage.merchandise.deleted_fail'), 500);
        }
    }
}
