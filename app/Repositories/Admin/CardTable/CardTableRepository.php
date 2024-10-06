<?php

namespace App\Repositories\Admin\CardTable;

use App\Repositories\Base\RepositoryInterface;

interface CardTableRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getCardTableDefault(): mixed;

    public function getCardTables(array $attributes, ?int $page, ?int $limit): mixed;
}
