<?php

namespace App\Repositories\Admin\Area;

use App\Models\Admin\Area;
use App\Repositories\Base\BaseRepository;

class AreaRepositoryEloquent extends BaseRepository implements AreaRepository
{
    public function getModel(): string
    {
        return Area::class;
    }

    public function getAreaDefault(): mixed
    {
        return $this->select()->whereNull('company_id')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getAreas(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        $keyword = $attributes['keyword'] ?? null;
        return $this->select()
            ->where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            // ->whereHas('tables', function ($query) {
            //     $query->where('status', 'available');
            // })
            ->orderByDesc('created_at')
            ->get();
    }

    public function listArea(): mixed
    {
        $companyId = auth()->user()->company_id;
        $shopId = auth()->user()->shop_id;
        return $this->select(['id', 'name', 'shop_id'])->where('status', true)
            ->where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->orderBy('stt')
            ->get();
    }
}
