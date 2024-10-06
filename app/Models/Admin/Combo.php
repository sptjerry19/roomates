<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Combo extends Model
{
    use HasFactory;

    // Khai báo các trường có thể được fill bằng cách sử dụng thuộc tính fillable
    protected $fillable = [
        'company_id',
        'name',
        'price',
        'vat',
        'code',
        'description',
        'image_url',
        'start_date',
        'end_date',
        'time_slots',
        'days_of_week',
        'status'
    ];

    /**
     * Định nghĩa quan hệ với bảng shops (many-to-many)
     */
    public function shops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class, 'combo_shops', 'combo_id', 'shop_id');
    }

    /**
     * Định nghĩa quan hệ với bảng products (many-to-many)
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'combo_product', 'combo_id', 'product_id')
            ->withPivot('price', 'quanlity', 'options', 'toppings');
    }

    /**
     * Tính tổng giá combo bao gồm VAT
     */
    public function getTotalPriceAttribute()
    {
        return $this->price + ($this->price * $this->vat / 100);
    }
}
