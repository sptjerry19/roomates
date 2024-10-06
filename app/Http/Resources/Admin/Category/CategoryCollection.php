<?php

namespace App\Http\Resources\Admin\Category;

use App\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->filter(function ($resource) {
                return isset($resource->name) && $resource->name !== "Combo";
            })->values(),

            'pagination' => Common::CollectionPagination($this),
        ];
    }
}
