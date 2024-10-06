<?php

namespace App\Services\Admin\Promotion;

use App\Models\Admin\Promotion;
use App\Repositories\Admin\Promotion\PromotionRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromotionServiceImp extends BaseServiceImp implements PromotionService
{
    public function __construct(PromotionRepository $PromotionRepository)
    {
        $this->repository = $PromotionRepository;
    }

    public function getPromotionByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->getPromotionByCompany($attributes, $page, $limit);
    }

    public function createPromotion(array $params): mixed
    {
        try {
            DB::beginTransaction();

            $data = [
                'company_id' => auth()->user()->company_id,
                'name' => $params['name'],
                'discount' => $params['discount'],
                'start_date' => $params['start_date'],
                'end_date' => $params['end_date'] ?? null,
                'time_slots' => json_encode($params['time_slots']), // Chuyển time_slots thành JSON
                'days_of_week' => json_encode($params['days_of_week'] ?? []), // Chuyển days_of_week thành JSON
                'status' => $params['status'] ?? 'active',
            ];

            // Tạo mới Promotion
            $promotion = parent::create($data);

            // Liên kết các sản phẩm với chương trình khuyến mãi
            if (isset($params['products']) && is_array($params['products'])) {
                $promotion->products()->attach($params['products']);
            }

            // Liên kết các cửa hàng với chương trình khuyến mãi
            if (isset($params['shops']) && is_array($params['shops'])) {
                $promotion->shops()->attach($params['shops']);
            }

            DB::commit();
            return $promotion; // Trả về chương trình khuyến mãi vừa tạo
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updatePromotion(array $params, int $id): mixed
    {
        try {
            DB::beginTransaction();

            $data = [
                'company_id' => auth()->user()->company_id,
                'name' => $params['name'],
                'discount' => $params['discount'],
                'start_date' => $params['start_date'],
                'end_date' => $params['end_date'] ?? null,
                'time_slots' => json_encode($params['time_slots']), // Chuyển time_slots thành JSON
                'days_of_week' => json_encode($params['days_of_week'] ?? []), // Chuyển days_of_week thành JSON
                'status' => $params['status'] ?? 'active',
            ];

            // Tạo mới Promotion
            $promotion = parent::update($id, $data);

            // Liên kết các sản phẩm với chương trình khuyến mãi
            if (isset($params['products']) && is_array($params['products'])) {
                $promotion->products()->sync($params['products']);
            }

            // Liên kết các cửa hàng với chương trình khuyến mãi
            if (isset($params['shops']) && is_array($params['shops'])) {
                $promotion->shops()->sync($params['shops']);
            }

            DB::commit();
            return $promotion; // Trả về chương trình khuyến mãi vừa tạo
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusPromotion(string $status, int $id): mixed
    {
        try {
            $promotion = Promotion::query()->findOrFail($id);

            return $promotion->update(['status' => $status]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function deleteOptrionAttr(int $id): mixed
    {
        try {
            // $PromotionAttr = PromotionAttr::query()->findOrFail($id);

            // return $PromotionAttr->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
