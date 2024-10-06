<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'product_id',
        'vendor_id',
        'connection_type',
        'printer_type',
        'copies',
        'paper_size',
        'slip_printing',
    ];
}
