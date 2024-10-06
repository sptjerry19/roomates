<?php

namespace App\Models;

use App\Models\cms\Keyword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    protected $table = 'groups';

    public function keywords(): HasMany
    {
        return $this->hasMany(Keyword::class, 'group_id');
    }
}
