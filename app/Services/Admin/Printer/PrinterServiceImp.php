<?php

namespace App\Services\Admin\Printer;

use App\Helpers\Common;
use App\Models\Admin\SettingArea;
use App\Repositories\Admin\Printer\PrinterRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class PrinterServiceImp extends BaseServiceImp implements PrinterService
{
    public function __construct(PrinterRepository $PrinterRepository)
    {
        $this->repository = $PrinterRepository;
    }

    public function getPrinters(int $device_id): mixed
    {
        return $this->repository->getPrinters($device_id);
    }

    public function createPrinter(array $params): mixed
    {
        try {
            DB::beginTransaction();
            $data = [
                'device_id' => $params['device_id'],
                'product_id' => $params['product_id'],
                'vendor_id' => $params['vendor_id'],
                'connection_type' => $params['connection_type'],
                'printer_type' => $params['printer_type'],
                'copies' => $params['copies'],
                'paper_size' => $params['paper_size'],
                'slip_printing' => $params['slip_printing'],
            ];
            $printer = parent::create($data);
            DB::commit();
            return $printer;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updatePrinter(int $id, array $params): mixed
    {
        try {
            DB::beginTransaction();
            $data = [
                'device_id' => $params['device_id'],
                'product_id' => $params['product_id'],
                'vendor_id' => $params['vendor_id'],
                'connection_type' => $params['connection_type'],
                'printer_type' => $params['printer_type'],
                'copies' => $params['copies'],
                'paper_size' => $params['paper_size'],
                'slip_printing' => $params['slip_printing'],
            ];
            $printer = parent::update($id, $data);
            DB::commit();
            return $printer;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function destroyPrinter(int $id): mixed
    {
        try {
            $Printer = $this->repository->find($id);

            if (!$Printer) {
                return false;
            }

            $Printer->delete();

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
