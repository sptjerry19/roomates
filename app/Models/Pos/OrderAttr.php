<?php

namespace App\Models\Pos;

use App\Models\Admin\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderAttr extends Model
{
    use HasFactory;

    protected $table = 'm_order_attr';

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 't_order_attr_product', 'order_attr_id', 'product_id')
                    ->withPivot('id', 'quantity', 'note', 'price', 'status', 'reason')
                    ->with('productOptions', 'productToppings')
                    ->withTimestamps();
    }

    public function options()
    {
        return $this->hasMany(OrderAttrProductOption::class, 'order_attr_id');
    }

    public function toppings()
    {
        return $this->hasMany(OrderAttrProductTopping::class, 'order_attr_id');
    }
}
