<?php

namespace App\Repositories\Admin\Source;

use App\Repositories\Base\RepositoryInterface;

interface SourceRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getSourceDefault(): mixed;
}
