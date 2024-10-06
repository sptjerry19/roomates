<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    use HasFactory;

    protected $table = 'm_source';

    protected $guarded = [];

    public function sourceValue(): HasMany
    {
        return $this->hasMany(SourceValue::class, 'source_id');
    }
}
