<?php

namespace App\Http\Resources\Admin\Source;

use App\Models\Admin\SourceValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SourceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $companyId = auth()->user()->company_id;
        $sourceValue = SourceValue::query()->where('source_id', $this->id)->where('company_id', $companyId)->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $sourceValue ? ($sourceValue->value < 100 ? null : $sourceValue->value) : null,
            'percent' => $sourceValue ? ($sourceValue->value < 100 ? $sourceValue->value : null) : null,
        ];
    }
}
