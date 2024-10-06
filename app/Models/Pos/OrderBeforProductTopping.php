<?php

namespace App\Models\Pos;

use App\Models\Admin\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBeforProductTopping extends Model
{
    use HasFactory;

    protected $table = 'm_order_befor_product_topping';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
