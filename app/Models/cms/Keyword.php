<?php

namespace App\Models\cms;

use App\Models\Group;
use App\Models\Proxy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keyword extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'keywords',
        'times',
        'times_error',
        'group_id',
        'ip',
        'browser',
        'last_proxy',
        'time_change_ip'
    ];

    protected $table = 'keywords';

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function stats()
    {
        return $this->hasMany(KeywordStat::class);
    }

    public function statsForToday()
    {
        return $this->stats()->whereDate('date', Carbon::today());
    }
}
