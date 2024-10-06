<?php

namespace App\Models\cms;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Products extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    protected $table = 'products';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_id',
        'lang_id',
        'category_id',
        'product_name',
        'product_title',
        'product_description',
        'product_body',
        'product_public_price',
        'product_price',
        'product_packing_specifications',
        'product_weight',
        'weight_unit',
        'currency',
        'product_color',
        'product_origin',
        'product_image_url1',
        'product_image_url2',
        'product_image_url3',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'show_in_homepage',
        'status',
    ];

    // public function users(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'sites', 'sites_meta_id', 'users_id');
    // }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'site_id', 'site_id');
    }

    public function language(): HasOne
    {
        return $this->hasOne(Language::class, 'lang_id', 'lang_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'category_id', 'category_id');
    }
}
