<?php

namespace App\Services\Admin\Table;

use App\Helpers\Common;
use App\Models\Admin\Table;
use App\Repositories\Admin\Table\TableRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TableServiceImp extends BaseServiceImp implements TableService
{
    public function __construct(TableRepository $TableRepository)
    {
        $this->repository = $TableRepository;
    }

    public function getTableDefault(): mixed
    {
        return $this->repository->getTableDefault();
    }

    public function getTables(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->getTables($attributes, $page, $limit);
    }

    public function createTable(array $params): mixed
    {
        try {
            DB::beginTransaction();
            $quantity = $params['quanlity'] ?? 1;
            for ($i = 1; $i <= $quantity; $i++) {
                $tableName = $params['name'] . ' ' . $i;

                $data = [
                    'table_number' => $tableName,
                    'area_id' => $params['area_id'],
                    'quanlity' => $params['quanlity'] ?? 1,
                    'table_type' => $params['table_type'],
                    'stt' => $params['stt'] ?? null,
                    'user_id' => auth()->user()->id,
                    'company_id' => auth()->user()->company_id,
                    'shop_id' => $params['shop_id'],
                ];

                $table = parent::create($data);
            }

            DB::commit();
            return $table;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateTable(int $id, array $params): mixed
    {
        try {
            $data = [
                'table_number' => $params['name'],
                'area_id' => $params['area_id'],
                'quanlity' => $params['quanlity'] ?? 1,
                'table_type' => $params['table_type'],
                'stt' => $params['stt'] ?? null,
                'user_id' => auth()->user()->id,
                'shop_id' => auth()->user()->company_id,
            ];

            $table = parent::update($id, $data);
            return $table;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusTable(int $id, ?string $status): mixed
    {
        try {
            $table = parent::update($id, ['status' => $status ?? 'locked']);

            return $table;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
