<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Promotion\StoreRequest;
use App\Http\Resources\Admin\Promotion\PromotionCollection;
use App\Http\Resources\Admin\Promotion\PromotionResource;
use App\Services\Admin\Promotion\PromotionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PromotionController extends Controller
{
    protected $promotionService;
    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
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
            $promotions = $this->promotionService->getPromotionByCompany($params, $page, $limit);
            return ApiResponse::success(new PromotionCollection($promotions), __('message.success.promotion.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.promotion.get_list_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $fields = $request->validated();
            $promotion = $this->promotionService->createPromotion($fields);
            return ApiResponse::success(new PromotionResource($promotion), __('message.success.promotion.created_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.promotion.create_fail'), 500);
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
    public function update(StoreRequest $request, string $id)
    {
        try {
            $fields = $request->validated();
            $promotion = $this->promotionService->updatePromotion($fields, $id);
            return ApiResponse::success(new PromotionResource($promotion), __('message.success.promotion.updated_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.promotion.updated_fail'), 500);
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        try {
            $field = $request->validate([
                'status' => 'nullable|string',
            ]);
            $status = $field['status'] ?? 'inactive';
            $promotion = $this->promotionService->updateStatusPromotion($status, $id);
            return ApiResponse::success([], __('message.success.promotion.update_status_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.promotion.update_status_fail'), 500);
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
