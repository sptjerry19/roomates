<?php

namespace App\Repositories\Admin\Promotion;

use App\Models\Admin\Promotion;
use App\Repositories\Base\BaseRepository;

class PromotionRepositoryEloquent extends BaseRepository implements PromotionRepository
{
    public function getModel(): string
    {
        return Promotion::class;
    }

    public function getPromotionDefault(): mixed
    {
        return $this->select()->get();
    }

    public function getPromotionByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $keyword = $attributes['keyword'] ?? null;
        $shopId = $attributes['shop_id'] ?? null;
        return $this->select()->where('company_id', $companyId)
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                // Sử dụng whereHas để lọc theo các shop liên kết
                return $query->whereHas('shops', function ($query) use ($shopId) {
                    $query->where('shop_id', $shopId);
                });
            })
            ->orderByDesc('created_at')
            ->paginate($limit);
    }
}
