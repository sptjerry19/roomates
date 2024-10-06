<?php

namespace App\Services\Admin\Shop;

use App\Services\Base\BaseServiceInterface;

interface ShopService extends BaseServiceInterface
{
    public function getAllShops(): mixed;

    public function createShop(array $params): mixed;
    public function updateShop(int $id, array $params): mixed;
    public function updateStatusShop(int $id, bool $status): mixed;

    public function getShops(array $attributes, ?int $page, ?int $limit): mixed;
    public function getShop(int $id): mixed;
    public function getShopsByCompany(): mixed;
    public function getStorageByCompany(?array $filter): mixed;

    public function getCardTables(array $attributes, ?int $page, ?int $limit): mixed;
}
