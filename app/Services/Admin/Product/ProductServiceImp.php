<?php

namespace App\Services\Admin\Product;

use App\Helpers\Common;
use App\Models\Admin\Category;
use App\Models\Admin\ToppingAttr;
use App\Models\Admin\UnitType;
use App\Repositories\Admin\Product\ProductRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductServiceImp extends BaseServiceImp implements ProductService
{
    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    public function getProductDefault(): mixed
    {
        return $this->repository->getProductDefault();
    }

    public function getCategories(): mixed
    {
        return $this->repository->getCategories();
    }

    public function getProductByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->getProducts($attributes, $page, $limit);
    }

    public function listProducts(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->listProducts($attributes, $page, $limit);
    }

    public function createProduct(array $params): mixed
    {
        try {
            DB::beginTransaction();
            $isCreateCombo = $params['is_create_combo'] ?? false;
            // $unitData = UnitType::query()->where('id', $params['unit_type'])->first();
            // $unitName = $unitData->name;
            $image = isset($params['image']) ?  Common::uploadbase64Image($params['image'], 'Product/image/') : null;
            if ($isCreateCombo) {
                $categoryCombo = Category::query()->where('company_id', auth()->user()->company_id)->where('name', 'Combo')->first();
                if (!$categoryCombo) {
                    do {
                        $code = '#CB-' . Common::generateCode(6);

                        $codeCategory = Category::query()->where('code', $code)->exists();
                    } while ($codeCategory);
                    $categoryCombo = Category::create([
                        'company_id' => auth()->user()->company_id,
                        'name' => 'Combo',
                        'code' => $code,
                        'user_id' => auth()->user()->id
                    ]);
                }
            }
            $data = [
                'company_id' => auth()->user()->company_id,
                'name' => $params['name'],
                'product_code' => $params['code'],
                'price' => $params['price'],
                'unit_name' => $params['unit_name'] ?? 'Số lượng',
                'unit_type' => $params['unit_type'] ?? 'Suất',
                'vat_fee' => $params['vat_fee'] ?? null,
                'image' => $image,
                'description' => $params['description'] ?? null,
                'user_id' => auth()->user()->id,
                'shop_id' => 1,
                'category_id' => $params['category_id'] ?? null,
            ];

            if ($isCreateCombo) {
                $data['category_id'] = $categoryCombo->id;
            }

            $product = $this->repository->createProduct($data);

            // Sử dụng relations để thêm dữ liệu vào bảng pivot product_source
            $sources = $params['sources'] ?? null;
            if (!is_null($sources)) {
                foreach ($sources as $source) {
                    $pivotData = [
                        'price' => $source['price'] ?? 0,
                    ];

                    $product->sources()->attach($source['id'], $pivotData);
                }
            }

            // Sử dụng relations để thêm dữ liệu vào bảng pivot product_shop
            $shops = $params['shop_id'] ?? null;
            if (!is_null($shops)) {
                if (is_array($shops)) {
                    $product->shops()->attach($shops);
                } else {
                    $product->shops()->attach([$shops]);
                }
            }

            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function createTopping(array $params): mixed
    {
        try {
            DB::beginTransaction();
            $categoryTopping = Category::query()->where('company_id', auth()->user()->company_id)->where('name', 'Topping')->first();
            if (!$categoryTopping) {
                if (!$categoryTopping) {
                    do {
                        $code = '#TYPE-' . Common::generateCode(6);

                        $codeCategory = Category::query()->where('code', $code)->exists();
                    } while ($codeCategory);
                    $categoryTopping = Category::create([
                        'company_id' => auth()->user()->company_id,
                        'name' => 'Topping',
                        'code' => $code,
                        'user_id' => auth()->user()->id
                    ]);
                }
            }
            $image = isset($params['image']) ?  Common::uploadbase64Image($params['image'], 'Product/image/') : null;
            $data = [
                'company_id' => auth()->user()->company_id,
                'name' => $params['name'],
                'product_code' => $params['code'],
                'price' => $params['price'],
                'unit_name' => $params['unit_name'] ?? 'Số lượng',
                'unit_type' => $params['unit_type'] ?? 'Suất',
                'image' => $image,
                'user_id' => auth()->user()->id,
                'shop_id' => 1,
                'category_id' => $categoryTopping->id ?? null,
            ];

            $product = $this->repository->createProduct($data);

            $toppingAttr = ToppingAttr::create([
                'name' => $params['name'],
                'price' => $params['price'],
                'image' => $image,
                'product_id' => $product->id,
                'topping_id' => 0,
            ]);

            // Sử dụng relations để thêm dữ liệu vào bảng pivot product_source
            $sources = $params['source_id'] ?? null;
            if (!is_null($sources)) {
                if (is_array($sources)) {
                    $product->sources()->attach($sources);
                } else {
                    $product->sources()->attach([$sources]);
                }
            }

            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateProduct(string $id, array $params): mixed
    {
        try {
            DB::beginTransaction();

            $product = $this->repository->findOrFail($id);
            $oldImagePath = $product->image;

            $image = null; // Đặt giá trị mặc định là null
            if (array_key_exists('image', $params)) {
                $image = Common::updateProductImage($params['image'], $oldImagePath, 'Product/image/');
            }

            $data = [
                'company_id' => auth()->user()->company_id,
                'name' => $params['name'],
                'product_code' => $params['code'],
                'price' => $params['price'],
                'unit_name' => $params['unit_name'] ?? 'Số lượng', // Giá trị mặc định
                'unit_type' => $params['unit_type'] ?? 'Suất', // Giá trị mặc định
                'vat_fee' => $params['vat_fee'] ?? 0, // Giá trị mặc định
                'description' => $params['description'] ?? null, // Giá trị mặc định là null
                'user_id' => auth()->user()->id,
                'shop_id' => 1, // Giá trị cố định
                'category_id' => $params['category_id'] ?? null, // Giá trị mặc định là null
            ];

            if (!is_null($image)) {
                $data['image'] = $image;
            } elseif (array_key_exists('image', $params) && is_null($params['image'])) {
                $data['image'] = null; // Xóa ảnh nếu không có ảnh mới và 'image' trong params là null
            }

            $product = $this->repository->update($id, $data);

            $sources = $params['sources'] ?? null;
            if (!is_null($sources)) {
                $syncData = [];
                foreach ($sources as $source) {
                    $syncData[$source['id']] = [
                        'price' => $source['price'] ?? 0,
                    ];
                }
                $product->sources()->sync($syncData);
            }

            $shops = $params['shop_id'] ?? null;
            if (!is_null($shops)) {
                if (is_array($shops)) {
                    $product->shops()->sync($shops);
                } else {
                    $product->shops()->sync([$shops]);
                }
            }
            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function createCostProduct(array $params): mixed
    {
        try {
            DB::beginTransaction();

            $product = parent::find($params['product_id']);

            if (isset($params['merchandises']) && is_array($params['merchandises'])) {
                foreach ($params['merchandises'] as $merchandise) {
                    // Chuẩn bị dữ liệu cho bảng pivot
                    $pivotData = [
                        'option' => $params['option'],
                        'quantity' => $merchandise['quantity'],
                        'expense' => $merchandise['expense'],
                    ];

                    // Liên kết sản phẩm với combo qua bảng pivot combo_product
                    $product->merchandises()->attach($merchandise['merchandise_id'], $pivotData);
                }
            }

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
}
