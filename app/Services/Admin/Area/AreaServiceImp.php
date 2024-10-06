<?php

namespace App\Services\Admin\Area;

use App\Helpers\ApiResponse;
use App\Helpers\Common;
use App\Http\Resources\Admin\Area\AreaResource;
use App\Models\Admin\Area;
use App\Models\Admin\Table;
use App\Repositories\Admin\Area\AreaRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AreaServiceImp extends BaseServiceImp implements AreaService
{
    public function __construct(AreaRepository $AreaRepository)
    {
        $this->repository = $AreaRepository;
    }

    public function getAreaDefault(): mixed
    {
        return $this->repository->getAreaDefault();
    }

    public function getAreas(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->getAreas($attributes, $page, $limit);
    }

    public function listArea(): mixed
    {
        return $this->repository->listArea();
    }

    public function createArea(array $params): mixed
    {
        try {
            DB::beginTransaction();
            do {
                $code = '#AREA-' . Common::generateCode(4);

                $areaCodeExist = Area::query()->where('area_code', $code)->exists();
            } while ($areaCodeExist);

            $dataArea = [
                'name' => $params['name'],
                'stt' => $params['order_number'] ?? null,
                'area_code' => $code,
                'user_id' => auth()->user()->id,
                'company_id' => auth()->user()->company_id,
                'shop_id' => $params['shop_id'],

            ];

            $area = parent::create($dataArea);

            // $shops = $params['shops'] ?? null;
            // if (!is_null($shops)) {
            //     if (is_array($shops)) {
            //         $area->shops()->attach($shops);
            //     } else {
            //         $area->shops()->attach([$shops]);
            //     }
            // }
            DB::commit();

            return $area;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateArea(array $params, int $id): mixed
    {
        try {
            DB::beginTransaction();

            $dataArea = [
                'name' => $params['name'],
                'stt' => $params['order_number'] ?? null,
                'user_id' => auth()->user()->id,
                'company_id' => auth()->user()->company_id,
                'shop_id' => $params['shop_id'],
            ];

            $area = parent::update($id, $dataArea);

            // $shops = $params['shops'] ?? null;
            // if (!is_null($shops)) {
            //     if (is_array($shops)) {
            //         $area->shops()->sync($shops);
            //     } else {
            //         $area->shops()->sync([$shops]);
            //     }
            // }

            if (isset($params['tables'])) {
                // Update or create option attributes
                foreach ($params['tables'] as $item) {
                    if (isset($item['id'])) {
                        $table = Table::query()->find($item['id']);
                        if (!$table) {
                            // Handle case where option attribute doesn't exist
                            throw new \Exception("Option attribute with ID {$item['id']} not found.");
                        }

                        if ($table->status !== 'available') {
                            return ApiResponse::error("Thẻ bàn {$table->table_number} đang được sử dụng, không thể xóa.", 403);
                        }

                        $table->update([
                            'table_number' => $item['table_number'],
                            'table_type' => $item['table_type'],
                            'shop_id' => $params['shop_id'] ?? $table->shop_id,
                            'status' => $item['status'],
                        ]);
                    } else {
                        $table = Table::create([
                            'table_number' => $item['table_number'],
                            'table_type' => $item['table_type'],
                            'area_id' => $area->id,
                            'company_id' => auth()->user()->company_id,
                            'user_id' => auth()->user()->id,
                            'shop_id' => $params['shop_id'] ?? auth()->user()->shop_id ?? null,
                            'status' => 'available',
                        ]);
                    }
                }
            }

            DB::commit();

            // return $area;
            return ApiResponse::success(new AreaResource($area), __('message.success.area.updated_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusArea(int $id, ?bool $status): mixed
    {
        try {
            $area = parent::update($id, ['status' => $status ?? false]);

            return $area;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
