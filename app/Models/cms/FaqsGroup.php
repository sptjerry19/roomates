<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqsGroup extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'faqs_group';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'site_id',
        'lang_id',
        'group_name'
    ];

    public function faqs(): HasMany
    {
        return $this->hasMany(Faqs::class, 'faqs_group_id');
    }
}
