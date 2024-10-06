<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
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
        'parent_id',
        'lang_id',
        'category_view_style_id',
        'data_source_id',
        'category_name',
        'status',
        'category_title',
        'category_description',
        'category_content',
        'category_banner_url',
        'category_banner_mobile_url',
        'category_videos_url',
        'category_order_number',
        'category_meta_alias',
        'category_meta_title',
        'category_meta_description',
        'category_meta_keywords',
        'hyper_link',
        'is_single_page',
        'show_in_menu',
        'status',
        'site_id',
    ];

    protected $primaryKey = 'category_id';
    protected $table = 'categories';

    // relationship many to one category with category_view_style
    public function category_View_Style(): BelongsTo
    {
        return $this->belongsTo(Category_View_Style::class, 'category_view_style_id', 'category_view_style_id');
    }

    // relationship many to one category with languages
    public function language(): HasOne
    {
        return $this->hasOne(Language::class, 'lang_id', 'lang_id');
    }

    // relationship many to one category with website
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'site_id', 'site_id');
    }

    // relationship many to one category with data source
    public function data_source(): BelongsTo
    {
        return $this->belongsTo(Data_source::class, 'data_source_id', 'data_source_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'category_id');
    }
}
