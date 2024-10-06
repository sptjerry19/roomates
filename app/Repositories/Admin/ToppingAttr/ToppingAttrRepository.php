<?php

namespace App\Repositories\Admin\ToppingAttr;

use App\Repositories\Base\RepositoryInterface;

interface ToppingAttrRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getToppingAttrDefault(): mixed;

    public function getToppingAttrByCompany(array $params): mixed;
}
