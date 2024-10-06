<?php

namespace App\Services\Admin\Category;

use App\Services\Base\BaseServiceInterface;

interface CategoryService extends BaseServiceInterface
{
    public function getCategoryDefault(): mixed;
    public function getCategories(?array $params): mixed;

    public function getCategoriesActive(): mixed;
}
