<?php

namespace App\Services\Admin\Printer;

use App\Services\Base\BaseServiceInterface;

interface PrinterService extends BaseServiceInterface
{
    public function getPrinters(int $device_id): mixed;

    public function createPrinter(array $params): mixed;
    public function updatePrinter(int $id, array $params): mixed;

    public function destroyPrinter(int $id): mixed;
}
