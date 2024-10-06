<?php

namespace App\Http\Resources\Admin\Combo;

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
                if (is_array($options)) {
                    foreach ($options as &$item) {
                        if (isset($item['option_id'])) {
                            $option = Option::query()->find($item['option_id']);
                            $item['name'] = $option ? $option->name : 'Unknown';
                        } else {
                            $item['name'] = 'Unknown'; // Trường hợp 'option_id' không tồn tại
                        }
                    }
                }

                // Giải mã toppings và kiểm tra nếu là mảng hợp lệ
                $toppings = json_decode($product->pivot->toppings, true) ?? [];
                if (is_array($toppings)) {
                    foreach ($toppings as &$item) {
                        if (isset($item['toppings']) && is_array($item['toppings'])) {
                            foreach ($item['toppings'] as &$topping) {
                                if (isset($topping['topping_id'])) {
                                    $toppingModel = Product::find($topping['topping_id']);
                                    if ($toppingModel) {
                                        $topping['topping'] = $toppingModel;
                                    } else {
                                        $topping['topping'] = 'Unknown'; // Xử lý khi không tìm thấy sản phẩm
                                    }
                                }
                            }
                        }
                    }
                }

                // Trả về mảng kết quả cho mỗi sản phẩm
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price_combo' => (int) $product->pivot->price ?? (int) $product->price, // Lấy giá combo hoặc giá thông thường
                    'quanlity' => $product->pivot->quanlity, // Số lượng
                    'options' => $options, // Các options đã được giải mã và xử lý
                    'toppings' => $toppings, // Các toppings đã được giải mã và xử lý
                ];
            }),
            'shops' => $this->shops->map(function ($shop) {
                return [
                    'id' => $shop->id,
                    'name' => $shop->name,
                ];
            }),
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'), // Format created_at
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'), // Format updated_at
        ];
    }

    // public function toArray(Request $request): array
    // {
    //     // Lấy tất cả các option và topping một lần dựa trên option_id và topping_id
    //     $optionIds = collect($this->products)->pluck('pivot.options')->filter()->map(function ($options) {
    //         return collect(json_decode($options, true))->pluck('option_id');
    //     })->flatten()->unique();

    //     $toppingIds = collect($this->products)->pluck('pivot.toppings')->filter()->map(function ($toppings) {
    //         return collect(json_decode($toppings, true))->pluck('topping_id');
    //     })->flatten()->unique();

    //     $options = Option::whereIn('id', $optionIds)->get()->keyBy('id');
    //     $toppings = ToppingAttr::whereIn('id', $toppingIds)->get()->keyBy('id');

    //     return [
    //         'id' => $this->id,
    //         'name' => $this->name,
    //         'price' => $this->price,
    //         'vat' => $this->vat,
    //         'code' => $this->code,
    //         'description' => $this->description,
    //         'image' => $this->image,
    //         'start_date' => $this->start_date,
    //         'end_date' => $this->end_date,
    //         'time_slots' => json_decode($this->time_slots), // Decode JSON time_slots
    //         'days_of_week' => json_decode($this->days_of_week), // Decode JSON days_of_week
    //         'products' => $this->products->map(function ($product) use ($options, $toppings) {
    //             // Ánh xạ options
    //             $productOptions = json_decode($product->pivot->options, true);
    //             foreach ($productOptions as &$item) {
    //                 $option = $options->get($item['option_id']);
    //                 $item['name'] = $option ? $option->name : 'Unknown';
    //             }

    //             // Ánh xạ toppings
    //             $productToppings = json_decode($product->pivot->toppings, true);
    //             foreach ($productToppings as &$item) {
    //                 $topping = $toppings->get($item['topping_id']);
    //                 $item['name'] = $topping ? $topping->name : 'Unknown';
    //             }

    //             return [
    //                 'name' => $product->name,
    //                 'price_combo' => (int) $product->pivot->price ?? (int) $product->price,
    //                 'quanlity' => $product->pivot->quanlity,
    //                 'options' => $productOptions,
    //                 'toppings' => $productToppings,
    //             ];
    //         }),
    //         // 'shops' => $this->shops->pluck('name'), // Hoặc bạn có thể trả thêm thông tin khác của shop
    //         'status' => $this->status,
    //         'created_at' => $this->created_at->format('Y-m-d H:i:s'), // Format created_at
    //         'updated_at' => $this->updated_at->format('Y-m-d H:i:s'), // Format updated_at
    //     ];
    // }
}
