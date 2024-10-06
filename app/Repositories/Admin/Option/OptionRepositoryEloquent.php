<?php

namespace App\Repositories\Admin\Option;

use App\Models\Admin\Option;
use App\Repositories\Base\BaseRepository;

class OptionRepositoryEloquent extends BaseRepository implements OptionRepository
{
    public function getModel(): string
    {
        return Option::class;
    }

    public function getOptionDefault(): mixed
    {
        return $this->select()->get();
    }

    public function getOptionByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $keyword = $attributes['keyword'] ?? null;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        $productId = $attributes['product_id'] ?? null;
        return $this->select()->where('shop_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->when(!is_null($productId), function ($query) use ($productId) {
                return $query->whereHas('products', function ($query) use ($productId) {
                    $query->where('product_id', $productId);
                });
            })
            ->when(isset($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->orderByDesc('created_at')
            ->paginate($limit);
    }

    public function getAllOptionByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $keyword = $attributes['keyword'] ?? null;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        $productId = $attributes['product_id'] ?? null;
        return $this->select(['id', 'name', 'status'])->where('shop_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->when(!is_null($productId), function ($query) use ($productId) {
                return $query->whereHas('products', function ($query) use ($productId) {
                    $query->where('product_id', $productId);
                });
            })
            ->when(isset($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->orderByDesc('created_at')
            ->get();
    }
}
