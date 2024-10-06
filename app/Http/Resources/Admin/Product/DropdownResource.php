<?php

namespace App\Http\Resources\Admin\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DropdownResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->resource;
        return [
            'products' => $data['products'],
            'categories' => $data['categories']->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'code' => $item['code'],
                    'products' => $item->products->filter(function ($product) {
                        return $product->status === 'active';
                    })->map(function ($product) {
                        return $product['id'];
                    })->values()->all(),
                ];
            }),
            'combos' => $data['combos']->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'code' => $item['code'],
                    'products' => $item->products->filter(function ($product) {
                        return $product->status === 'active';
                    })->map(function ($product) {
                        return $product['id'];
                    })->values()->all(),
                ];
            }),
        ];
    }
}
