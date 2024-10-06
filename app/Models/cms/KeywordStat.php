<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeywordStat extends Model
{
    use HasFactory;

    protected $fillable = ['keyword_id', 'date', 'times', 'time_change_ip'];

    public function keyword()
    {
        return $this->belongsTo(Keyword::class);
    }
}
