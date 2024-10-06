<?php

namespace App\Http\Resources\Admin\Area;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
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
            'name' => $this->name,
            'area_code' => $this->area_code,
            'stt' => $this->stt,
            'user' => $this->user ?? null,
            'company' => $this->company ?? null,
            'shop' => $this->shop ?? null,
            'tables' => $this->tables->where('status', 'available')->values() ?? null,
            'number_tables' => $this->tables->where('status', 'available')->count() ?? null,
            'status' => $this->status
        ];
    }
}
