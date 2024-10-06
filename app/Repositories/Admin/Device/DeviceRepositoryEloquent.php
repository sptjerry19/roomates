<?php

namespace App\Repositories\Admin\Device;

use App\Models\Admin\Device;
use App\Repositories\Base\BaseRepository;

class DeviceRepositoryEloquent extends BaseRepository implements DeviceRepository
{
    public function getModel(): string
    {
        return Device::class;
    }

    public function getDeviceDefault(): mixed
    {
        return $this->select()->whereNull('company_id')
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getDevices(array $attributes, ?int $page, ?int $limit): mixed
    {
        $keyword = $attributes['keyword'] ?? null;
        $companyId = auth()->user()->company_id;
        $deviceType = $attributes['device_type'] ?? null;
        return $this->select()
            ->where('company_id', $companyId)
            ->when(!is_null($deviceType), function ($query) use ($deviceType) {
                return $query->where('device_type', $deviceType);
            })
            ->when(!is_null($keyword), function ($query) use ($keyword) {
                return $query->where('device_name', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('created_at')
            ->paginate($limit);
    }

    public function getDevicesActive(): mixed
    {
        $companyId = auth()->user()->company_id;
        $shopId = $attributes['shop_id'] ?? auth()->user()->shop_id ?? null;
        return $this->select(['id', 'name', 'code'])->where('status', 'active')
            ->where('company_id', $companyId)
            ->when(!is_null($shopId), function ($query) use ($shopId) {
                return $query->where('shop_id', $shopId);
            })
            ->orderByDesc('created_at')
            ->get();
    }
}
