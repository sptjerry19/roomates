<?php

namespace App\Services\Admin\CardTable;

use App\Services\Base\BaseServiceInterface;

interface CardTableService extends BaseServiceInterface
{
    public function getCardTableDefault(): mixed;

    public function getCardTables(array $attributes, ?int $page, ?int $limit): mixed;

    public function createCardTable(array $params): mixed;

    public function updateCardTable(int $shopId, array $params): mixed;
    public function updateStatusCardTable(int $id, ?string $status): mixed;
}
