<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Option extends Model
{
    use HasFactory;

    protected $table = 'm_option';

    protected $guarded = [];

    public function optionsAttrs()
    {
        return $this->hasMany(OptionAttr::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'shop_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 't_product_option', 'option_id', 'product_id');
    }
}
