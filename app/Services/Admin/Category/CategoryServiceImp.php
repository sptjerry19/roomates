<?php

namespace App\Services\Admin\Category;

use App\Repositories\Admin\Category\CategoryRepository;
use App\Services\Base\BaseServiceImp;

class CategoryServiceImp extends BaseServiceImp implements CategoryService
{
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }

    public function getCategoryDefault(): mixed
    {
        return $this->repository->getCategoryDefault();
    }

    public function getCategories(?array $params): mixed
    {
        return $this->repository->getCategories($params);
    }

    public function getCategoriesActive(): mixed
    {
        return $this->repository->getCategoriesActive();
    }
}
