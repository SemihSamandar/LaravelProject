<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    /**
     * Sepeti getir
     */
    public function index(Request $request): JsonResponse
    {
        $sessionId = session()->getId();
        $userId = auth()->id();

        $cartItems = ShoppingCart::query()
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            }, function ($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->with('product')
            ->get();

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->price);
        $count = $cartItems->count();

        return response()->json([
            'success' => true,
            'items' => $cartItems,
            'total' => $total,
            'count' => $count,
        ]);
    }

    /**
     * Sepete ürün ekle
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'integer|min:1|max:100',
            ]);

            $product = Product::findOrFail($request->product_id);
            $quantity = $request->quantity ?? 1;
            $sessionId = session()->getId();
            $userId = auth()->id();

            // Stok kontrolü
            if ($product->stock < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Yeterli stok bulunmamaktadır.',
                ], 422);
            }

            // Aynı ürün var mı kontrol et
            $cartItem = ShoppingCart::query()
                ->where('product_id', $product->id)
                ->when($userId, function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }, function ($query) use ($sessionId) {
                    return $query->where('session_id', $sessionId);
                })
                ->first();

            if ($cartItem) {
                // Varsa miktarını arttır
                $newQuantity = $cartItem->quantity + $quantity;

                if ($product->stock < $newQuantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Yeterli stok bulunmamaktadır.',
                    ], 422);
                }

                $cartItem->update(['quantity' => $newQuantity]);
            } else {
                // Yeni sepet öğesi oluştur
                ShoppingCart::create([
                    'product_id' => $product->id,
                    'session_id' => $userId ? null : $sessionId,
                    'user_id' => $userId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => $product->name . ' sepete eklendi.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sepet öğesini güncelle
     */
    public function update(Request $request, ShoppingCart $cart): JsonResponse
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:100',
            ]);

            // Yetkilendirme kontrolü
            if (auth()->check()) {
                if ($cart->user_id !== auth()->id()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bu işlemi yapmaya yetkiniz yok.',
                    ], 403);
                }
            } else {
                if ($cart->session_id !== session()->getId()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bu işlemi yapmaya yetkiniz yok.',
                    ], 403);
                }
            }

            // Stok kontrolü
            if ($cart->product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Yeterli stok bulunmamaktadır.',
                ], 422);
            }

            $cart->update(['quantity' => $request->quantity]);

            return response()->json([
                'success' => true,
                'message' => 'Sepet güncellendi.',
                'item' => $cart,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sepetten ürün kaldır
     */
    public function remove(ShoppingCart $cart): JsonResponse
    {
        try {
            // Yetkilendirme kontrolü
            if (auth()->check()) {
                if ($cart->user_id !== auth()->id()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bu işlemi yapmaya yetkiniz yok.',
                    ], 403);
                }
            } else {
                if ($cart->session_id !== session()->getId()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bu işlemi yapmaya yetkiniz yok.',
                    ], 403);
                }
            }

            $productName = $cart->product->name;
            $cart->delete();

            return response()->json([
                'success' => true,
                'message' => $productName . ' sepetten kaldırıldı.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sepeti temizle
     */
    public function clear(): JsonResponse
    {
        try {
            $sessionId = session()->getId();
            $userId = auth()->id();

            ShoppingCart::query()
                ->when($userId, function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }, function ($query) use ($sessionId) {
                    return $query->where('session_id', $sessionId);
                })
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sepet temizlendi.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sepet sayısını getir (header'da göstermek için)
     */
    public function count(): JsonResponse
    {
        $sessionId = session()->getId();
        $userId = auth()->id();

        $count = ShoppingCart::query()
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            }, function ($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->count();

        return response()->json(['count' => $count]);
    }



public function checkout()
{
    if (!auth()->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Giriş yapmalısınız'
        ]);
    }

    $items = ShoppingCart::with('product')
        ->where('user_id', auth()->id())
        ->get();

    if ($items->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Sepet boş'
        ]);
    }

    DB::beginTransaction();

    try {

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => 0,
            'status' => 'paid'
        ]);

        $total = 0;

        foreach ($items as $item) {

            $total += $item->price * $item->quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);
        }

        $order->update(['total_price' => $total]);

        ShoppingCart::where('user_id', auth()->id())->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Sipariş oluşturuldu'
        ]);

    } catch (\Exception $e) {

        DB::rollback();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

}
