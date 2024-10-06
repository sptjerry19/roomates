<?php

namespace App\Repositories\Admin\Unit;

use App\Repositories\Base\RepositoryInterface;

interface UnitRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getUnitDefault(): mixed;

    public function getUnits(array $attributes): mixed;

    public function listUnit(): mixed;
}