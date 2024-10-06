<?php

namespace App\Http\Resources\Admin\Topping;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToppingResource extends JsonResource
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
            'product_count' => $this->products->count() ?? null,
            'products' => $this->products->filter(function ($product) {
                $product->price = (int) $product->price;
                return $product->pivot->is_topping == false; // Lọc các product có status là 'active'
            })->values() ?? null,
            'toppings' => $this->products->filter(function ($product) {
                return $product->pivot->is_topping == true; // Lọc các product có status là 'active'
            })
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => (int) $product->price,
                        'status' => $product->status,
                    ];
                })->values(),
            // 'toppings' => $this->toppings ?? null,
            'status' => $this->status,
        ];
    }
}
