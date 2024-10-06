<?php

namespace App\Repositories\Admin\Promotion;

use App\Repositories\Base\RepositoryInterface;

interface PromotionRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getPromotionByCompany(array $attributes, ?int $page, ?int $limit): mixed;
}
