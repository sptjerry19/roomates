<?php

namespace App\Repositories\Admin\Shop;

use App\Models\Admin\Shop;
use App\Repositories\Base\BaseRepository;

class ShopRepositoryEloquent extends BaseRepository implements ShopRepository
{
    public function getModel(): string
    {
        return Shop::class;
    }

    public function getAllShops(): mixed
    {
        return $this->select()->get();
    }

    public function getShopsByCompany(): mixed
    {
        $user = auth()->user();
        return $this->select(['id', 'name', 'adress'])->where('company_id', $user->company_id)->get();
    }

    public function getStorageByCompany(?array $filter): mixed
    {
        $keyword = $filter['keyword'] ?? null;
        $status = $filter['status'] ?? null;
        $companyId = auth()->user()->company_id;
        return $this->select(['id', 'name', 'adress', 'user_id', 'storage_code', 'status'])
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->when(!is_null($status), function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->where('company_id', $companyId)
            ->get();
    }

    public function getShops(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $keyword = $attributes['keyword'] ?? null;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        return $this->select()
            ->where('company_id', $companyId)
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->orderBy('created_at')
            ->paginate($limit);
    }

    public function getCardTables(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $keyword = $attributes['keyword'] ?? null;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        return $this->select(['id', 'name'])
            ->with(['cardTables' => function ($query) {
                $query->where('status', 'active'); // Chỉ lấy các cardTables có status = 'active'
            }])
            ->whereHas('cardTables', function ($query) {
                $query->where('status', 'active'); // Điều kiện lọc cho has()
            })
            ->where('company_id', $companyId)
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('id', $shopId);
            })
            ->orderBy('created_at')
            ->paginate($limit);
    }
}
