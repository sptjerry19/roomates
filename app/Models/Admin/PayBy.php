<?php

namespace App\Models\Admin;

use App\Models\Pos\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PayBy extends Model
{
    use HasFactory;

    protected $table = 'm_pay_by';

    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function shops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class, 't_shop_pay', 'pay_id', 'shop_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'shop_id');
    }
}
