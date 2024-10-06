<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jobs extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'job_id',
        'site_id',
        'lang_id',
        'category_id',
        'job_position',
        'job_description',
        'job_number',
        'job_region',
        'salary_from',
        'salary_to',
        'date_expire',
        'status',
    ];
    protected $primaryKey = 'job_id';
    protected $table = 'jobs';

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'lang_id', 'lang_id');
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'site_id', 'site_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
