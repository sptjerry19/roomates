<?php

namespace App\Repositories\Admin\CardTable;

use App\Models\Admin\CardTable;
use App\Repositories\Base\BaseRepository;

class CardTableRepositoryEloquent extends BaseRepository implements CardTableRepository
{
    public function getModel(): string
    {
        return CardTable::class;
    }

    public function getCardTableDefault(): mixed
    {
        return $this->select()->whereNull('company_id')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getCardTables(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $keyword = $attributes['keyword'] ?? null;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        return $this->select()
            ->where('company_id', $companyId)
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('Cardtable_number', 'LIKE', '%' . $keyword . '%');
            })
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->orderBy('created_at')
            ->paginate($limit);
    }
}
