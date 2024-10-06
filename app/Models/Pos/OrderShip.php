<?php

namespace App\Models\pos;

use App\Models\Admin\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShip extends Model
{
    use HasFactory;

    protected $table = 'm_order_ship';

    protected $guarded = [];
}
