<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Option\CreateRequest;
use App\Http\Requests\Admin\Topping\StoreRequest;
use App\Http\Resources\Admin\Topping\ToppingCollection;
use App\Http\Resources\Admin\Topping\ToppingResource;
use App\Services\Admin\Topping\ToppingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ToppingController extends Controller
{
    protected $toppingService;
    public function __construct(ToppingService $toppingService)
    {
        $this->toppingService = $toppingService;
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
                'product_id' => 'nullable|integer',
            ]);
            $data = $this->toppingService->getToppingByCompany($params, $page, $limit);
            if (!$data) {
                return ApiResponse::error('message.error.topping.get_list_fail', 404);
            }
            return ApiResponse::success(new ToppingCollection($data), __('message.success.topping.get_list_success'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('message.error.topping.get_list_fail', 500);
        }
    }

    public function listTopping(Request $request)
    {
        try {
            $params = $request->validate([
                'keyword' => 'nullable|string',
                'shop_id' => 'nullable|integer',
                'product_id' => 'nullable|integer',
            ]);
            $data = $this->toppingService->listTopping($params);
            if (!$data) {
                return ApiResponse::error('message.error.topping.get_list_fail', 404);
            }
            foreach ($data as $item) {
                $item->price = (int) $item->price;
            }
            return ApiResponse::success(($data), __('message.success.topping.get_list_success'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('message.error.topping.get_list_fail', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $params = $request->validated();

            $topping = $this->toppingService->createTopping($params);

            return ApiResponse::success(new ToppingResource($topping), __('message.success.topping.created_success'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.topping.created_fail', 500);
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
            $params = $request->validated();

            $topping = $this->toppingService->updateTopping($params, $id);

            return ApiResponse::success(new ToppingResource($topping), __('message.success.topping.updated_success'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.topping.updated_fail', 500);
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        try {
            $params = $request->validate([
                'status' => 'nullable|string'
            ]);

            $status = $params['status'] ?? 'no_active';

            $topping = $this->toppingService->updateStatusTopping($status, $id);

            return ApiResponse::success([], __('message.success.topping.update_status_success'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.topping.update_status_fail', 500);
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
