<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Topping extends Model
{
    use HasFactory;

    protected $table = 'm_topping';

    protected $guarded = [];

    public function toppingAttrs()
    {
        return $this->hasMany(ToppingAttr::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 't_product_topping', 'topping_id', 'product_id')
                    ->withPivot('is_topping');
    }

    public function toppings(): BelongsToMany
    {
        return $this->belongsToMany(ToppingAttr::class, 'topping_topping_attr', 'topping_id', 'topping_attr_id');
    }
}