<?php

namespace App\Repositories\Admin\Merchandise;

use App\Models\Admin\Storage\Merchandise;
use App\Repositories\Base\BaseRepository;

class MerchandiseRepositoryEloquent extends BaseRepository implements MerchandiseRepository
{
    public function getModel(): string
    {
        return Merchandise::class;
    }

    public function getMerchandiseDefault(): mixed
    {
        return $this->select()->whereNull('company_id')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getMerchandises(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $storageId = $attributes['storage_id'] ?? null;
        $commodityId = $attributes['commodity_id'] ?? null;
        $status = $attributes['status'] ?? null;
        $keyword = $attributes['keyword'] ?? null;
        return $this->select()
            ->where('company_id', $companyId)
            ->when(!is_null($storageId), function ($query) use ($storageId) {
                return $query->where('shop_id', $storageId);
            })
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when(!is_null($status), function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when(!is_null($commodityId), function ($query) use ($commodityId) {
                return $query->where('commodity_id', $commodityId);
            })
            // ->whereHas('tables', function ($query) {
            //     $query->where('status', 'available');
            // })
            ->orderByDesc('created_at')
            ->paginate($limit);
    }

    public function listMerchandise(): mixed
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
