<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Source\UpdateRequest;
use App\Http\Resources\Admin\Source\ListSourceCollection;
use App\Http\Resources\Admin\Source\SourceCollection;
use App\Http\Resources\Admin\Source\SourceValueCollection;
use App\Http\Resources\Admin\Source\SourceValueResource;
use App\Services\Admin\Source\SourceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SourceController extends Controller
{
    protected $sourceService;
    public function __construct(SourceService $sourceService)
    {
        $this->sourceService = $sourceService;
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
            $sources = $this->sourceService->getSources($params, $page, $limit);
            return ApiResponse::success(new SourceValueCollection($sources), __('message.success.source.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.source.get_list_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateRequest $request)
    {
        try {
            $params = $request->validated();
            $params['value'] = $params['value'] ?? 0;
            $source = $this->sourceService->createSourceValue($params);
            return ApiResponse::success(new SourceValueResource($source), __('message.success.source.created_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.source.created_fail'), 500);
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
            $params = $request->validated();
            $data = array_merge($params, $params['apply_hours']);
            unset($data['apply_hours']);

            $source = $this->sourceService->updateSourceValue($id, $data);
            return ApiResponse::success(new SourceValueResource($source), __('message.success.source.updated_success'));
        } catch (\Exception $e) {
            dd($e);
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.source.updated_fail'), 500);
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        try {
            $params = $request->validate([
                'status' => 'nullable|boolean',
            ]);
            $status = $params['status'] ?? false;
            $source = $this->sourceService->updateStatusSourceValue($id, $status);
            return ApiResponse::success(new SourceValueResource($source), __('message.success.source.updated_status_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.source.update_status_fail'), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function listSource()
    {
        try {
            $sources = $this->sourceService->getSourceDefault();
            return ApiResponse::success(new ListSourceCollection($sources), __('message.success.source_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.source_list_fail'), 500);
        }
    }
}
