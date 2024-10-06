<?php

namespace App\Models\Admin\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost_product_name',
        'cost_product_price',
        'cost_product_description',
        'cost_product_quantity',
    ];
}
