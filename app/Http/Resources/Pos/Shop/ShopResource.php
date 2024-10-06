<?php

namespace App\Http\Resources\Pos\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "company_id" => $this->company_id,
            "name" => $this->name,
            "pay_bys" => PayByResource::collection($this->whenLoaded('payBys'))
        ];
    }
}
