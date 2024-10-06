<?php

namespace App\Repositories\Admin\CommodityGroup;

use App\Repositories\Base\RepositoryInterface;

interface CommodityGroupRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getCommodityGroupDefault(): mixed;

    public function getCommodityGroups(array $attributes): mixed;

    public function listCommodityGroup(): mixed;
}
