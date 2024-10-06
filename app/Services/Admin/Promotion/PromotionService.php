<?php

namespace App\Services\Admin\Promotion;

use App\Services\Base\BaseServiceInterface;

interface PromotionService extends BaseServiceInterface
{
    public function getPromotionByCompany(array $attributes, ?int $page, ?int $limit): mixed;

    public function createPromotion(array $params): mixed;

    public function updatePromotion(array $params, int $id): mixed;
    public function updateStatusPromotion(string $status, int $id): mixed;

    public function deleteOptrionAttr(int $id): mixed;
}
