<?php

namespace App\Repositories\Admin\SourceValue;

use App\Models\Admin\SourceValue;
use App\Repositories\Base\BaseRepository;

class SourceValueRepositoryEloquent extends BaseRepository implements SourceValueRepository
{
    public function getModel(): string
    {
        return SourceValue::class;
    }

    public function getSources(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        $keyword = $attributes['keyword'] ?? null;
        return $this->select()->where('company_id', $companyId)
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->whereHas('source', function ($query) use ($keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->orderByDesc('created_at')
            ->paginate($limit);
    }
}
