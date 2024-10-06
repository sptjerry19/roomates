<?php

namespace App\Services\Admin\Product;

use App\Services\Base\BaseServiceInterface;

interface ProductService extends BaseServiceInterface
{
    public function getProductDefault(): mixed;
    public function getCategories(): mixed;

    public function createProduct(array $params): mixed;
    public function createTopping(array $params): mixed;

    public function updateProduct(string $id, array $params): mixed;

    public function getProductByCompany(array $attributes, ?int $page, ?int $limit): mixed;

    public function listProducts(array $attributes, ?int $page, ?int $limit): mixed;

    public function createCostProduct(array $params): mixed;
}
