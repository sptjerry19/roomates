<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Data_source extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'data_source_id',
        'lang_id',
        'data_source_table',
        'data_source_name_view'
    ];

    protected $table = 'data_source';

    protected $primaryKey = 'data_source_id';

    // relationship many to one category with data source
    public function category(): HasMany
    {
        return $this->hasMany(Category::class, 'data_source_id', 'data_source_id');
    }
}
