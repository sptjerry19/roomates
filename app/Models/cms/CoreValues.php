<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoreValues extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'aboutus_id',
        'lang_id',
        'name',
        'content',
        'image_url',
        'status'
    ];

    protected $table = 'core_values';

    public function aboutus(): BelongsTo
    {
        return $this->belongsTo(Aboutus::class, 'aboutus_id');
    }
}
