<?php

namespace App\Http\Resources\Admin\PaymentMethod;

use App\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            "image" => isset($this->image) ? Common::responseProductImage($this->image) : null,
            "pay_code" =>  $this->pay_code,
            "payment_fee" => floatval($this->payment_fee),
            "shops" => $this->shops->map(function ($shops) {
                return [
                    "id" => $shops->id,
                    "name" => $shops->name,
                ];
            }),
            "status" => $this->status,
            "created_at" => $this->createdAt,
            "updated_at" => $this->updated_at
        ];
    }
}
