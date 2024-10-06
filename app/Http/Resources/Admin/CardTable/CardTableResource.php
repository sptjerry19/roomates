<?php

namespace App\Http\Resources\Admin\CardTable;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardTableResource extends JsonResource
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
            'card_tables' => $this->cardTables && $this->cardTables->isNotEmpty()
                ? $this->cardTables->map(function ($card) {
                    return [
                        'id' => $card->id,
                        'name' => $card->name,
                        'status' => $card->status,
                    ];
                })->values()
                : $this->cardTables, // Trả về các thẻ không thỏa mãn nếu có
        ];
    }
}
