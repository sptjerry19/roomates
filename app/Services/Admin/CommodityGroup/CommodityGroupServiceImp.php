<?php

namespace App\Services\Admin\CommodityGroup;

use App\Helpers\Common;
use App\Models\Admin\CommodityGroup;
use App\Models\Admin\Table;
use App\Repositories\Admin\CommodityGroup\CommodityGroupRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommodityGroupServiceImp extends BaseServiceImp implements CommodityGroupService
{
    public function __construct(CommodityGroupRepository $commodityGroupRepository)
    {
        $this->repository = $commodityGroupRepository;
    }

    public function getCommodityGroupDefault(): mixed
    {
        return $this->repository->getCommodityGroupDefault();
    }

    public function getCommodityGroups(array $attributes): mixed
    {
        try {
            $commodityGroups = $this->repository->getCommodityGroups($attributes);

            return $commodityGroups;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function createCommodityGroup(array $params): mixed
    {
        try {
            $data = [
                'name' => $params['name'],
                'code' => $params['code'],
                'company_id' => auth()->user()->company_id,
                'shop_id' => auth()->user()->shop_id ?? null,
                'user_id' => auth()->user()->id,
            ];

            $commodityGroups = parent::create($data);

            return $commodityGroups;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateCommodityGroup(array $params, int $id): mixed
    {
        try {
            $data = [
                'name' => $params['name'],
            ];

            $commodityGroups = parent::update($id, $data);

            return $commodityGroups;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusCommodityGroup(int $id, ?bool $status): mixed
    {
        try {
            $CommodityGroup = parent::update($id, ['status' => $status ?? false]);

            return $CommodityGroup;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
