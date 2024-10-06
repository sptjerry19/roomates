<?php

namespace App\Services\Admin\Merchandise;

use App\Helpers\Common;
use App\Models\Admin\Merchandise;
use App\Models\Admin\Table;
use App\Repositories\Admin\Merchandise\MerchandiseRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MerchandiseServiceImp extends BaseServiceImp implements MerchandiseService
{
    public function __construct(MerchandiseRepository $MerchandiseRepository)
    {
        $this->repository = $MerchandiseRepository;
    }

    public function getMerchandiseDefault(): mixed
    {
        return $this->repository->getMerchandiseDefault();
    }

    public function getMerchandises(array $attributes, ?int $page, ?int $limit): mixed
    {
        try {
            $Merchandises = $this->repository->getMerchandises($attributes, $page, $limit);

            return $Merchandises;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function createMerchandise(array $params): mixed
    {
        try {
            DB::beginTransaction();
            $image = isset($params['image']) ?  Common::uploadbase64Image($params['image'], 'Merchandise/image/') : null;
            $data = [
                'image' => $image,
                'name' => $params['name'],
                'code' => $params['code'],
                'type' => $params['type'],
                'unit_id' => $params['unit_id'],
                'commodity_id' => $params['commodity_id'] ?? null,
                'unit_price' => $params['unit_price'] ?? 0,
                'description' => $params['description'] ?? null,
                'tracking_status' => $params['tracking_status'] ?? true,
                'company_id' => auth()->user()->company_id,
                'user_id' => auth()->user()->id,
            ];

            $merchandises = parent::create($data);

            if (isset($params['storage']) && is_array($params['storage'])) {
                foreach ($params['storage'] as $storage) {
                    $pivotData = [
                        'quantity' => $storage['quantity'],
                        'total_price' => $storage['total_price']
                    ];

                    $merchandises->storages()->attach($storage['storage_id'], $pivotData);
                }
            }

            DB::commit();
            return $merchandises;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateMerchandise(array $params, int $id): mixed
    {
        try {
            DB::beginTransaction();
            $image = isset($params['image']) ?  Common::uploadbase64Image($params['image'], 'Merchandise/image/') : null;
            $data = [
                'image' => $image,
                'name' => $params['name'],
                'type' => $params['type'],
                'unit_id' => $params['unit_id'],
                'commodity_id' => $params['commodity_id'] ?? null,
                'unit_price' => $params['unit_price'] ?? 0,
                'description' => $params['description'] ?? null,
                'tracking_status' => $params['tracking_status'] ?? true,
                'company_id' => auth()->user()->company_id,
                'user_id' => auth()->user()->id,
            ];

            $merchandises = parent::update($id, $data);

            if (isset($params['storage']) && is_array($params['storage'])) {
                $syncData = [];
                foreach ($params['storage'] as $storage) {
                    $syncData[$storage['storage_id']] = [
                        'quantity' => $storage['quantity'],
                        'total_price' => $storage['total_price']
                    ];

                    $merchandises->storages()->sync($syncData);
                }
            }

            DB::commit();
            return $merchandises;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusMerchandise(int $id, ?bool $status): mixed
    {
        try {
            $Merchandise = parent::update($id, ['status' => $status ?? false]);

            return $Merchandise;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
