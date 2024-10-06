<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageType extends Model
{
    use HasFactory;

    protected $table = 'm_usage_type';

    protected $guarded = [];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
