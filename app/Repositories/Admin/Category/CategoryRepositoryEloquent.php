<?php

namespace App\Repositories\Admin\Category;

use App\Models\Admin\Category;
use App\Repositories\Base\BaseRepository;

class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    public function getModel(): string
    {
        return Category::class;
    }

    public function getCategoryDefault(): mixed
    {
        return $this->select()->whereNull('company_id')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getCategories(?array $params): mixed
    {
        $keyword = $params['keyword'] ?? null;
        $companyId = auth()->user()->company_id;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        return $this->select()
            ->where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('created_at')
            ->get();
    }

    public function getCategoriesActive(): mixed
    {
        $companyId = auth()->user()->company_id;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        return $this->select(['id', 'name', 'code'])->where('status', 'active')
            ->where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->orderByDesc('created_at')
            ->get();
    }
}