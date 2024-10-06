<?php

namespace App\Http\Resources\Pos\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayByResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "image" => $this->image,
            "pay_code" => $this->pay_code,
            "payment_fee" => $this->payment_fee,
        ];
    }
}
