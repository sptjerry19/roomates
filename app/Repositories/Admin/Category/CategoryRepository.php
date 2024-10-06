<?php

namespace App\Repositories\Admin\Category;

use App\Repositories\Base\RepositoryInterface;

interface CategoryRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getCategoryDefault(): mixed;

    public function getCategories(?array $params): mixed;

    public function getCategoriesActive(): mixed;
}
