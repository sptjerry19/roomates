<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Table\StoreRequest;
use App\Http\Resources\Admin\Table\TableCollection;
use App\Http\Resources\Admin\Table\TableResource;
use App\Services\Admin\Table\TableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
{
    protected $tableService;
    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
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
                'area_id' => 'nullable|integer',
                'table_type' => 'nullable|string',
            ]);
            $table = $this->tableService->getTables($params, $page, $limit);
            return ApiResponse::success(new TableCollection($table), __('message.success.table.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.table.get_list_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $fields = $request->validated();

            $table = $this->tableService->createTable($fields);
            return ApiResponse::success(new TableResource($table), __('message.success.table.created_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.table.created_fail'), 500);
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

            $table = $this->tableService->updateTable($id, $fields);
            return ApiResponse::success(new TableResource($table), __('message.success.table.updated_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.table.updated_fail'), 500);
        }
    }

    /**
     * Update status the specified resource in storage.
     */
    public function updateStatusTable(Request $request, string $id)
    {
        try {
            $field = $request->validate([
                'status' => 'nullable|string|in:available,reserved,unpaid,locked',
            ]);

            $status = $field['status'] ?? 'locked';

            $table = $this->tableService->updateStatusTable($id, $status);
            return ApiResponse::success(new TableResource($table), __('message.success.table.updated_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.table.updated_fail'), 500);
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
