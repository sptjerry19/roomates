<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CardTable\StoreRequest;
use App\Http\Requests\Admin\CardTable\UpdateRequest;
use App\Http\Resources\Admin\CardTable\CardTableCollection;
use App\Http\Resources\Admin\CardTable\CardTableResource;
use App\Services\Admin\CardTable\CardTableService;
use App\Services\Admin\Shop\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CardTableController extends Controller
{
    protected $cardTableService;
    protected $shopService;
    public function __construct(CardTableService $cardTableService, ShopService $shopService)
    {
        $this->cardTableService = $cardTableService;
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
                'shop_id' => 'nullable|integer',
            ]);
            $cardTable = $this->shopService->getCardTables($params, $page, $limit);
            return ApiResponse::success(new CardTableCollection($cardTable), __('message.success.card_table.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.card_table.get_list_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $fields = $request->validated();
            $cardTable = $this->cardTableService->createCardTable($fields);
            return ApiResponse::success(new CardTableResource($cardTable), __('message.success.card_table.created_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.card_table.created_fail'), 500);
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
            $cardTable = $this->cardTableService->updateCardTable($id, $fields);
            return ApiResponse::success(new CardTableResource($cardTable), __('message.success.card_table.updated_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.card_table.updated_fail'), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteCardTable(string $id)
    {
        try {
            $cardTable = $this->cardTableService->delete($id);
            return ApiResponse::success([], __('message.success.card_table.deleted_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.card_table.deleted_fail'), 500);
        }
    }
}
