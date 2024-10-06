<?php

namespace App\Repositories\Admin\SourceValue;

use App\Repositories\Base\RepositoryInterface;

interface SourceValueRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getSources(array $attributes, ?int $page, ?int $limit): mixed;
}
