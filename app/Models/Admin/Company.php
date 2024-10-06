<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'company_name',
        'representative_name',
        'office_name',
        'phone',
        'address',
        'email',
        'relevant_emails',
        'position',
        'tax_code',
        'fax',
        'bank_account_number',
        'bank_account_name',
        'bank',
        'logo',
        'note',
        'commission_percent',
        'balance',
        'depart_fee',
        'export_ticket_fee',
        'display_price',
        'status',
    ];

    // Các thuộc tính cần chuyển đổi
    protected $casts = [
        'commission_percent' => 'float',
        'balance' => 'decimal:2',
        'depart_fee' => 'float',
        'export_ticket_fee' => 'float',
        'display_price' => 'boolean',
        'status' => 'integer',
    ];
}
