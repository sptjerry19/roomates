<?php

namespace App\Models\Admin;

use App\Models\Admin\Storage\Merchandise;
use App\Models\Pos\OrderAttr;
use App\Models\Pos\OrderAttrProductOption;
use App\Models\Pos\OrderAttrProductTopping;
use App\Models\Pos\OrderBefor;
use App\Models\Pos\OrderBeforProductOption;
use App\Models\Pos\OrderBeforProductTopping;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'm_product';

    protected $fillable = [
        'id',
        'name',
        'company_id',
        'product_code',
        'price',
        'unit_name',
        'unit_type',
        'vat_fee',
        'image',
        'description',
        'user_id',
        'shop_id',
        'category_id',
        'status',
        'is_topping',
        'is_product_update'
    ];

    protected $guarded = [];

    public function options()
    {
        return $this->belongsToMany(Option::class, 't_product_option', 'product_id', 'option_id');
    }

    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 't_product_topping', 'product_id', 'topping_id')
            ->withPivot('is_topping');
    }

    public function categorie()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function orderAttrs()
    {
        return $this->belongsToMany(OrderAttr::class, 't_order_attr_product', 'product_id', 'order_attr_id')
            ->withPivot('id', 'quantity', 'note', 'price', 'status', 'reason')
            ->withTimestamps();
    }

    public function shopAttrs()
    {
        return $this->belongsToMany(ShopAttr::class, 't_shop_product', 'product_id', 'shop_id');
    }

    public function sources()
    {
        return $this->belongsToMany(Source::class, 't_product_source', 'product_id', 'source_id')
            ->withPivot('price');
    }

    public function productOptions()
    {
        return $this->hasMany(OrderAttrProductOption::class, 'product_id');
    }

    public function productToppings()
    {
        return $this->hasMany(OrderAttrProductTopping::class, 'product_id');
    }

    public function productOptionsOrderBf()
    {
        return $this->hasMany(OrderBeforProductOption::class, 'product_id');
    }

    public function productToppingsOrderBf()
    {
        return $this->hasMany(OrderBeforProductTopping::class, 'product_id');
    }

    public function ordersBefor()
    {
        return $this->belongsToMany(OrderBefor::class, 't_order_befor_product', 'product_id', 'order_befor_id')
            ->withPivot('id', 'quantity', 'note', 'price', 'status', 'reason')
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function unitType(): BelongsTo
    {
        return $this->belongsTo(UnitType::class, 'unit_type');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function shops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class, 'shop_product', 'product_id', 'shop_id');
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'product_promotion');
    }

    public function merchandises(): BelongsToMany
    {
        return $this->belongsToMany(Merchandise::class, 'cost_products', 'product_id', 'merchandise_id')
            ->withPivot('option', 'quantity', 'expense')
            ->withTimestamps();
    }
}
