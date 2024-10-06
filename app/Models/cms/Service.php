<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'contents',
        'image_url',
        'status',
    ];
    protected $primaryKey = 'id';
    protected $table = 'services';
}
