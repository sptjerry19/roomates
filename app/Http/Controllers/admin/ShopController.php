<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Shop\UpdateRequest;
use App\Http\Resources\Admin\Shop\ShopCollection;
use App\Http\Resources\Admin\Shop\ShopResource;
use App\Models\Admin\Voucher;
use App\Services\Admin\Shop\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    protected $shopService;
    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
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
                'category_id' => 'nullable|integer',
            ]);
            $products = $this->shopService->getShops($params, $page, $limit);
            return ApiResponse::success(new ShopCollection($products), __('message.success.shop.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.shop.get_list_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateRequest $request)
    {
        try {
            $params = $request->validated();
            $shop = $this->shopService->createShop($params);
            if (!$shop) {
                return ApiResponse::error(__('message.error.shop.created_fail'), 500);
            }
            return ApiResponse::success(new ShopResource($shop), __('message.success.shop.created_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.shop.created_fail'), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = $this->shopService->getShop($id);
            return ApiResponse::success(new ShopResource($product), __('message.success.category_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_list_fail'), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $params = $request->validated();
            $shop = $this->shopService->updateShop($id, $params);
            if (!$shop) {
                return ApiResponse::error(__('message.error.shop.updated_fail'), 500);
            }
            return ApiResponse::success(new ShopResource($shop), __('message.success.shop.updated_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.shop.updated_fail'), 500);
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        try {
            $params = $request->validate([
                'status' => 'nullable|boolean'
            ]);
            $status = $params['status'] ?? false;
            $shop = $this->shopService->updateStatusShop($id, $status);
            if (!$shop) {
                return ApiResponse::error(__('message.error.shop.updated_fail'), 500);
            }
            return ApiResponse::success(new ShopResource($shop), __('message.success.shop.updated_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.shop.updated_fail'), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyVoucher(Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validate([
                'vouchers' => 'required|array',
                'vouchers.*' => 'required|integer',
            ]);
            $vouchers = $params['vouchers'];
            foreach ($vouchers as $voucher) {
                $voucherOld = Voucher::query()->findOrFail($voucher);
                $voucherOld->delete();
            }
            DB::commit();
            return ApiResponse::success([], __('message.success.shop.updated_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.shop.updated_fail'), 500);
        }
    }

    public function listShop()
    {
        $shops = $this->shopService->getShopsByCompany();
        return ApiResponse::success(($shops), __('message.success.shop_fetched'));
    }

    public function storage(Request $request)
    {
        try {
            $field = $request->validate([
                'status' => 'nullable|string',
                'keyword' => 'nullable|string',
            ]);
            $shops = $this->shopService->getStorageByCompany($field);
            foreach ($shops as $shop) {
                $shop['user'] = $shop->user;
            }
            return ApiResponse::success(($shops), __('message.storage.shop.getlist_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.storage.shop.getlist_fail'), 500);
        }
    }
}
