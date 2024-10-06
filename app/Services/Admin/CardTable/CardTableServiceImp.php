<?php

namespace App\Services\Admin\CardTable;

use App\Helpers\Common;
use App\Models\Admin\CardTable;
use App\Repositories\Admin\CardTable\CardTableRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CardTableServiceImp extends BaseServiceImp implements CardTableService
{
    public function __construct(CardTableRepository $cardTableRepository)
    {
        $this->repository = $cardTableRepository;
    }

    public function getCardTableDefault(): mixed
    {
        return $this->repository->getCardTableDefault();
    }

    public function getCardTables(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->getCardTables($attributes, $page, $limit);
    }

    public function createCardTable(array $params): mixed
    {
        try {
            DB::beginTransaction();
            $countCardTable = CardTable::query()
                ->where('company_id', auth()->user()->company_id)
                ->where('shop_id', $params['shop_id'])
                ->where('status', 'active')
                ->count();
            $quantity = $params['quantity'] ?? 1;

            for ($i = 1; $i <= $quantity; $i++) {
                $index = $countCardTable + $i;
                $data = [
                    'name' => "THE $index",
                    'shop_id' => $params['shop_id'],
                    'user_id' => auth()->user()->id,
                    'company_id' => auth()->user()->company_id,
                ];

                $Cardtable = parent::create($data);
            }

            DB::commit();
            return $Cardtable;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateCardTable(int $shopId, array $params): mixed
    {
        try {
            DB::beginTransaction();
            $cardTables = $params['card_tables'];

            foreach ($cardTables as $cardTable) {
                if (!isset($cardTable['id'])) {
                    $data = [
                        'name' => $cardTable['name'],
                        'shop_id' => $shopId,
                        'user_id' => auth()->user()->id,
                    ];
                    $Cardtable = CardTable::create($data);
                } else {
                    $data = [
                        'name' => $cardTable['name'],
                        'shop_id' => $shopId,
                        'status' => $cardTable['status'],
                    ];
                    $id = $cardTable['id'];
                    $Cardtable = parent::update($id, $data);
                }
            }

            DB::commit();
            return $Cardtable;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusCardTable(int $id, ?string $status): mixed
    {
        try {
            $Cardtable = parent::update($id, ['status' => $status ?? 'locked']);

            return $Cardtable;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
