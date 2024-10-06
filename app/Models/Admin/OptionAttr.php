<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionAttr extends Model
{
    use HasFactory;

    protected $table = 'm_option_attr';

    protected $guarded = [];
}
