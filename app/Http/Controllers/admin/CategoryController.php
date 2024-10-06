<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Resources\Admin\Category\CategoryCollection;
use App\Http\Resources\Admin\Category\CategoryResource;
use App\Models\Admin\Category;
use App\Services\Admin\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $params = $request->validate([
                'keyword' => 'nullable|string',
            ]);
            $categories = $this->categoryService->getCategories($params);
            return ApiResponse::success(new CategoryCollection($categories), __('message.success.category_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_list_fail'), 500);
        }
    }

    public function indexActive()
    {
        try {
            $categories = $this->categoryService->getCategoriesActive();
            return ApiResponse::success($categories, __('message.success.category_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_list_fail'), 500);
        }
    }

    public function generateCode()
    {
        try {
            do {
                $code = '#TYPE-' . Common::generateCode(6);

                $codeExists = Category::query()->where('code', $code)->exists();
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
            $params = $request->validated();
            $data = [
                'company_id' => auth()->user()->company_id,
                'shop_id' => auth()->user()->shop_id,
                'name' => $params['name'],
                'code' => $params['code'],
                'user_id' => auth()->user()->id,
            ];
            $category = $this->categoryService->create($data);
            return ApiResponse::success(new CategoryResource($category), __('message.success.category_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_list_fail'), 500);
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
            $data = [
                'name' => $params['name'],
                'code' => $params['code'],
            ];
            $category = $this->categoryService->update($id, $data);
            return ApiResponse::success(new CategoryResource($category), __('message.success.category_updated_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_updated_fail'), 500);
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        try {
            $fields = $request->validate([
                'status' => 'nullable|string',
            ]);
            $data = [
                'status' => $fields['status'] === 'active' ? $fields['status'] : "no_active",
            ];
            $category = $this->categoryService->update($id, $data);
            if ($fields['status'] === 'active') {
                $products = $category->products()->where('is_product_update', false)->get();
            } else {
                $products = $category->products;
            }
            foreach ($products as $product) {
                $product->update(['status' => $fields['status']]);
            }
            return ApiResponse::success([], __('message.success.category_update_status_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_update_status_fail'), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = $this->categoryService->find($id);
            if (!$category || $category->name === 'Topping') {
                return ApiResponse::error(__('message.error.unauthorized'), 403);
            }
            $category = $this->categoryService->delete($id);
            return ApiResponse::success([], __('message.success.category_delete_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_delete_fail'), 500);
        }
    }

    public function categoryDefault()
    {
        try {
            $categories = $this->categoryService->getCategoryDefault();
            return ApiResponse::success($categories, __('message.success.category_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_list_fail'), 500);
        }
    }
}
