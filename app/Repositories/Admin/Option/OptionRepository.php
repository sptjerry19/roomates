<?php

namespace App\Repositories\Admin\Option;

use App\Repositories\Base\RepositoryInterface;

interface OptionRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getOptionDefault(): mixed;

    public function getOptionByCompany(array $attributes, ?int $page, ?int $limit): mixed;
    public function getAllOptionByCompany(array $attributes, ?int $page, ?int $limit): mixed;
}
