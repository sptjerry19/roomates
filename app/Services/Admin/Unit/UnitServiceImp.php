<?php

namespace App\Services\Admin\Unit;

use App\Helpers\Common;
use App\Models\Admin\Unit;
use App\Models\Admin\Table;
use App\Repositories\Admin\Unit\UnitRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnitServiceImp extends BaseServiceImp implements UnitService
{
    public function __construct(UnitRepository $unitRepository)
    {
        $this->repository = $unitRepository;
    }

    public function getUnitDefault(): mixed
    {
        return $this->repository->getUnitDefault();
    }

    public function getUnits(array $attributes): mixed
    {
        try {
            $units = $this->repository->getUnits($attributes);

            return $units;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function createUnit(array $params): mixed
    {
        try {
            $data = [
                'name' => $params['name'],
                'code' => $params['code'],
                'quantity' => $params['quantity'],
                'company_id' => auth()->user()->company_id,
                'shop_id' => auth()->user()->shop_id ?? null,
                'user_id' => auth()->user()->id,
            ];

            $units = parent::create($data);

            return $units;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateUnit(array $params, int $id): mixed
    {
        try {
            $data = [
                'name' => $params['name'],
                'quantity' => $params['quantity'],
                'mass_type' => $params['mass_type'],
            ];

            $Units = parent::update($id, $data);

            return $Units;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusUnit(int $id, ?bool $status): mixed
    {
        try {
            $Unit = parent::update($id, ['status' => $status ?? false]);

            return $Unit;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
