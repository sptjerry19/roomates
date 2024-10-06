<?php

namespace App\Repositories\Admin\Product;

use App\Repositories\Base\RepositoryInterface;

interface ProductRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getProductDefault(): mixed;

    public function getProducts(array $attributes, ?int $page, ?int $limit): mixed;
    public function listProducts(array $attributes, ?int $page, ?int $limit): mixed;

    public function createProduct(array $attributes): mixed;
}
