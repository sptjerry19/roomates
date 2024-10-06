<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoRegistration extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'site_id',
        'user_id_handled',
        'handled_time',
        'contact_name',
        'contact_phone',
        'contact_email',
        'contact_address',
        'contact_company_name',
        'contact_company_size',
        'contact_message',
        'registration_ip_address',
        'handled_status',
        'username_handle',
        'name_handle',
        'create_at',
    ];
    protected $primaryKey = 'registration_id';

    protected $table = 'product_demo_registration';
}