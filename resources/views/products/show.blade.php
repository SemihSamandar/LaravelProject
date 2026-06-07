<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - ShopHub Premium</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1a1a1a;
            --secondary: #ffffff;
            --accent: #d4af37;
            --text: #333333;
            --text-light: #666666;
            --border: #e8e8e8;
            --bg-light: #f9f9f9;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --success: #27ae60;
            --danger: #e74c3c;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--secondary);
            color: var(--text);
            line-height: 1.6;
        }

        /* ===== HEADER & NAV ===== */
        header {
            background: var(--secondary);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        nav {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo::before {
            content: "🛍️";
            font-size: 28px;
        }

        .nav-center {
            display: flex;
            list-style: none;
            gap: 40px;
            align-items: center;
        }

        .nav-center a {
            text-decoration: none;
            color: var(--text-light);
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-center a:hover {
            color: var(--primary);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .back-to-shop {
            text-decoration: none;
            color: var(--text-light);
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.2s;
        }

        .back-to-shop:hover {
            color: var(--accent);
        }

        /* ===== DETAIL CONTAINER ===== */
        .detail-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: start;
        }

        /* ===== LEFT: IMAGE AREA ===== */
        .product-image-gallery {
            position: relative;
            background: var(--bg-light);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .product-image-gallery img {
            width: 100%;
            height: auto;
            max-height: 550px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .product-image-gallery:hover img {
            transform: scale(1.02);
        }

        .detail-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--accent);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* ===== RIGHT: INFO AREA ===== */
        .product-detail-info {
            display: flex;
            flex-direction: column;
        }

        .detail-tag {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .detail-name {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .detail-price {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-price span {
            font-size: 16px;
            color: var(--text-light);
            font-weight: 400;
        }

        .detail-divider {
            height: 1px;
            background: var(--border);
            margin: 20px 0;
        }

        .detail-description-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .detail-description {
            font-size: 15px;
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 25px;
        }

        /* ===== STOCK & STATUS ===== */
        .status-row {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
        }

        .status-indicator.in-stock {
            background: rgba(39, 174, 96, 0.1);
            color: var(--success);
        }

        .status-indicator.low-stock {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger);
        }

        .status-indicator.no-stock {
            background: #f0f0f0;
            color: var(--text-light);
        }

        /* ===== PURCHASE ACTIONS ===== */
        .purchase-zone {
            display: flex;
            gap: 15px;
            margin-bottom: 35px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            border: 2px solid var(--primary);
            border-radius: 6px;
            overflow: hidden;
            height: 54px;
        }

        .quantity-selector button {
            background: transparent;
            border: none;
            width: 45px;
            height: 100%;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .quantity-selector button:hover {
            background: var(--bg-light);
        }

        .quantity-selector input {
            width: 50px;
            height: 100%;
            text-align: center;
            border: none;
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
            outline: none;
        }

        /* Chrome, Safari, Edge, Opera input spin gizleme */
        .quantity-selector input::-webkit-outer-spin-button,
        .quantity-selector input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .detail-add-btn {
            flex: 1;
            height: 54px;
            background: var(--primary);
            color: var(--secondary);
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .detail-add-btn:hover {
            background: var(--accent);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(212, 175, 55, 0.2);
        }

        .detail-add-btn:disabled {
            background: #bdc3c7;
            color: #7f8c8d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ===== FEATURES LIST ===== */
        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--text-light);
        }

        .feature-item span {
            font-size: 16px;
        }

        /* ===== TOAST NOTIFICATION ===== */
        .toast {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: var(--success);
            color: white;
            padding: 16px 24px;
            border-radius: 6px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            z-index: 2000;
            animation: slideUp 0.3s ease;
        }

        .toast.error {
            background: var(--danger);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .detail-container {
                grid-template-columns: 1fr;
                gap: 30px;
                margin: 20px auto;
            }

            .detail-name {
                font-size: 28px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <header>
        <nav>
            <a href="{{ route('products.index') }}" class="logo">ShopHub</a>
            <div class="nav-right">
                <a href="{{ route('products.index') }}" class="back-to-shop">
                    ← Mağazaya Dön
                </a>
            </div>
        </nav>
    </header>

    <main class="detail-container">
        
        <section class="product-image-gallery">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/600x600?text={{ urlencode($product->name) }}" alt="Görsel Yok">
            @endif

            @if($product->stock > 0 && $product->stock < 5)
                <div class="detail-badge">Tükenmek Üzere!</div>
            @endif
        </section>

        <section class="product-detail-info">
            <span class="detail-tag">Premium Koleksiyon</span>
            <h1 class="detail-name">{{ $product->name }}</h1>
            
            <div class="detail-price">
                ₺{{ number_format($product->price, 2, ',', '.') }}
                <span>KDV Dahil</span>
            </div>

            <div class="status-row">
                Durum:
                @if($product->stock >= 5)
                    <div class="status-indicator in-stock">
                        <span>●</span> Stokta Var ({{ $product->stock }} adet)
                    </div>
                @elseif($product->stock > 0 && $product->stock < 5)
                    <div class="status-indicator low-stock">
                        <span>●</span> Son {{ $product->stock }} Ürün!
                    </div>
                @else
                    <div class="status-indicator no-stock">
                        <span>●</span> Stok Tükendi
                    </div>
                @endif
            </div>

            <div class="detail-divider"></div>

            <h2 class="detail-description-title">Ürün Açıklaması</h2>
            <p class="detail-description">
                {{ $product->description ?? 'Bu lüks ürünümüz hakkında detaylı açıklama çok yakında eklenecektir. Şık tasarımı ve premium malzeme kalitesiyle hayatınıza değer katmak için tasarlandı.' }}
            </p>

            <div class="detail-divider"></div>

            <div class="purchase-zone">
                @if($product->stock > 0)
                    <div class="quantity-selector">
                        <button onclick="adjustQuantity(-1)">−</button>
                        <input type="number" id="detailQty" value="1" min="1" max="{{ $product->stock }}" readonly>
                        <button onclick="adjustQuantity(1)">+</button>
                    </div>
                @endif

                <button class="detail-add-btn" 
                        onclick="processAddToCart({{ $product->id }}, '{{ $product->name }}')"
                        @if($product->stock == 0) disabled @endif>
                    @if($product->stock > 0)
                        🛒 Sepete Ekle
                    @else
                        ❌ Stokta Yok
                    @endif
                </button>
            </div>

            <div class="features-grid">
                <div class="feature-item">
                    <span>🚚</span> Ücretsiz ve Hızlı Kargo
                </div>
                <div class="feature-item">
                    <span>🛡️</span> 2 Yıl Resmi Üretici Garantisi
                </div>
                <div class="feature-item">
                    <span>🔄</span> 14 Gün Koşulsuz İade Hakkı
                </div>
                <div class="feature-item">
                    <span>💳</span> Güvenli Ödeme Altyapısı
                </div>
            </div>

        </section>
    </main>

    <script>
        const API_BASE = '/api';
        const maxStock = parseInt("{{ $product->stock }}") || 0;

        // Adet Azaltıp Çoğaltma Kontrolü
        function adjustQuantity(amount) {
            const qtyInput = document.getElementById('detailQty');
            if (!qtyInput) return;

            let currentQty = parseInt(qtyInput.value) || 1;
            let newQty = currentQty + amount;

            if (newQty >= 1 && newQty <= maxStock) {
                qtyInput.value = newQty;
            }
        }

        // Sepete Ekleme API İsteği
        async function processAddToCart(productId, productName) {
            const qtyInput = document.getElementById('detailQty');
            const finalQuantity = qtyInput ? parseInt(qtyInput.value) : 1;

            try {
                const response = await fetch(`${API_BASE}/cart/add`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: finalQuantity,
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    showToast(`${finalQuantity} adet ${productName} başarıyla sepetinize eklendi!`, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                showToast('Bir hata oluştu: ' + error.message, 'error');
            }
        }

        // Toast Bildirimi Gösterimi
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type === 'error' ? 'error' : ''}`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideUp 0.3s ease reverse forwards';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
</body>
</html>