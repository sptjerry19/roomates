<?php

namespace App\Services\Admin\Template;

use App\Services\Base\BaseServiceInterface;

interface TemplateService extends BaseServiceInterface
{
    public function getTemplateDefault(): mixed;
    public function getTemplates(): mixed;

    public function updateTemplate(array $params): mixed;
}
