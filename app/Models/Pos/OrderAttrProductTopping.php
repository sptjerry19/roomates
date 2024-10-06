<?php

namespace App\Models\Pos;

use App\Models\Admin\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAttrProductTopping extends Model
{
    use HasFactory;

    protected $table = 'm_order_attr_product_topping';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
