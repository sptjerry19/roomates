<?php

namespace App\Repositories\Admin\Source;

use App\Models\Admin\Source;
use App\Repositories\Base\BaseRepository;

class SourceRepositoryEloquent extends BaseRepository implements SourceRepository
{
    public function getModel(): string
    {
        return Source::class;
    }

    public function getSourceDefault(): mixed
    {
        return $this->select()->get();
    }

    public function getSources(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $keyword = $attributes['keyword'] ?? null;
        return $this->select()->where('company_id', $companyId)
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('created_at')
            ->paginate($limit);
    }
}
