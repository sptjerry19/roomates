<?php

namespace App\Services\Admin\Device;

use App\Services\Base\BaseServiceInterface;

interface DeviceService extends BaseServiceInterface
{
    public function getDeviceDefault(): mixed;
    public function getDevices(array $attributes, ?int $page, ?int $limit): mixed;

    public function createDevice(array $params): mixed;
    public function updateDevice(int $id, array $params): mixed;
    public function updateStatusDevice(int $id, bool $status): mixed;

    public function getDevicesActive(): mixed;
}
