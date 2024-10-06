<?php

namespace App\Http\Resources\Admin\Merchandise;

use App\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchandiseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>  $this->id,
            "image" => !is_null($this->image) ? Common::responseProductImage($this->image) : null,
            "name" => $this->name,
            "code" =>  $this->code,
            "type" =>  $this->type,
            "unit" => [
                'id' =>  $this->unit->id,
                'name' =>  $this->unit->name,
                'quantity' => floatval($this->unit->quantity),
                'mass_type' =>  $this->unit->mass_type,
            ],
            "commodity_group" => [
                'id' =>  $this->commodity->id,
                'name' =>  $this->commodity->name,
            ],
            "unit_price" =>  floatval($this->unit_price),
            "description" =>  $this->description,
            "tracking_status" =>  $this->tracking_status,
            "user" => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            "storages" => $this->storages
                ->filter(function ($item) {
                    return !is_null($item->storage_code); // Lọc các item có storage_code khác null
                })
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->storage_code . ' - ' . $item->name,
                        'quantity' => floatval($item->pivot->quantity),
                        'total_price' => floatval($item->pivot->total_price),
                    ];
                }),
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
