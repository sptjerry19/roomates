<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "company_id" => $this->company_id,
            "shop_id" => $this->shop_id,
            "name" => $this->name,
            "email" => $this->email,
            "email_verified_at" => $this->email_verified_at,
            "verification_code" => $this->verification_code,
            "phone" => $this->phone,
            "avatar" => $this->avatar,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "status" => $this->status,
            "sex" => $this->sex,
            "address" => $this->address,
            "birth_date" => $this->birth_date,
            "provider" => $this->provider,
            "provider_id" => $this->provider_id,
            "company" => $this->company
        ];
    }
}
