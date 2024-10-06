<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faqs extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'site_id',
        'lang_id',
        'question',
        'answer',
        'status'
    ];
    protected $primaryKey = 'id';
    protected $table = 'faqs';

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'lang_id', 'lang_id');
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'site_id', 'site_id');
    }

    public function faqsGroup(): BelongsTo
    {
        return $this->belongsTo(FaqsGroup::class, 'faqs_group_id');
    }
}
