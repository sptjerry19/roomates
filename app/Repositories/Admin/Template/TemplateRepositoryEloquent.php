<?php

namespace App\Repositories\Admin\Template;

use App\Models\Admin\Template;
use App\Repositories\Base\BaseRepository;

class TemplateRepositoryEloquent extends BaseRepository implements TemplateRepository
{
    public function getModel(): string
    {
        return Template::class;
    }

    public function getTemplateDefault(): mixed
    {
        return $this->select()->whereNull('company_id')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getTemplates(): mixed
    {
        $companyId = auth()->user()->company_id;
        return $this->select()->where('company_id', $companyId)
            ->orderByDesc('created_at')
            ->get();
    }
}
