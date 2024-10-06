<?php

namespace App\Services\Admin\Source;

use App\Services\Base\BaseServiceInterface;

interface SourceService extends BaseServiceInterface
{
    public function getSourceDefault(): mixed;

    public function getSources(array $attributes, ?int $page, ?int $limit): mixed;

    public function createSourceValue(array $attributes,): mixed;
    public function updateSourceValue(int $id, array $attributes,): mixed;
    public function updateStatusSourceValue(int $id, bool $status,): mixed;
}
