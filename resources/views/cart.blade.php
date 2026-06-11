<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carts - ShopHub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0f1419;
            --secondary: #ffffff;
            --accent: #2d5a8c;
            --accent-light: #e8f1f8;
            --text-dark: #1a1a1a;
            --text-light: #666666;
            --text-muted: #999999;
            --border: #e0e0e0;
            --bg-light: #fafbfc;
            --success: #10b981;
            --danger: #ef4444;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.12);
            --shadow-xl: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        /* ===== HEADER ===== */
        header {
            background: var(--secondary);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        nav {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Playfair Display', serif;
            transition: all 0.3s ease;
        }

        .logo:hover {
            color: var(--accent);
        }

        .logo::before {
            content: "✨";
            font-size: 32px;
        }

        .nav-links {
            display: flex;
            gap: 40px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-light);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        /* ===== BREADCRUMB ===== */
        .breadcrumb {
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px 32px;
            font-size: 14px;
            color: var(--text-light);
        }

        .breadcrumb a {
            color: var(--accent);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: var(--primary);
        }

        /* ===== CONTAINER ===== */
        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 32px 80px;
        }

        .cart-header {
            margin: 60px 0 40px;
            animation: fadeInDown 0.6s ease;
        }

        .cart-header h1 {
            font-size: 44px;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .cart-header p {
            font-size: 16px;
            color: var(--text-light);
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== CART LAYOUT ===== */
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 40px;
            align-items: start;
        }

        /* ===== CART ITEMS ===== */
        .cart-items {
            background: var(--secondary);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .cart-item {
            display: flex;
            gap: 24px;
            padding: 28px;
            border-bottom: 1px solid var(--border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideInLeft 0.5s ease;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item:hover {
            background: var(--bg-light);
            padding-left: 32px;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .cart-item-image {
            width: 140px;
            height: 140px;
            border-radius: 10px;
            overflow: hidden;
            background: var(--bg-light);
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .cart-item:hover .cart-item-image img {
            transform: scale(1.05);
        }

        .cart-item-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cart-item-top {
            margin-bottom: 16px;
        }

        .cart-item-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px;
            font-family: 'Playfair Display', serif;
        }

        .cart-item-description {
            font-size: 14px;
            color: var(--text-light);
            line-height: 1.5;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: var(--bg-light);
            overflow: hidden;
        }

        .quantity-selector button {
            background: none;
            border: none;
            width: 36px;
            height: 36px;
            cursor: pointer;
            font-weight: 600;
            color: var(--text-light);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-selector button:hover {
            color: var(--accent);
            background: white;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: none;
            font-weight: 600;
            font-size: 14px;
            background: none;
        }

        .cart-item-price {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .price-unit {
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .price-total {
            font-size: 24px;
            font-weight: 800;
            color: var(--accent);
            font-family: 'Playfair Display', serif;
        }

        .remove-btn {
            background: var(--danger);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            align-self: flex-end;
        }

        .remove-btn:hover {
            background: #dc2626;
            transform: scale(1.05);
        }

        /* ===== EMPTY CART ===== */
        .empty-cart {
            text-align: center;
            padding: 80px 40px;
            background: var(--secondary);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
        }

        .empty-cart-icon {
            font-size: 80px;
            margin-bottom: 24px;
        }

        .empty-cart h2 {
            font-size: 28px;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .empty-cart p {
            font-size: 16px;
            color: var(--text-light);
            margin-bottom: 32px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .continue-shopping {
            display: inline-block;
            padding: 14px 40px;
            background: var(--accent);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .continue-shopping:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* ===== SIDEBAR SUMMARY & FORM ===== */
        .cart-summary {
            background: var(--secondary);
            border-radius: 12px;
            padding: 32px;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 100px;
            animation: fadeInRight 0.6s ease 0.2s both;
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .summary-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 24px;
            font-family: 'Playfair Display', serif;
            border-bottom: 2px solid var(--bg-light);
            padding-bottom: 10px;
        }

        .checkout-form {
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            background: #fff;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 14px;
            color: var(--text-light);
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .summary-row:last-of-type {
            border-bottom: none;
        }

        .summary-row.total {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 2px solid var(--border);
            border-bottom: none;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }

        .summary-row span:last-child {
            font-weight: 600;
            color: var(--primary);
        }

        .summary-row.total span:last-child {
            font-size: 24px;
            color: var(--accent);
            font-family: 'Playfair Display', serif;
        }

        .checkout-btn {
            width: 100%;
            padding: 16px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 15px;
            margin-top: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.3px;
            box-shadow: var(--shadow-md);
        }

        .checkout-btn:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .checkout-btn:active {
            transform: translateY(0);
        }

        .promo-container {
            margin-top: 20px;
            display: flex;
            gap: 8px;
        }

        .promo-input {
            flex: 1;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 0;
        }

        .promo-btn {
            padding: 12px 16px;
            background: var(--bg-light);
            color: var(--accent);
            border: 1.5px solid var(--accent);
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .promo-btn:hover {
            background: var(--accent-light);
        }

        .shipping-info {
            background: var(--accent-light);
            padding: 12px;
            border-radius: 6px;
            font-size: 12px;
            color: var(--accent);
            margin-top: 20px;
            text-align: center;
            font-weight: 500;
        }

        /* ===== TOAST ===== */
        .toast {
            position: fixed;
            bottom: 32px;
            left: 32px;
            background: var(--success);
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            z-index: 2000;
            animation: slideUp 0.4s ease;
            font-size: 14px;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .toast.error {
            background: var(--danger);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 968px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }

            .cart-summary {
                position: static;
            }

            .container { padding: 0 24px 60px; }
            nav { padding: 0 24px; }
            .breadcrumb { padding: 16px 24px; }
        }

        @media (max-width: 640px) {
            .cart-item { flex-direction: column; gap: 16px; }
            .cart-item-image { width: 100%; height: 200px; }
            .cart-item-controls { flex-direction: column; align-items: stretch; }
            .quantity-selector { width: 100%; }
            .cart-item-price { align-items: stretch; flex-direction: row; justify-content: space-between; }
            .remove-btn { align-self: auto; width: 100%; }
            .cart-header h1 { font-size: 32px; }
            .logo { font-size: 24px; }
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <a href="/" class="logo">ShopHub</a>
            <div class="nav-links">
                <a href="/">← Home </a>
                <a href="/cart">🛒 Carts</a>
            </div>
        </nav>
    </header>

    <div class="breadcrumb">
        <a href="/">Home</a> / <span>Carts</span>
    </div>

    <div class="container">
        <div class="cart-header">
            <h1>Carts</h1>
            <p>Review the items in your cart before checkout</p>
        </div>

        <div class="cart-layout">
            <div id="cart-container" class="cart-items">
                <div style="padding: 40px; text-align: center; color: var(--text-light);">
                    <p>Carts are loading...</p>
                </div>
            </div>

            <div class="cart-summary">
                <div class="summary-title">Checkout Information</div>
                <div class="checkout-form">
                    <div class="form-group">
                        <label for="customer-name">Name Surname</label>
                        <input type="text" id="customer-name" class="form-control" placeholder="Customer name and surname">
                    </div>
                    <div class="form-group">
                        <label for="customer-phone">Phone Number</label>
                        <input type="tel" id="customer-phone" class="form-control" placeholder="0555 XXXXXXX">
                    </div>
                    <div class="form-group">
                        <label for="customer-address">Delivery Address</label>
                        <textarea id="customer-address" class="form-control" placeholder="Your full address..."></textarea>
                    </div>
                </div>

                <div class="summary-title">Order Summary</div>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotal">₺0,00</span>
                </div>

                <div class="summary-row">
                    <span>Shipping</span>
                    <span id="shipping">₺50,00</span>
                </div>

                <div class="summary-row">
                    <span>Tax (%18)</span>
                    <span id="tax">₺0,00</span>
                </div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span id="total-price">₺0,00</span>
                </div>

                <button class="checkout-btn" onclick="checkout()">
                    💳 Checkout
                </button>

                <div class="promo-container">
                    <input type="text" class="promo-input" placeholder="Promo code" id="promo-code">
                    <button class="promo-btn" onclick="applyPromo()">Apply</button>
                </div>

                <div class="shipping-info">
                    ✓ Free returns within 30 days
                </div>
            </div>
        </div>
    </div>

    <script>
        // GÜNCELLEME: web.php dosyasındaki prefix yapısına göre base url ayarlandı
        const API_BASE = '/api/cart';

        async function loadCart() {
            try {
                // GÜNCELLEME: web.php'deki Route::get('/', ...) istek yoluna göre boş '/' atılıyor
                const response = await fetch(`${API_BASE}`);
                const result = await response.json();

                const items = result.items ?? [];
                const total = result.total ?? 0;

                const container = document.getElementById('cart-container');
                const subtotalEl = document.getElementById('subtotal');
                const totalEl = document.getElementById('total-price');
                
                const shippingCost = items.length > 0 ? 50 : 0; // Sepet boşsa kargo 0 görünsün
                const tax = total * 0.18;
                const totalWithExtras = total + shippingCost + tax;

                if (!Array.isArray(items) || items.length === 0) {
                    container.innerHTML = `
                        <div class="empty-cart">
                            <div class="empty-cart-icon">🛒</div>
                            <h2>Sepetiniz Boş</h2>
                            <p>Henüz hiç ürün eklemediniz. Alışverişe başlamak için ana sayfaya dönün.</p>
                            <a href="/" class="continue-shopping">Alışverişe Dönün</a>
                        </div>
                    `;
                    subtotalEl.textContent = '₺0,00';
                    document.getElementById('shipping').textContent = '₺0,00';
                    document.getElementById('tax').textContent = '₺0,00';
                    totalEl.textContent = '₺0,00';
                    return;
                }

                container.innerHTML = items.map((item, index) => {
                    const name = item.product?.name ?? "Ürün";
                    const description = item.product?.description ?? "";
                    const image = item.product?.image 
                        ? `/storage/${item.product.image}` 
                        : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop';
                    
                    const itemTotal = (item.price * item.quantity).toLocaleString('tr-TR', {minimumFractionDigits: 2});

                    return `
                        <div class="cart-item" style="animation-delay: ${index * 0.05}s;">
                            <div class="cart-item-image">
                                <img src="${image}" alt="${name}" loading="lazy">
                            </div>

                            <div class="cart-item-content">
                                <div class="cart-item-top">
                                    <h3 class="cart-item-name">${name}</h3>
                                    <p class="cart-item-description">${description.substring(0, 100)}</p>
                                </div>

                                <div class="cart-item-controls">
                                    <div class="quantity-selector">
                                        <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">−</button>
                                        <input type="number" class="quantity-input" value="${item.quantity}" readonly>
                                        <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                                    </div>

                                    <div class="cart-item-price">
                                        <div class="price-unit">₺${item.price.toLocaleString('tr-TR', {minimumFractionDigits: 2})}</div>
                                        <div class="price-total">₺${itemTotal}</div>
                                    </div>

                                    <button class="remove-btn" onclick="removeItem(${item.id})">🗑️ Kaldır</button>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');

                subtotalEl.textContent = total.toLocaleString('tr-TR', {minimumFractionDigits: 2}) + ' ₺';
                document.getElementById('shipping').textContent = shippingCost.toLocaleString('tr-TR', {minimumFractionDigits: 2}) + ' ₺';
                document.getElementById('tax').textContent = tax.toLocaleString('tr-TR', {minimumFractionDigits: 2}) + ' ₺';
                totalEl.textContent = totalWithExtras.toLocaleString('tr-TR', {minimumFractionDigits: 2}) + ' ₺';

            } catch (error) {
                console.error('Sepet yükleme hatası:', error);
                document.getElementById('cart-container').innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-icon">⚠️</div>
                        <h2>Bir Hata Oluştu</h2>
                        <p>Sepet yüklenirken bir sorun yaşandı. Lütfen sayfayı yenileyin.</p>
                    </div>
                `;
            }
        }

        // GÜNCELLEME: Rota PUT /api/cart/update/{id} yapısına çekildi ve CSRF Token eklendi
        async function updateQuantity(cartId, quantity) {
            if (quantity < 1) {
                removeItem(cartId);
                return;
            }

            try {
                const response = await fetch(`${API_BASE}/update/${cartId}`, {
                    method: 'PUT',
                    headers: { 
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ quantity }),
                });

                const data = await response.json();
                if (data.success) {
                    loadCart();
                    showToast('Ürün güncellendi', 'success');
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                showToast('Bir hata oluştu: ' + error.message, 'error');
            }
        }

        // GÜNCELLEME: Rota DELETE /api/cart/remove/{id} yapısına çekildi ve CSRF Token eklendi
        async function removeItem(cartId) {
            try {
                const response = await fetch(`${API_BASE}/remove/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const data = await response.json();
                if (data.success) {
                    showToast('Ürün sepetten kaldırıldı', 'success');
                    loadCart();
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                showToast('Bir hata oluştu: ' + error.message, 'error');
            }
        }

        // GÜNCELLEME: Rota POST /api/cart/checkout yapısına çekildi ve CSRF Token eklendi
        async function checkout() {
            const name = document.getElementById('customer-name').value.trim();
            const phone = document.getElementById('customer-phone').value.trim();
            const address = document.getElementById('customer-address').value.trim();

            if (!name || !phone || !address) {
                showToast('Lütfen teslimat alanlarının tümünü doldurun.', 'error');
                return;
            }

            if (!confirm('Siparişi ve teslimat bilgilerini onaylıyor musunuz?')) return;

            try {
                const response = await fetch(`${API_BASE}/checkout`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        customer_name: name,
                        customer_phone: phone,
                        customer_address: address
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    showToast('✓ Sipariş başarıyla oluşturuldu!', 'success');
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 2000);
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                showToast('Bir hata oluştu: ' + error.message, 'error');
            }
        }

        function applyPromo() {
            const code = document.getElementById('promo-code').value;
            if (!code.trim()) {
                showToast('Lütfen kupon kodunu girin', 'error');
                return;
            }
            showToast('Kupon uygulandı! (Örnek)', 'success');
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', loadCart);
    </script>
</body>
</html>