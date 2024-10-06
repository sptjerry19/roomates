<?php

namespace App\Repositories\Admin\Area;

use App\Repositories\Base\RepositoryInterface;

interface AreaRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getAreaDefault(): mixed;

    public function getAreas(array $attributes, ?int $page, ?int $limit): mixed;

    public function listArea(): mixed;
}
