@extends('layouts.admin') {{-- Projenizin ana admin temasını miras alıyoruz --}}

@section('content')
<div class="container-fluid py-4" style="max-width: 1000px; margin: 0 auto;">

    <h1 class="text-center mb-4" style="font-size: 28px; font-weight: bold; color: #2c3e50;">📦 Orders</h1>

    @if($orders->count() == 0)
        <p style="text-align:center; color:gray; margin-top: 40px;">No orders yet</p>
    @endif

    @foreach($orders as $order)
        <div class="order-card" style="background: white; border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.05);">

            <div class="order-header" style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #f5f6fa;">
                <div class="order-id" style="font-weight: bold; font-size: 18px;">
                    Order #{{ $order->id }} 
                    <span class="badge" style="display: inline-block; padding: 4px 10px; background: #2ecc71; color: white; border-radius: 6px; font-size: 12px; font-weight: bold; text-transform: uppercase; margin-left: 10px;">
                        {{ $order->status }}
                    </span>
                </div>

                <div class="order-total" style="font-weight: bold; color: green; font-size: 18px;">
                    {{ number_format($order->total_price, 2, ',', '.') }} $
                </div>
            </div>

            <div class="customer-info" style="background: #f9f9f9; padding: 12px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; line-height: 1.5; color: #333;">
                <strong>👤 Customer:</strong> {{ $order->customer_name }} <br>
                <strong>📞 Phone:</strong> {{ $order->customer_phone }} <br>
                <strong>📍 Address:</strong> {{ $order->customer_address }}
            </div>

            <div class="items" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                <div style="font-weight: bold; margin-bottom: 8px; color: #7f8c8d; font-size: 14px;">Products Purchased:</div>
                @foreach($order->items as $item)
                    <div class="item" style="padding: 8px 0; color: #333; border-bottom: 1px dashed #f1f1f1; font-size: 14px;">
                        🛒 {{ $item->product->name ?? 'Deleted Product' }}
                        <strong style="margin-left: 5px;">x{{ $item->quantity }}</strong> piece
                        <span style="float: right; color: #555; font-weight: 500;">{{ number_format($item->price, 2, ',', '.') }} $</span>
                    </div>
                @endforeach
            </div>

        </div>
    @endforeach

</div>
@endsection