<?php

namespace App\Services\Admin\Template;

use App\Repositories\Admin\Template\TemplateRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\Log;

class TemplateServiceImp extends BaseServiceImp implements TemplateService
{
    public function __construct(TemplateRepository $TemplateRepository)
    {
        $this->repository = $TemplateRepository;
    }

    public function getTemplateDefault(): mixed
    {
        return $this->repository->getTemplateDefault();
    }

    public function getTemplates(): mixed
    {
        return $this->repository->getTemplates();
    }

    public function updateTemplate(array $params): mixed
    {
        try {
            $maps = [
                'company_id' => auth()->user()->company_id,
                'type' => $params['type'],
            ];
            $attributes = [
                'content' => json_encode($params['content'])
            ];

            return $this->repository->updateOrCreate($maps, $attributes);
        } catch (\Exception $e) {
            dd($e);
            Log::error($e->getMessage());
            return false;
        }
    }
}
