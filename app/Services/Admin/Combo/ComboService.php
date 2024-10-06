<?php

namespace App\Services\Admin\Combo;

use App\Services\Base\BaseServiceInterface;

interface ComboService extends BaseServiceInterface
{
    public function getCombos(): mixed;

    public function getComboByCompany(array $attributes, ?int $page, ?int $limit): mixed;
    public function listComboByCompany(array $attributes, ?int $page, ?int $limit): mixed;

    public function createCombo(array $params): mixed;

    public function updateCombo(array $params, int $id): mixed;
    public function updateStatusCombo(bool $status, int $id): mixed;

    // public function deleteOptrionAttr(int $id): mixed;
}
