<?php

namespace App\Http\Resources\Pos\Combo;

use App\Http\Resources\Admin\Topping\ToppingResource;
use App\Models\Admin\Option;
use App\Models\Admin\Product;
use App\Models\Admin\Topping;
use App\Models\Admin\ToppingAttr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComboResource extends JsonResource
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
            'price' => (int) $this->price,
            'vat' => floatval($this->vat),
            'code' => $this->code,
            'description' => $this->description,
            'image' => $this->image,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'time_slots' => json_decode($this->time_slots), // Decode JSON time_slots
            'days_of_week' => json_decode($this->days_of_week), // Decode JSON days_of_week
            'products' => $this->products->map(function ($product) {
                // Giải mã options và kiểm tra nếu là mảng hợp lệ
                $options = json_decode($product->pivot->options, true) ?? [];
                foreach ($options as &$item) {
                    $option = Option::query()->find($item['option_id']);
                    $item['name'] = $option ? $option->name : 'Unknown';
                }

                // Giải mã toppings và kiểm tra nếu là mảng hợp lệ
                $toppings = json_decode($product->pivot->toppings, true) ?? [];
                if (is_array($toppings)) {
                    foreach ($toppings as &$item) {
                        if (isset($item['toppings']) && is_array($item['toppings'])) {
                            foreach ($item['toppings'] as &$topping) {
                                $toppingModel = Product::find($topping['topping_id']);

                                if ($toppingModel) {
                                    $topping['topping'] = $toppingModel;
                                }
                            }
                        }
                    }
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price_combo' => (int) $product->pivot->price ?? (int) $product->price,
                    'quanlity' => $product->pivot->quanlity,
                    'options' => $options,
                    'toppings' => $toppings,
                ];
            }),
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'), // Format created_at
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'), // Format updated_at
        ];
    }
}
