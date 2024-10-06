<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'shop_id',
        'setting_area_id',
        'device_name',
        'device_type',
        'device_code',
        'ip_address',
        'version',
        'machine_serial_number',
        'last_update',
        'machine_type',
        'configure_KDS_notification',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'device_category', 'device_id', 'category_id');
    }

    public function setting_areas(): BelongsTo
    {
        return $this->belongsTo(SettingArea::class, 'setting_area_id');
    }

    public function hide_categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'device_category', 'device_id', 'category_id');
    }

    public function printers(): HasMany
    {
        return $this->hasMany(Printer::class, 'device_id');
    }
}
