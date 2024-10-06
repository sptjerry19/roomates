<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions';

    protected $fillable = [
        'company_id',
        'name',
        'discount',
        'start_date',
        'end_date',
        'time_slots',
        'days_of_week',
        'status'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_promotion');
    }

    public function shops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class, 'promotion_shop');
    }
}
