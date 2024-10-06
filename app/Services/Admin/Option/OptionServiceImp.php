<?php

namespace App\Services\Admin\Option;

use App\Models\Admin\Option;
use App\Models\Admin\OptionAttr;
use App\Repositories\Admin\Option\OptionRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OptionServiceImp extends BaseServiceImp implements OptionService
{
    public function __construct(OptionRepository $optionRepository)
    {
        $this->repository = $optionRepository;
    }

    public function getOptionDefault(): mixed
    {
        return $this->repository->getOptionDefault();
    }

    public function getOptionByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->getOptionByCompany($attributes, $page, $limit);
    }

    public function getAllOptionByCompany(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->getAllOptionByCompany($attributes, $page, $limit);
    }

    public function createOption(array $params): mixed
    {
        try {
            DB::beginTransaction();

            $data = [
                'name' => $params['name'],
                'user_id' => auth()->user()->id,
                'shop_id' => auth()->user()->company_id,
                'allowed_dishes' => $params['allowed_dishes'] ?? false,
                'allow_min' => $params['allow_min'] ?? null,
                'allow_max' => $params['allow_max'] ?? null,
            ];

            $option = parent::create($data);

            if (isset($params['options'])) {
                foreach ($params['options'] as $item) {
                    $optionAttr = OptionAttr::create([
                        'value' => $item['name'],
                        'price' => $item['price'] ?? 0,
                        'option_id' => $option->id,
                    ]);
                }
            }

            // Attach products to option
            if (isset($params['products'])) {
                $productIds = $params['products'];
                $option->products()->attach($productIds);
            }


            DB::commit();
            return $option;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateOption(array $params, int $id): mixed
    {
        try {
            DB::beginTransaction();

            $data = [
                'name' => $params['name'],
                'user_id' => auth()->user()->id,
                'shop_id' => auth()->user()->company_id,
                'allowed_dishes' => $params['allowed_dishes'] ?? false,
                'allow_min' => $params['allow_min'] ?? null,
                'allow_max' => $params['allow_max'] ?? null,
            ];


            $option = parent::update($id, $data);


            if (isset($params['options'])) {
                // Update or create option attributes
                foreach ($params['options'] as $item) {
                    if (isset($item['id'])) {
                        $optionAttr = OptionAttr::query()->find($item['id']);
                        if (!$optionAttr) {
                            // Handle case where option attribute doesn't exist
                            throw new \Exception("Option attribute with ID {$item['id']} not found.");
                        }
                        $optionAttr->update([
                            'value' => $item['name'],
                            'price' => $item['price'] ?? 0,
                            'option_id' => $option->id,
                        ]);
                    } else {
                        $optionAttr = OptionAttr::create([
                            'value' => $item['name'],
                            'price' => $item['price'] ?? 0,
                            'option_id' => $option->id,
                        ]);
                    }
                }
            }

            // Attach products to option
            if (isset($params['products'])) {
                $productIds = $params['products'];
                $option->products()->sync($productIds);
            }


            DB::commit();
            return $option;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusOption(bool $status, int $id): mixed
    {
        try {
            $option = Option::query()->findOrFail($id);

            return $option->update(['status' => $status]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function deleteOptrionAttr(int $id): mixed
    {
        try {
            $optionAttr = OptionAttr::query()->findOrFail($id);

            return $optionAttr->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
