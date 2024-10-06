<?php

namespace App\Repositories\Admin\Merchandise;

use App\Repositories\Base\RepositoryInterface;

interface MerchandiseRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getMerchandiseDefault(): mixed;

    public function getMerchandises(array $attributes, ?int $page, ?int $limit): mixed;

    public function listMerchandise(): mixed;
}
