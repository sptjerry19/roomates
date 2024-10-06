<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;

    protected $table = 'm_shipper';

    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class, 'shipper_id');
    }
}
