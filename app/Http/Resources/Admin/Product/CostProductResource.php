<?php

namespace App\Http\Resources\Admin\Product;

use App\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CostProductResource extends JsonResource
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
            'price' => floatval($this->price),
            'image' => isset($this->image) ? Common::responseProductImage($this->image) : null,
            'merchandises' => isset($this->merchandises) ? $this->merchandises->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'unit_price' => floatval($item->unit_price),
                    'image' => isset($item->image) ? Common::responseProductImage($item->image) : null,
                    'unit' => isset($item->unit) ? $item->unit : null,
                    'quantity' => floatval($item->pivot->quantity),
                    'expense' => floatval($item->pivot->expense),
                    'mass_type' => isset($item->unit) ? $item->unit->mass_type : null,
                ];
            }) : null,
            'status' =>  $this->status,
            'cost' => isset($this->merchandises) ?  $this->merchandises->sum(function ($item) {
                return $item->pivot->expense;
            }) : 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
