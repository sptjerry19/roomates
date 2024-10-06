<?php

namespace App\Http\Resources\Admin\Table;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
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
            'table_number' => $this->table_number,
            'area' => $this->area ?? null,
            'quanlity' => $this->quanlity,
            'table_type' => $this->table_type,
            'stt' => $this->stt,
            'user' => $this->user,
            'company' => $this->company ?? null,
            'status' => $this->status ?? null,
            'shops' => $this->shops ?? null
        ];
    }
}
