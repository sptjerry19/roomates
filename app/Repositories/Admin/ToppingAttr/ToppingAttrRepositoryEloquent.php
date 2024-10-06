<?php

namespace App\Repositories\Admin\ToppingAttr;

use App\Models\Admin\Product;
use App\Repositories\Base\BaseRepository;

class ToppingAttrRepositoryEloquent extends BaseRepository implements ToppingAttrRepository
{
    public function getModel(): string
    {
        return Product::class;
    }

    public function getToppingAttrDefault(): mixed
    {
        $companyId = auth()->user()->company_id;
        return $this->select()->where('company_id', $companyId)
            ->whereHas('category', function ($query) {
                $query->where('name', 'Topping');
            })->get();
    }

    public function getToppingAttrByCompany(array $params): mixed
    {
        $companyId = auth()->user()->company_id;
        $keyword = $params['keyword'] ?? null;
        $shopId = $params['shop_id'] ?? auth()->user()->shop_id ?? null;
        $productId = $params['product_id'] ?? null;
        return $this->select(['id', 'name', 'price'])
            ->where('company_id', $companyId)
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->whereHas('product', function ($query) use ($shopId) {
                    $query->where('shop_id', $shopId);
                });
            })
            ->whereHas('category', function ($query) {
                $query->where('name', 'Topping');
            })
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }
}
