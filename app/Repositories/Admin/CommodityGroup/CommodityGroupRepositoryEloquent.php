<?php

namespace App\Repositories\Admin\CommodityGroup;

use App\Models\Admin\Storage\CommodityGroup;
use App\Repositories\Base\BaseRepository;

class CommodityGroupRepositoryEloquent extends BaseRepository implements CommodityGroupRepository
{
    public function getModel(): string
    {
        return CommodityGroup::class;
    }

    public function getCommodityGroupDefault(): mixed
    {
        return $this->select()->whereNull('company_id')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getCommodityGroups(array $attributes): mixed
    {
        $companyId = auth()->user()->company_id;
        // $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        $status = $attributes['status'] ?? null;
        $keyword = $attributes['keyword'] ?? null;
        return $this->select()
            ->where('company_id', $companyId)
            // ->when(!is_null($shopId), function ($query) use ($shopId) {
            //     return $query->where('shop_id', $shopId);
            // })
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when(!is_null($status), function ($query) use ($status) {
                return $query->where('status', $status);
            })
            // ->whereHas('tables', function ($query) {
            //     $query->where('status', 'available');
            // })
            ->orderByDesc('created_at')
            ->get();
    }

    public function listCommodityGroup(): mixed
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
