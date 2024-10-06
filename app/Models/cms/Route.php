<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Route extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'category_id',
        'region_id',
        'is_hot_sale',
        'name',
        'description',
        'content',
        'image_url',
        'price_from',
        'take_time',
        'status',
    ];
    protected $table = 'routes';
}
