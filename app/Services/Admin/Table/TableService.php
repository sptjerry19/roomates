<?php

namespace App\Services\Admin\Table;

use App\Services\Base\BaseServiceInterface;

interface TableService extends BaseServiceInterface
{
    public function getTableDefault(): mixed;

    public function getTables(array $attributes, ?int $page, ?int $limit): mixed;

    public function createTable(array $params): mixed;

    public function updateTable(int $id, array $params): mixed;
    public function updateStatusTable(int $id, ?string $status): mixed;
}
