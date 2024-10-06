<?php

namespace App\Services\Admin\CommodityGroup;

use App\Services\Base\BaseServiceInterface;

interface CommodityGroupService extends BaseServiceInterface
{
    public function getCommodityGroupDefault(): mixed;

    public function getCommodityGroups(array $attributes): mixed;

    public function createCommodityGroup(array $params): mixed;

    public function updateCommodityGroup(array $params, int $id): mixed;

    public function updateStatusCommodityGroup(int $id, ?bool $status): mixed;
}
