<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Combo\StoreRequest;
use App\Http\Requests\Admin\Combo\UpdateRequest;
use App\Http\Resources\Admin\Combo\ComboCollection;
use App\Http\Resources\Admin\Combo\ComboResource;
use App\Models\Admin\Combo;
use App\Services\Admin\Combo\ComboService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComboController extends Controller
{
    protected $comboService;
    public function __construct(ComboService $comboService)
    {
        $this->comboService = $comboService;
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
            $combos = $this->comboService->getComboByCompany($params, $page, $limit);
            return ApiResponse::success(new ComboCollection($combos), __('message.success.combo.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.combo.get_list_fail'), 500);
        }
    }

    public function generateCode()
    {
        try {
            do {
                $code = '#CB-' . Common::generateCode(6);

                $codeExists = Combo::query()->where('code', $code)->exists();
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
        try {
            $fields = $request->validated();
            $combo = $this->comboService->createCombo($fields);
            return ApiResponse::success(new ComboResource($combo), __('message.success.combo.created_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.combo.create_fail'), 500);
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
        try {
            $fields = $request->validated();
            $combo = $this->comboService->updateCombo($fields, $id);
            return ApiResponse::success(new ComboResource($combo), __('message.success.combo.created_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.combo.create_fail'), 500);
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        try {
            $field = $request->validate([
                'status' => 'nullable|boolean',
            ]);
            $status = $field['status'] ?? false;
            $combo = $this->comboService->updateStatusCombo($status, $id);
            return ApiResponse::success([], __('message.success.combo.created_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.combo.create_fail'), 500);
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
