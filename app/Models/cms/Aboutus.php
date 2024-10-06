<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Aboutus extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'site_id',
        'user_create_id',
        'user_update_id',
        'lang_id',
        'title',
        'description',
        'body',
        'about_image_url',
        'core_values_title',
        'core_values_description',
        'core_values_image_url',
        'core_values_image_mobile_url',
        'more_contents_title',
        'more_contents_description',
        'more_contents_image_url',
        'more_contents_image_mobile_url',
        'view_count',
        'google_index_status',
        'create_at',
        'last_update',
        'google_index_time',
        'allow_comment',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'status',
    ];

    protected $table = 'aboutus';

    public function language(): HasOne
    {
        return $this->hasOne(Language::class, 'lang_id', 'lang_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'site_id', 'site_id');
    }

    public function core_values(): HasMany
    {
        return $this->hasMany(CoreValues::class, 'aboutus_id');
    }
}
