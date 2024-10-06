<?php

namespace App\Services\Admin\Area;

use App\Services\Base\BaseServiceInterface;

interface AreaService extends BaseServiceInterface
{
    public function getAreaDefault(): mixed;

    public function getAreas(array $attributes, ?int $page, ?int $limit): mixed;

    public function listArea(): mixed;


    public function createArea(array $params): mixed;

    public function updateArea(array $params, int $id): mixed;
    public function updateStatusArea(int $id, ?bool $status): mixed;
}
