<?php

namespace App\Repositories\Admin\Topping;

use App\Repositories\Base\RepositoryInterface;

interface ToppingRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getToppingDefault(): mixed;

    public function getToppingByCompany(array $attributes, ?int $page, ?int $limit): mixed;
}
