<?php

namespace App\Repositories\Admin\Table;

use App\Repositories\Base\RepositoryInterface;

interface TableRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getTableDefault(): mixed;

    public function getTables(array $attributes, ?int $page, ?int $limit): mixed;
}
