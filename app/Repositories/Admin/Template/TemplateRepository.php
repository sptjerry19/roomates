<?php

namespace App\Repositories\Admin\Template;

use App\Repositories\Base\RepositoryInterface;

interface TemplateRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getTemplateDefault(): mixed;
    public function getTemplates(): mixed;
}
