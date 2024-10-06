<?php

namespace App\Http\Resources\Admin\Device;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'device_name' => $this->device_name,
            'device_type' => $this->device_type,
            'company' => $this->company,
            'shop' => $this->shop,
            'device_code' => $this->device_code,
            'ip_address' => $this->ip_address,
            'version' => $this->version,
            'machine_serial_number' => $this->machine_serial_number,
            'machine_type' => $this->machine_type,
            'configure_KDS_notification' => $this->configure_KDS_notification,
            'hide_categories' => $this->hide_categories ?? null,
            'setting_area' => isset($this->setting_area_id) ? $this->setting_areas : null,
            'printers' => $this->printers ?? null,
            'last_update' => Carbon::createFromFormat('Y-m-d H:i:s', $this->last_update)->format('H:i - d/m/Y'),
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ];
    }
}
