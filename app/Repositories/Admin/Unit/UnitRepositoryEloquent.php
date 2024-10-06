<?php

namespace App\Repositories\Admin\Unit;

use App\Models\Admin\Storage\Unit;
use App\Repositories\Base\BaseRepository;

class UnitRepositoryEloquent extends BaseRepository implements UnitRepository
{
    public function getModel(): string
    {
        return Unit::class;
    }

    public function getUnitDefault(): mixed
    {
        return $this->select()->whereNull('company_id')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getUnits(array $attributes): mixed
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

    public function listUnit(): mixed
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
