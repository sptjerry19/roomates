<?php

namespace App\Services\Admin\Device;

use App\Helpers\Common;
use App\Models\Admin\SettingArea;
use App\Repositories\Admin\Device\DeviceRepository;
use App\Services\Base\BaseServiceImp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class DeviceServiceImp extends BaseServiceImp implements DeviceService
{
    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->repository = $deviceRepository;
    }

    public function getDeviceDefault(): mixed
    {
        return $this->repository->getDeviceDefault();
    }

    public function getDevices(array $attributes, ?int $page, ?int $limit): mixed
    {
        return $this->repository->getDevices($attributes, $page, $limit);
    }

    public function createDevice(array $params): mixed
    {
        try {
            DB::beginTransaction();
            $settingArea = SettingArea::create([]);
            $data = [
                'device_name' => $params['device_name'],
                'device_type' => $params['device_type'],
                'company_id' => auth()->user()->company_id,
                'shop_id' => $params['shop_id'],
                'device_code' => Common::generateCode(12),
                'ip_address' => Request::ip(),
                'version' => $params['version'] ?? null,
                'last_update' => Carbon::now()->format('Y-m-d H:i:s'),
                'setting_area_id' => $settingArea->id,
            ];
            $device = parent::create($data);
            DB::commit();
            return $device;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateDevice(int $id, array $params): mixed
    {
        try {
            DB::beginTransaction();
            $settingArea = $params['setting_area'];
            SettingArea::where('id', $settingArea['id'])->update([
                'columns' => $settingArea['columns'],
                'area_management' => $settingArea['area_management'],
                'activate_screen_2' => $settingArea['activate_screen_2'],
                'display_button_POS' => $settingArea['display_button_POS']
            ]);

            $data = [
                'device_name' => $params['device_name'],
                'device_type' => $params['device_type'],
                'company_id' => auth()->user()->company_id,
                'shop_id' => $params['shop_id'],
                'machine_type' => $params['machine_type'],
                'configure_KDS_notification' => $params['configure_KDS_notification'] ?? false,
            ];
            $device = parent::update($id, $data);
            DB::commit();
            return $device;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatusDevice(int $id, bool $status): mixed
    {
        try {
            $device = $this->repository->find($id);

            if (!$device) {
                return false;
            }

            $device->status = $status;
            $device->save();

            return $device;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function getDevicesActive(): mixed
    {
        return $this->repository->getDevicesActive();
    }
}