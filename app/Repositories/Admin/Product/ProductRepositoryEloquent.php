<?php

namespace App\Repositories\Admin\Product;

use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Repositories\Base\BaseRepository;

class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    public function getModel(): string
    {
        return Product::class;
    }

    public function getProductDefault(): mixed
    {
        return $this->select()->whereNull('company_id')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getProducts(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        return $this->select()
            ->with('category', 'shops', 'sources')
            ->where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->when(isset($attributes['keyword']), function ($query) use ($attributes) {
                return $query->where('name', 'LIKE', '%' . $attributes['keyword'] . '%');
            })
            ->when(isset($attributes['category_id']), function ($query) use ($attributes) {
                return $query->where('category_id', $attributes['category_id']);
            })
            ->orderByDesc('created_at')
            ->paginate($limit);
    }

    public function listProducts(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        $categoryTopping = Category::where('company_id', $companyId)->where('name', 'Topping')->first();
        return $this->select(['id', 'name', 'product_code', 'price'])
            ->with('category', 'shops', 'sources')
            ->where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->when(isset($attributes['keyword']), function ($query) use ($attributes) {
                return $query->where('name', 'LIKE', '%' . $attributes['keyword'] . '%');
            })
            ->when(isset($attributes['category_id']), function ($query) use ($attributes) {
                return $query->where('category_id', $attributes['category_id']);
            })
            ->when(!is_null($categoryTopping), function ($query) use ($categoryTopping) {
                return $query->where('category_id', '!=', $categoryTopping->id);
            })
            ->orderByDesc('created_at')
            ->where('status', 'active')
            ->get();
    }

    public function createProduct(array $attributes): mixed
    {
        return $this->_model->create($attributes);
    }
}
