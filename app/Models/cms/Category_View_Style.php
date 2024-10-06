<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category_View_Style extends Model
{
    use HasFactory;

    public $fillable = [
        'lang_id',
        'category_view_code',
        'category_view_style_name',
    ];

    public $primarykey = 'category_view_style_id';

    public $table = 'category_view_style';

    // relationship one to many category_view_style with category
    public function category(): HasMany
    {
        return $this->hasMany(Category::class, 'category_view_style_id', 'category_view_style_id');
    }

    // relationship one to one category_view_style with language
    public function language(): HasOne
    {
        return $this->hasOne(Language::class, 'lang_id', 'lang_id');
    }
}
