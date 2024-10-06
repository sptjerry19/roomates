<?php

namespace App\Http\Resources\Admin\Promotion;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
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
            'company_id' => $this->company_id,
            'shops' => $this->shops ? $this->shops->map(function ($shop) {
                return [
                    'id' => $shop->id,
                    'name' => $shop->name,
                ];
            }) : null,

            'products' => $this->products ? $this->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                ];
            }) : null,
            'name' => $this->name,
            'discount' => $this->discount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'time_slots' => json_decode($this->time_slots), // Decode JSON time_slots
            'days_of_week' => json_decode($this->days_of_week), // Decode JSON days_of_week
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'), // Format created_at
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'), // Format updated_at
        ];
    }
}
