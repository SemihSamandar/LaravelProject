<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Siparişler</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .order-card {
            background: white;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .order-id {
            font-weight: bold;
            font-size: 18px;
        }

        .order-total {
            font-weight: bold;
            color: green;
        }

        .items {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .item {
            padding: 5px 0;
            color: #333;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            background: #3498db;
            color: white;
            border-radius: 6px;
            font-size: 12px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>📦 Siparişler</h1>

    @if($orders->count() == 0)
        <p style="text-align:center; color:gray;">Henüz sipariş yok</p>
    @endif

    @foreach($orders as $order)

        <div class="order-card">

            <div class="order-header">
                <div class="order-id">
                    Sipariş #{{ $order->id }}
                </div>

                <div class="order-total">
                    {{ number_format($order->total_price, 2, ',', '.') }} ₺
                </div>
            </div>

            <div>
                <span class="badge">{{ $order->status }}</span>
            </div>

            <div class="items">
                @foreach($order->items as $item)
                    <div class="item">
                        🛒 {{ $item->product->name }}
                        - {{ $item->quantity }} adet
                        - {{ number_format($item->price, 2, ',', '.') }} ₺
                    </div>
                @endforeach
            </div>

        </div>

    @endforeach

</div>

</body>
</html>