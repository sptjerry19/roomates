<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Option\CreateRequest;
use App\Http\Requests\Admin\Option\UpdateRequest;
use App\Http\Resources\Admin\Option\ListOptionCollection;
use App\Http\Resources\Admin\Option\OptionCollection;
use App\Models\Admin\Option;
use App\Services\Admin\Option\OptionService;
use App\Services\Admin\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OptionController extends Controller
{
    protected $optionService;
    public function __construct(OptionService $optionService)
    {
        $this->optionService = $optionService;
    }
    public function getList(Request $request)
    {
        try {
            $page = $request->input('page');
            $limit = $request->input('limit', config('constant.PAGINATION'));
            $params = $request->validate([
                'keyword' => 'nullable|string',
                'product_id' => 'nullable|integer',
                'shop_id' => 'nullable|integer',
            ]);
            $data = $this->optionService->getOptionByCompany($params, $page, $limit);
            if (!$data) {
                return ApiResponse::error('message.error.option.get_list_fail', 404);
            }
            return ApiResponse::success(new OptionCollection($data), __('message.success.option.get_list_success'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('message.error.option.get_list_fail', 500);
        }
    }

    public function getListAll(Request $request)
    {
        try {
            $page = $request->input('page');
            $limit = $request->input('limit', config('constant.PAGINATION'));
            $params = $request->validate([
                'keyword' => 'nullable|string',
                'product_id' => 'nullable|integer',
                'shop_id' => 'nullable|integer',
            ]);
            $data = $this->optionService->getAllOptionByCompany($params, $page, $limit);
            if (!$data) {
                return ApiResponse::error('message.error.option.get_list_fail', 404);
            }
            return ApiResponse::success(new OptionCollection($data), __('message.success.option.get_list_success'));
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('message.error.option.get_list_fail', 500);
        }
    }

    public function create(CreateRequest $request)
    {
        try {
            $params = $request->validated();

            $option = $this->optionService->createOption($params);

            return ApiResponse::success($option, __('message.success.option.created_success'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.option.created_fail', 500);
        }
    }

    public function updateOption(UpdateRequest $request, $id)
    {
        try {
            $params = $request->validated();

            $option = $this->optionService->updateOption($params, $id);

            return ApiResponse::success($option, __('message.success.option.updated_success'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.option.updated_fail', 500);
        }
    }

    public function updateStatusOption(Request $request, $id)
    {
        try {
            $params = $request->validate([
                'status' => 'nullable|boolean',
            ]);

            $status = $params['status'] ?? false;

            $option = $this->optionService->updateStatusOption($status, $id);

            return ApiResponse::success([], __('message.success.option.update_status_success'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.option.update_status_fail', 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $option = Option::find($id);

            if (!$option) {
                return ApiResponse::error("message.error.not_found", 404);
            }
            $option->optionsAttrs()->delete();
            $option->delete();

            DB::commit();
            return ApiResponse::success($option, __('message.success.option.deleted_success'));
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.option.deleted_fail', 500);
        }
    }

    public function destroyOptionValue($id)
    {
        try {
            $option = $this->optionService->deleteOptrionAttr($id);

            if (!$option) {
                return ApiResponse::error("message.error.not_found", 404);
            }

            return ApiResponse::success([], __('message.success.option.deleted_success'));
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            return ApiResponse::error('message.error.option.deleted_fail', 500);
        }
    }
}
