<?php

namespace App\Models\Pos;

use App\Models\Admin\PayBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'm_order';

    protected $guarded = [];

    public function orderType() {
        return $this->belongsTo(UsageType::class, 'usage_type_id');
    }

    public function orderDineIn()
    {
        return $this->hasOne(OrderDineIn::class);
    }

    public function orderShip()
    {
        return $this->hasOne(OrderShip::class);
    }

    public function orderAttrs()
    {
        return $this->hasMany(OrderAttr::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function payBy()
    {
        return $this->belongsTo(PayBy::class, 'pay_by_id');
    }

    public function shipper()
    {
        return $this->belongsTo(Shipper::class,'shipper_id');
    }
}
