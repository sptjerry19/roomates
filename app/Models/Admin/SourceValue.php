<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SourceValue extends Model
{
    use HasFactory;

    protected $table = 'source_values';

    protected $fillable = [
        'company_id',
        'source_id',
        'shop_id',
        'value',
        'refund_percentage',
        'bill_type',
        'payment_method',
        'require_partner_code',
        'revenue_includes_shipping',
        'menu_price_increase_percentage',
        'marketing_support_percentage',
        'voucher_code',
        'marketing_start_date',
        'marketing_end_date',
        'apply_on_mon',
        'apply_on_tue',
        'apply_on_wed',
        'apply_on_thu',
        'apply_on_fri',
        'apply_on_sat',
        'apply_on_sun',
        'apply_hour_0',
        'apply_hour_1',
        'apply_hour_2',
        'apply_hour_3',
        'apply_hour_4',
        'apply_hour_5',
        'apply_hour_6',
        'apply_hour_7',
        'apply_hour_8',
        'apply_hour_9',
        'apply_hour_10',
        'apply_hour_11',
        'apply_hour_12',
        'apply_hour_13',
        'apply_hour_14',
        'apply_hour_15',
        'apply_hour_16',
        'apply_hour_17',
        'apply_hour_18',
        'apply_hour_19',
        'apply_hour_20',
        'apply_hour_21',
        'apply_hour_22',
        'apply_hour_23',
        'status',
    ];


    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
