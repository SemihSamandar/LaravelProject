<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCart extends Model
{
    protected $table = 'shopping_carts';

    protected $fillable = [
        'product_id',
        'session_id',
        'user_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    /**
     * Ürünle ilişki
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Kullanıcıyla ilişki
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Toplam fiyat hesapla
     */
    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }

    /**
     * Session ID'den sepeti al
     */
    public static function getBySessionId(string $sessionId)
    {
        return self::where('session_id', $sessionId)->with('product')->get();
    }

    /**
     * User ID'den sepeti al
     */
    public static function getByUserId(int $userId)
    {
        return self::where('user_id', $userId)->with('product')->get();
    }

    /**
     * Sepetteki toplam tutarı hesapla
     */
    public function scopeTotal($query)
    {
        return $query->selectRaw('SUM(quantity * price) as total');
    }
}
