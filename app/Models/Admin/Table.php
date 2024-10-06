<?php

namespace App\Models\Admin;

use App\Models\Pos\OrderBefor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Table extends Model
{
    use HasFactory;

    protected $table = 'm_table';

    protected $guarded = [];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function orderBefor()
    {
        return $this->hasMany(OrderBefor::class, 'table_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function shops(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}