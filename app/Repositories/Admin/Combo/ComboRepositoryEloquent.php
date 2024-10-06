<?php

namespace App\Repositories\Admin\Combo;

use App\Models\Admin\Combo;
use App\Repositories\Base\BaseRepository;

class ComboRepositoryEloquent extends BaseRepository implements ComboRepository
{
    public function getModel(): string
    {
        return Combo::class;
    }

    public function getComboDefault(): mixed
    {
        return $this->select()->get();
    }

    public function getComboByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        return $this->select()
            ->where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->when(isset($attributes['keyword']), function ($query) use ($attributes) {
                return $query->where('name', 'LIKE', '%' . $attributes['keyword'] . '%');
            })
            ->orderByDesc('created_at')
            ->paginate($limit);
    }

    public function listComboByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        return $this->select()
            ->where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->when(isset($attributes['keyword']), function ($query) use ($attributes) {
                return $query->where('name', 'LIKE', '%' . $attributes['keyword'] . '%');
            })
            ->orderByDesc('created_at')
            ->get();
    }
}
