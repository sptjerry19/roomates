<?php

namespace App\Services\Admin\Unit;

use App\Services\Base\BaseServiceInterface;

interface UnitService extends BaseServiceInterface
{
    public function getUnitDefault(): mixed;

    public function getUnits(array $attributes): mixed;

    public function createUnit(array $params): mixed;

    public function updateUnit(array $params, int $id): mixed;

    public function updateStatusUnit(int $id, ?bool $status): mixed;
}