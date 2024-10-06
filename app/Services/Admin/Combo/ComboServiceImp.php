<?php

namespace App\Services\Admin\Combo;

use App\Helpers\Common;
use App\Models\Admin\Combo;
use App\Repositories\Admin\Combo\ComboRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComboServiceImp extends BaseServiceImp implements ComboService
{
    public function __construct(ComboRepository $ComboRepository)
    {
        $this->repository = $ComboRepository;
    }

    public function getCombos(): mixed
    {
        return $this->repository->getComboDefault();
    }

    public function getComboByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->getComboByCompany($attributes, $page, $limit);
    }

    public function listComboByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->listComboByCompany($attributes, $page, $limit);
    }

    public function createCombo(array $params): mixed
    {
        try {
            DB::beginTransaction();

            $image = isset($params['image']) ?  Common::uploadbase64Image($params['image'], 'Combo/image/') : null;
            $data = [
                'company_id' => auth()->user()->company_id,
                'name' => $params['name'],
                'price' => $params['price'],
                'vat' => $params['vat'] ?? 0,
                'code' => $params['code'],
                'description' => $params['description'] ?? null,
                'image_url' => $image ?? null,
                'start_date' => $params['start_date'] ?? null,
                'end_date' => $params['end_date'] ?? null,
                'time_slots' => json_encode($params['time_slots']) ?? null, // Chuyển time_slots thành JSON
                'days_of_week' => json_encode($params['days_of_week'] ?? null), // Chuyển days_of_week thành JSON
                'status' => $params['status'] ?? true,
            ];

            // Tạo mới Promotion
            $combo = parent::create($data);

            // Liên kết các sản phẩm với combo
            if (isset($params['products']) && is_array($params['products'])) {
                foreach ($params['products'] as $product) {
                    // Chuẩn bị dữ liệu cho bảng pivot
                    $pivotData = [
                        'price' => $product['price_combo'],
                        'quanlity' => $product['quanlity'],
                        'options' => json_encode($product['options']),
                        'toppings' => json_encode($product['group_toppings']),
                    ];

                    // Liên kết sản phẩm với combo qua bảng pivot combo_product
                    $combo->products()->attach($product['product_id'], $pivotData);
                }
            }

            // Liên kết các cửa hàng với chương trình khuyến mãi
            if (isset($params['shops']) && is_array($params['shops'])) {
                $combo->shops()->attach($params['shops']);
            }

            DB::commit();
            return $combo;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateCombo(array $params, int $id): mixed
    {
        try {
            DB::beginTransaction();

            $combo = $this->repository->findOrFail($id);
            $oldImagePath = $combo->image_url;

            $image = isset($params['image']) ? Common::updateProductImage($params['image'], $oldImagePath, 'Combo/image/') : null;
            $data = [
                'company_id' => auth()->user()->company_id,
                'name' => $params['name'],
                'price' => $params['price'],
                'vat' => $params['vat'] ?? 0,
                'code' => $params['code'],
                'description' => $params['description'] ?? null,
                'image_url' => $image ?? null,
                'start_date' => $params['start_date'] ?? null,
                'end_date' => $params['end_date'] ?? null,
                'time_slots' => json_encode($params['time_slots']) ?? null, // Chuyển time_slots thành JSON
                'days_of_week' => json_encode($params['days_of_week'] ?? null), // Chuyển days_of_week thành JSON
                'status' => $params['status'] ?? true,
            ];

            // Tạo mới Promotion
            $combo = parent::update($id, $data);

            if (isset($params['products']) && is_array($params['products'])) {
                $syncData = [];
                foreach ($params['products'] as $product) {
                    // Chuẩn bị dữ liệu cho bảng pivot
                    $syncData[$product['product_id']] = [
                        'price' => $product['price_combo'],
                        'quanlity' => $product['quanlity'],
                        'options' => json_encode($product['options']),
                        'toppings' => json_encode($product['group_toppings']),
                    ];
                }

                // Sử dụng sync với dữ liệu pivot
                $combo->products()->sync($syncData);
            }

            // Liên kết các cửa hàng với chương trình khuyến mãi
            if (isset($params['shops']) && is_array($params['shops'])) {
                $combo->shops()->sync($params['shops']);
            }

            DB::commit();
            return $combo;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusCombo(bool $status, int $id): mixed
    {
        try {
            $combo = Combo::query()->findOrFail($id);

            return $combo->update(['status' => $status]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
