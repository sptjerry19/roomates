<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'm_customer';

    protected $guarded = [];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
