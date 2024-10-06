<?php

namespace App\Services\Admin\Merchandise;

use App\Services\Base\BaseServiceInterface;

interface MerchandiseService extends BaseServiceInterface
{
    public function getMerchandiseDefault(): mixed;

    public function getMerchandises(array $attributes, ?int $page, ?int $limit): mixed;

    public function createMerchandise(array $params): mixed;

    public function updateMerchandise(array $params, int $id): mixed;

    public function updateStatusMerchandise(int $id, ?bool $status): mixed;
}
