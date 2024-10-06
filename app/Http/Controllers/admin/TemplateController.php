<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Template\TemplateCollection;
use App\Services\Admin\Template\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
{
    protected $templateService;
    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $templates = $this->templateService->getTemplates();
            return ApiResponse::success(new TemplateCollection($templates), __('message.success.template.get_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.template.get_list_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request)
    {
        try {
            $fields = $request->validate([
                'content' => 'required|array',
                'type' => 'required|in:Bill,Report,Order,Printing,Provisional',
            ], [
                'content.required' => 'Vui lòng nhập nội dung.',
                'content.array' => 'Nội dung phải là một mảng.',
                'type.required' => 'Vui lòng chọn loại.',
                'type.in' => 'Loại không hợp lệ. Vui lòng chọn Bill, Report, Order, Printing hoặc Provisional.',
            ]);

            $templates = $this->templateService->updateTemplate($fields);
            return ApiResponse::success(($templates), __('message.success.template.updated_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.template.updated_fail'), 500);
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
