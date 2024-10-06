<?php

namespace App\Models\Pos;

use App\Models\Admin\Area;
use App\Models\Admin\CardTable;
use App\Models\Admin\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDineIn extends Model
{
    use HasFactory;

    protected $table = 'm_order_dine_in';

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function cardTable()
    {
        return $this->belongsTo(CardTable::class);
    }
}
