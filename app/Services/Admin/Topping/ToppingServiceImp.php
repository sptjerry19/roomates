<?php

namespace App\Services\Admin\Topping;

use App\Models\Admin\Topping;
use App\Models\Admin\ToppingAttr;
use App\Repositories\Admin\Topping\ToppingRepository;
use App\Repositories\Admin\ToppingAttr\ToppingAttrRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ToppingServiceImp extends BaseServiceImp implements ToppingService
{
    protected $toppingAttrRepository;
    public function __construct(ToppingRepository $ToppingRepository, ToppingAttrRepository $toppingAttrRepository)
    {
        $this->repository = $ToppingRepository;
        $this->toppingAttrRepository = $toppingAttrRepository;
    }

    public function getToppingDefault(): mixed
    {
        return $this->repository->getToppingDefault();
    }

    public function getToppingByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->getToppingByCompany($attributes, $page, $limit);
    }

    public function listTopping(array $params): mixed
    {
        return $this->toppingAttrRepository->getToppingAttrByCompany($params);
    }

    public function createTopping(array $params): mixed
    {
        try {
            DB::beginTransaction();

            $data = [
                'name' => $params['name'],
                'user_id' => auth()->user()->id,
                'shop_id' => auth()->user()->company_id,
            ];

            $Topping = parent::create($data);

            // Attach products to Topping
            if (isset($params['products'])) {
                $productIds = $params['products'];
                $Topping->products()->attach($productIds);
            }

            // Attach topping attr to Topping
            if (isset($params['topping_attrs'])) {
                $toppingAttrs = $params['topping_attrs'];
                $Topping->products()->attach($toppingAttrs, ['is_topping' => true]);
            }


            DB::commit();
            return $Topping;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateTopping(array $params, int $id): mixed
    {
        try {
            DB::beginTransaction();

            $data = [
                'name' => $params['name'],
                'user_id' => auth()->user()->id,
                'shop_id' => auth()->user()->company_id,
            ];

            $Topping = parent::update($id, $data);

            $syncData = [];

            // Thêm products với is_topping = false
            if (isset($params['products'])) {
                foreach ($params['products'] as $productId) {
                    $syncData[$productId] = [
                        'is_topping' => false
                    ];
                }
            }

            // Thêm topping_attrs với is_topping = true
            if (isset($params['topping_attrs'])) {
                foreach ($params['topping_attrs'] as $toppingAttrId) {
                    $syncData[$toppingAttrId] = [
                        'is_topping' => true
                    ];
                }
            }

            // Sync tất cả các dữ liệu đã chuẩn bị
            $Topping->products()->sync($syncData);

            DB::commit();
            return $Topping;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusTopping(string $status, int $id): mixed
    {
        try {
            $Topping = Topping::query()->findOrFail($id);

            return $Topping->update(['status' => $status]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function deleteOptrionAttr(int $id): mixed
    {
        try {
            $ToppingAttr = ToppingAttr::query()->findOrFail($id);

            return $ToppingAttr->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
