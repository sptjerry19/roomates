<?php

namespace App\Repositories\Admin\Printer;

use App\Models\Admin\Printer;
use App\Repositories\Base\BaseRepository;

class PrinterRepositoryEloquent extends BaseRepository implements PrinterRepository
{
    public function getModel(): string
    {
        return Printer::class;
    }

    public function getPrintersByDevice(int $device_id): mixed
    {
        return $this->select()
            ->where('device_id', $device_id)
            ->orderByDesc('created_at')
            ->get();
    }
}
