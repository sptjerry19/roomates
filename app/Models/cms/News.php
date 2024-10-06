<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class News extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'news_id',
        'site_id',
        'category_id',
        'user_create_id',
        'user_update_id',
        'lang_id',
        'create_time',
        'last_update',
        'title',
        'description',
        'body',
        'news_thumb_image_url',
        'news_hot_image_url',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'view_count',
        'google_index_status',
        'google_index_time',
        'allow_comment',
        'show_in_homepage',
        'is_hotnews',
        'status',
    ];
    protected $primaryKey = 'news_id';
    protected $table = 'news';

    // relationship one to many website to news
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'site_id', 'site_id');
    }

    // relationship one to many category to news
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    // relationship many to one news with languages
    public function language(): HasOne
    {
        return $this->hasOne(Language::class, 'lang_id', 'lang_id');
    }
}
