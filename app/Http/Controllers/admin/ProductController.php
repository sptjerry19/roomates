<?php

namespace App\Http\Controllers\admin;

use App\Helpers\ApiResponse;
use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CostProductRequest;
use App\Http\Requests\Admin\Product\StoreComboRequest;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Resources\Admin\Product\CostProductCollection;
use App\Http\Resources\Admin\Product\CostProductResource;
use App\Http\Resources\Admin\Product\DropdownCollection;
use App\Http\Resources\Admin\Product\DropdownResource;
use App\Http\Resources\Admin\Product\ProductCollection;
use App\Http\Resources\Admin\Product\ProductResource;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Services\Admin\Category\CategoryService;
use App\Services\Admin\Combo\ComboService;
use App\Services\Admin\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $comboService;
    public function __construct(ProductService $productService, CategoryService $categoryService, ComboService $comboService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
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
                'category_id' => 'nullable|integer',
            ]);
            $products = $this->productService->getProductByCompany($params, $page, $limit);
            return ApiResponse::success(new ProductCollection($products), __('message.success.category_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_list_fail'), 500);
        }
    }

    public function listProducts(Request $request)
    {
        try {
            $page = $request->input('page');
            $limit = $request->input('limit', config('constant.PAGINATION'));
            $params = $request->validate([
                'keyword' => 'nullable|string',
                'category_id' => 'nullable|integer',
            ]);
            $products = $this->productService->listProducts($params, $page, $limit);
            foreach ($products as $product) {
                $product->price = (int) $product->price;
            }
            return ApiResponse::success($products, __('message.success.category_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_list_fail'), 500);
        }
    }

    public function productDefault()
    {
        try {
            $products = $this->productService->getProductDefault();
            return ApiResponse::success($products, __('message.success.category_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_list_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $params = $request->validated();
            $product = $this->productService->createProduct($params);
            if (!$product) {
                return ApiResponse::error(__('message.error.product_create_fail'), 500);
            }
            return ApiResponse::success(new ProductResource($product), __('message.success.product_create_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.product_create_fail'), 500);
        }
    }

    public function createTopping(StoreRequest $request)
    {
        try {
            $params = $request->validated();
            $product = $this->productService->createTopping($params);
            if (!$product) {
                return ApiResponse::error(__('message.error.product_create_fail'), 500);
            }
            return ApiResponse::success(new ProductResource($product), __('message.success.product_create_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.product_create_fail'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCombo(StoreComboRequest $request)
    {
        try {
            $params = $request->validated();
            $params['is_create_combo'] = true;
            $product = $this->productService->createProduct($params);
            if (!$product) {
                return ApiResponse::error(__('message.error.product_create_fail'), 500);
            }
            return ApiResponse::success(new ProductResource($product), __('message.success.product_create_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.product_create_fail'), 500);
        }
    }

    public function generateCode()
    {
        try {
            do {
                $code = '#FD-' . Common::generateCode(6);

                $codeExists = Product::query()->where('product_code', $code)->exists();
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

    public function dropdown(Request $request)
    {
        try {
            $page = $request->input('page');
            $limit = $request->input('limit', config('constant.PAGINATION'));
            $params = $request->validate([
                'keyword' => 'nullable|string',
                'category_id' => 'nullable|integer',
            ]);

            $data = [];

            $products = $this->productService->listProducts($params, $page, $limit);
            // foreach ($products as $product) {
            //     $product->price = (int) $product->price;
            // }

            $categories = $this->categoryService->getCategoriesActive();

            $combos = $this->comboService->listComboByCompany($params, $page, $limit);

            $data['products'] = $products;
            $data['categories'] = $categories;
            $data['combos'] = $combos;

            return ApiResponse::success(new DropdownResource($data), __('message.success.generate_code'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.generate_code'), 500);
        }
    }

    public function generateCodeCombo()
    {
        try {
            do {
                $code = '#CB-' . Common::generateCode(6);

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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = $this->productService->find($id);
            if (!$product) {
                return ApiResponse::error(__('message.error.product_update_fail'), 500);
            }
            return ApiResponse::success(new ProductResource($product), __('message.success.product_update_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.product_update_fail'), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        try {
            $params = $request->validated();
            $product = $this->productService->updateProduct($id, $params);
            if (!$product) {
                return ApiResponse::error(__('message.error.product_update_fail'), 500);
            }
            return ApiResponse::success(new ProductResource($product), __('message.success.product_update_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.product_update_fail'), 500);
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
                'is_product_update' =>  true,
            ];
            $product = $this->productService->update($id, $data);
            return ApiResponse::success([], __('message.success.product_update_status_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.product_update_status_fail'), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = $this->productService->find($id);
            if (!$product) {
                return ApiResponse::error(__('message.error.not_found'), 404);
            } elseif ($product->category->name === 'Topping') {
                return ApiResponse::error(__('message.error.unauthorized'), 403);
            }
            $product = $this->productService->delete($id);
            return ApiResponse::success([], __('message.success.product_delete_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.product_delete_fail'), 500);
        }
    }


    public function getCost(Request $request)
    {
        try {
            $page = $request->input('page');
            $limit = $request->input('limit', config('constant.PAGINATION'));
            $params = $request->validate([
                'keyword' => 'nullable|string',
                'status' => 'nullable|string',
            ]);
            $products = $this->productService->getProductByCompany($params, $page, $limit);
            return ApiResponse::success(new CostProductCollection($products), __('message.success.category_list_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.category_list_fail'), 500);
        }
    }


    public function createCost(CostProductRequest $request)
    {
        try {
            $params = $request->validated();
            $costProduct = $this->productService->createCostProduct($params);
            if (!$costProduct) {
                return ApiResponse::error(__('message.error.product_create_fail'), 500);
            }
            return ApiResponse::success(new CostProductResource($costProduct), __('message.success.product_create_success'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('message.error.product_create_fail'), 500);
        }
    }
}
