<?php

namespace App\Repositories\Admin\Shop;

use App\Repositories\Base\RepositoryInterface;

interface ShopRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getAllShops(): mixed;
    public function getShops(array $attributes, ?int $page, ?int $limit): mixed;

    public function getShopsByCompany(): mixed;
    public function getStorageByCompany(?array $filter): mixed;

    public function getCardTables(array $attributes, ?int $page, ?int $limit): mixed;
}
