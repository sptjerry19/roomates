<?php

namespace App\Services\Admin\Option;

use App\Services\Base\BaseServiceInterface;

interface OptionService extends BaseServiceInterface
{
    public function getOptionDefault(): mixed;

    public function getOptionByCompany(array $attributes, ?int $page, ?int $limit): mixed;
    public function getAllOptionByCompany(array $attributes, ?int $page, ?int $limit): mixed;

    public function createOption(array $params): mixed;

    public function updateOption(array $params, int $id): mixed;
    public function updateStatusOption(bool $status, int $id): mixed;

    public function deleteOptrionAttr(int $id): mixed;
}
