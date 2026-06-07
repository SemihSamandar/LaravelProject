<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function product()
    {
        // Her sipariş kalemi tek bir ürüne (Product) aittir
        return $this->belongsTo(Product::class);
    }

}