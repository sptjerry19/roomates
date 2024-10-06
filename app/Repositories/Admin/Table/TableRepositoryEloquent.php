<?php

namespace App\Repositories\Admin\Table;

use App\Models\Admin\Table;
use App\Repositories\Base\BaseRepository;

class TableRepositoryEloquent extends BaseRepository implements TableRepository
{
    public function getModel(): string
    {
        return Table::class;
    }

    public function getTableDefault(): mixed
    {
        return $this->select()->whereNull('company_id')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getTables(array $attributes, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        $keyword = $attributes['keyword'] ?? null;
        $areaId = $attributes['area_id'] ?? null;
        $tableType = $attributes['table_type'] ?? null;
        return $this->select()
            ->where('status', '!=', 'locked')
            ->where('company_id', $companyId)
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('table_number', 'LIKE', '%' . $keyword . '%');
            })
            ->when(!is_null($areaId), function ($query) use ($areaId) {
                return $query->where('area_id', $areaId);
            })
            ->when(!is_null($tableType), function ($query) use ($tableType) {
                return $query->where('table_type', 'LIKE', '%' . $tableType . '%');
            })
            ->orderBy('stt')
            ->paginate($limit);
    }
}
