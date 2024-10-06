<?php

namespace App\Repositories\Admin\Device;

use App\Repositories\Base\RepositoryInterface;

interface DeviceRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getDeviceDefault(): mixed;

    public function getDevices(array $attributes, ?int $page, ?int $limit): mixed;

    public function getDevicesActive(): mixed;
}
