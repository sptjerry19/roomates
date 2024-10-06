<?php

namespace App\Http\Resources\Admin\Product;

use App\Helpers\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "company_id" => $this->company_id,
            "product_code" => $this->product_code,
            "price" => (int) $this->price,
            "unit_name" => $this->unit_name,
            "unit_type" => $this->unit_type,
            "vat_fee" => round((float) $this->vat_fee, 1),
            "image" => isset($this->image) ? Common::responseProductImage($this->image) : null,
            "description" => $this->description,
            "user_id" => $this->user_id,
            "user" => $this->user,
            "category_id" => $this->category_id,
            "category" => $this->category,
            "options" => $this->options ?? null,
            "status" => $this->status ?? null,
            'shops' => $this->shops ? $this->shops->map(function ($shop) {
                return [
                    'id' => $shop->id,
                    'name' => $shop->name,
                ];
            }) : null,
            'sources' => $this->sources ? $this->sources->map(function ($source) {
                return [
                    'id' => $source->id,
                    'name' => $source->name,
                    'price' => (int) $source->pivot->price
                ];
            }) : null,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}