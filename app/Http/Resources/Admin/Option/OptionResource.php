<?php

namespace App\Http\Resources\Admin\Option;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
            'user' => $this->user,
            'company' => $this->company ?? null,
            'allowed_dishes' => $this->allowed_dishes ?? false,
            'allow_min' => $this->allow_min,
            'allow_max' => $this->allow_max,
            'company' => $this->company ?? null,
            'products' => $this->products ?? null,
            'count_product' => $this->products->count() ?? null,
            'option_attr' => isset($this->optionsAttrs) ? collect($this->optionsAttrs)->map(function ($attr) {
                $attr['price'] = (int) $attr['price'];
                return $attr;
            })->toArray() : null,
            'created_at' => $this->created_at,
            'status' => $this->status ?? null,
        ];
    }
}
