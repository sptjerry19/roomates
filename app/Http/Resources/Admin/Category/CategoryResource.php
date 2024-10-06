<?php

namespace App\Http\Resources\Admin\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'company' => $this->company->name ?? null,
            'count_products' => $this->products->count() ?? null,
            'shop' => $this->shop ?? null,
            'code' => $this->code ?? null,
            'status' => $this->status
        ];
    }
}
