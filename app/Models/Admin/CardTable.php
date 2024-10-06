<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardTable extends Model
{
    use HasFactory;

    protected $table = 'm_card_table';

    protected $guarded = [];
}
