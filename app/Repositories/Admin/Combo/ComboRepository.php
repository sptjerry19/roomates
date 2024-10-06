<?php

namespace App\Repositories\Admin\Combo;

use App\Repositories\Base\RepositoryInterface;

interface ComboRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getComboDefault(): mixed;

    public function getComboByCompany(array $attributes, ?int $page, ?int $limit): mixed;

    public function listComboByCompany(array $attributes, ?int $page, ?int $limit): mixed;
}
