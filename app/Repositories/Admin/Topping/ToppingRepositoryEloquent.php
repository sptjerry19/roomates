<?php

namespace App\Repositories\Admin\Topping;

use App\Models\Admin\Topping;
use App\Repositories\Base\BaseRepository;

class ToppingRepositoryEloquent extends BaseRepository implements ToppingRepository
{
    public function getModel(): string
    {
        return Topping::class;
    }

    public function getToppingDefault(): mixed
    {
        return $this->select()->get();
    }

    public function getToppingByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $keyword = $attributes['keyword'] ?? null;
        $productId = $attributes['product_id'] ?? null;
        $keyword = $attributes['keyword'] ?? null;
        return $this->select()->where('shop_id', $companyId)
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->when(!is_null($productId), function ($query) use ($productId) {
                return $query->whereHas('products', function ($query) use ($productId) {
                    $query->where('product_id', $productId);
                });
            })
            ->orderByDesc('created_at')
            ->paginate($limit);
    }
}
