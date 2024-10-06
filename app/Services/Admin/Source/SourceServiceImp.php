<?php

namespace App\Services\Admin\Source;

use App\Repositories\Admin\Source\SourceRepository;
use App\Repositories\Admin\SourceValue\SourceValueRepository;
use App\Services\Base\BaseServiceImp;

class SourceServiceImp extends BaseServiceImp implements SourceService
{
    protected $sourceValueRepository;
    public function __construct(SourceRepository $sourceRepository, SourceValueRepository $sourceValueRepository)
    {
        $this->repository = $sourceRepository;
        $this->sourceValueRepository = $sourceValueRepository;
    }

    public function getSourceDefault(): mixed
    {
        return $this->repository->getSourceDefault();
    }

    public function getSources(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->sourceValueRepository->getSources($attributes, $page, $limit);
    }

    public function createSourceValue(array $attributes,): mixed
    {
        $attributes['company_id'] = auth()->user()->company_id;
        return $this->sourceValueRepository->create($attributes);
    }

    public function updateSourceValue(int $id, array $attributes,): mixed
    {
        return $this->sourceValueRepository->update($id, $attributes);
    }

    public function updateStatusSourceValue(int $id, bool $status,): mixed
    {
        return $this->sourceValueRepository->update($id, [
            'status' => $status
        ]);
    }
}
