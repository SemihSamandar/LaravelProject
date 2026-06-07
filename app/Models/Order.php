<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'total_price',
        'status',
    ];

    // Eğer varsa ilişkilerini (belongsTo, hasMany) buranın altına eklemeye devam edebilirsin.
    public function items()
    {
        // Bir siparişin birden fazla sipariş öğesi (OrderItem) olur
        return $this->hasMany(OrderItem::class);
    }
}