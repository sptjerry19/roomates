<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasFactory;

    protected $table = 'm_shop';

    protected $guarded = [];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'shop_product', 'shop_id', 'product_id');
    }

    public function payBys(): BelongsToMany
    {
        return $this->belongsToMany(PayBy::class, 't_shop_pay', 'shop_id', 'pay_id');
    }

    public function cardTables(): HasMany
    {
        return $this->hasMany(CardTable::class, 'shop_id');
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class, 'shop_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_shop');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
