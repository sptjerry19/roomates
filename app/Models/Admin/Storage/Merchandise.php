<?php

namespace App\Models\Admin\Storage;

use App\Models\Admin\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Merchandise extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function storages(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class, 'shop_storage_merchandises', 'merchandise_id', 'storage_id')
            ->withPivot('quantity', 'total_price');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function commodity(): BelongsTo
    {
        return $this->belongsTo(CommodityGroup::class, 'commodity_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
