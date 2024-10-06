<?php

namespace App\Models\Pos;

use App\Models\Admin\Product;
use App\Models\Admin\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBefor extends Model
{
    use HasFactory;

    protected $table = 'm_order_befor';

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 't_order_befor_product', 'order_befor_id', 'product_id')
                    ->withPivot('quantity', 'note', 'price')
                    ->with('productOptionsOrderBf', 'productToppingsOrderBf')
                    ->withTimestamps();
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    public function options()
    {
        return $this->hasMany(OrderBeforProductOption::class, 'order_befor_id');
    }

    public function toppings()
    {
        return $this->hasMany(OrderBeforProductTopping::class, 'order_befor_id');
    }
}
