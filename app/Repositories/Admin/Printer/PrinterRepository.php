<?php

namespace App\Repositories\Admin\Printer;

use App\Repositories\Base\RepositoryInterface;

interface PrinterRepository extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getModel(): string;

    public function getPrintersByDevice(int $device_id): mixed;
}
