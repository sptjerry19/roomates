<?php

namespace App\Services\Admin\Topping;

use App\Services\Base\BaseServiceInterface;

interface ToppingService extends BaseServiceInterface
{
    public function getToppingDefault(): mixed;

    public function getToppingByCompany(array $attributes, ?int $page, ?int $limit): mixed;
    public function listTopping(array $params): mixed;

    public function createTopping(array $params): mixed;

    public function updateTopping(array $params, int $id): mixed;
    public function updateStatusTopping(string $status, int $id): mixed;

    public function deleteOptrionAttr(int $id): mixed;
}
