<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopHub - Premium Products</title>
    
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
            position: relative;
        }

        .nav-center a:hover {
            color: var(--primary);
        }

        .nav-center a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-center a:hover::after {
            width: 100%;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cart-btn {
            position: relative;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s ease;
            padding: 8px;
        }

        .cart-btn:hover {
            transform: scale(1.1);
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            animation: badgePulse 0.3s ease;
        }

        @keyframes badgePulse {
            0% { transform: scale(0.8); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .admin-btn {
            padding: 10px 24px;
            background: var(--primary);
            color: var(--secondary);
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .admin-btn:hover {
            background: var(--accent);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 166px rgba(212, 175, 55, 0.2);
        }

        /* ===== KATEGORİ KAYDIRILABİLİR MENÜ ===== */
        .category-slider-wrapper {
            margin-bottom: 40px;
            width: 100%;
        }

        .category-slider {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            white-space: nowrap;
            padding: 5px 2px 15px 2px;
            scrollbar-width: none; /* Firefox */
        }

        .category-slider::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
        }

        .category-item {
            display: inline-block;
            padding: 10px 24px;
            background-color: var(--secondary);
            color: var(--text-light);
            border: 2px solid var(--border);
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .category-item:hover {
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-2px);
        }

        .category-item.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: var(--secondary);
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        /* ===== CART MODAL ===== */
        .cart-modal {
            display: none;
            position: fixed;
            top: 0;
            right: -500px;
            width: 500px;
            height: 100vh;
            background: var(--secondary);
            box-shadow: -2px 0 16px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            flex-direction: column;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .cart-modal.active {
            display: flex;
            right: 0;
        }

        .cart-modal-header {
            padding: 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--bg-light);
        }

        .cart-modal-header h2 {
            font-size: 24px;
            color: var(--primary);
        }

        .cart-close-btn {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: var(--text-light);
            transition: color 0.3s ease;
        }

        .cart-close-btn:hover {
            color: var(--primary);
        }

        .cart-content {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
        }

        .cart-item {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            background: var(--bg-light);
            flex-shrink: 0;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .cart-item-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
        }

        .quantity-control button {
            background: none;
            border: none;
            width: 32px;
            height: 32px;
            cursor: pointer;
            font-weight: 600;
            color: var(--text-light);
            transition: all 0.2s ease;
        }

        .quantity-control button:hover {
            background: var(--bg-light);
            color: var(--primary);
        }

        .quantity-control input {
            width: 50px;
            text-align: center;
            border: none;
            font-weight: 600;
            font-size: 14px;
        }

        .remove-btn {
            background: var(--danger);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .remove-btn:hover {
            background: #c0392b;
        }

        .cart-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .cart-empty p {
            font-size: 24px;
            margin-bottom: 16px;
        }

        .cart-footer {
            border-top: 2px solid var(--border);
            padding: 24px;
            background: var(--bg-light);
        }

        .cart-summary {
            margin-bottom: 20px;
        }

        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
            color: var(--text-light);
        }

        .cart-summary-row.total {
            border-top: 1px solid var(--border);
            padding-top: 12px;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }

        .checkout-btn {
            display: block;
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: var(--secondary);
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 12px;
            text-align: center;
            text-decoration: none;
        }

        .checkout-btn:hover {
            background: var(--accent);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(212, 175, 55, 0.2);
        }

        .clear-cart-btn {
            width: 100%;
            padding: 12px;
            background: transparent;
            color: var(--danger);
            border: 1px solid var(--danger);
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .clear-cart-btn:hover {
            background: var(--danger);
            color: white;
        }

        .cart-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .cart-overlay.active {
            display: block;
            opacity: 1;
        }

        /* ===== HERO SECTION ===== */
        .hero {
            background: linear-gradient(135deg, #f9f9f9 0%, #ffffff 50%, #f3f3f3 100%);
            padding: 80px 20px;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 20px;
            letter-spacing: -1px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 18px;
            color: var(--text-light);
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            display: inline-block;
            padding: 14px 40px;
            background: var(--primary);
            color: var(--secondary);
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid var(--primary);
        }

        .cta-button:hover {
            background: transparent;
            color: var(--primary);
        }

        /* ===== PRODUCTS SECTION ===== */
        .products-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-header h2 {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .section-header p {
            font-size: 16px;
            color: var(--text-light);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: var(--secondary);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            border-color: var(--accent);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.12);
            transform: translateY(-8px);
        }

        .product-image {
            width: 100%;
            height: 280px;
            overflow: hidden;
            background: var(--bg-light);
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.08);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent);
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .product-info {
            padding: 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .product-description {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 16px;
            line-height: 1.5;
            flex: 1;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            margin-bottom: 16px;
        }

        .product-price {
            font-size: 24px;
            font-weight: 700;
            color: var(--accent);
        }

        .product-stock {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-light);
            text-align: right;
        }

        .product-stock.low {
            color: #e74c3c;
        }

        .add-to-cart-btn {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: var(--secondary);
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background: var(--accent);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .add-to-cart-btn:disabled {
            background: var(--text-light);
            cursor: not-allowed;
            transform: none;
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
            transition: opacity 0.3s ease;
        }

        .toast.error {
            background: var(--danger);
        }

        /* ===== FOOTER ===== */
        footer {
            background: var(--primary);
            color: var(--secondary);
            padding: 60px 20px;
            margin-top: 80px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            text-align: center;
            font-size: 14px;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .cart-modal { width: 100%; right: -100%; }
            .hero h1 { font-size: 36px; }
        }
    </style>
</head>
<body>
    <div class="cart-overlay" id="cartOverlay"></div>

    <div class="cart-modal" id="cartModal">
        <div class="cart-modal-header">
            <h2>🛒 Carts</h2>
            <button class="cart-close-btn" onclick="closeCart()">✕</button>
        </div>
        <div class="cart-content" id="cartContent"></div>
        <div class="cart-footer" id="cartFooter"></div>
    </div>

    <header>
        <nav>
            <a href="{{ route('products.index') }}" class="logo">ShopHub</a>
            <ul class="nav-center">
                <li><a href="#products">Products</a></li>
            </ul>
            <div class="nav-right">
                <button class="cart-btn" id="cartBtn" onclick="openCart()">
                    🛒 <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
                </button>
                <a href="{{ route('admin.orders.index') }}" class="admin-btn">⚙️ Admin Panel</a>
            </div>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Discover Premium Products</h1>
            <p>Enjoy high-quality and reliable products for your online shopping experience.</p>
            <a href="#products" class="cta-button">View Products</a>
        </div>
    </section>

    <section class="products-section" id="products">
        <div class="section-header">
            <h2>Featured Products</h2>
        </div>

        <div class="category-slider-wrapper">
            <div class="category-slider">
                <a href="{{ route('products.index') }}" class="category-item {{ !request()->has('category') || request('category') == '' ? 'active' : '' }}">
                     All Products
                </a>

           @foreach($categories as $category)
    @if(in_array($category->id, [1, 2, 3]))
        <a href="?category={{ $category->id }}" class="category-item {{ request('category') == $category->id ? 'active' : '' }}">
            @if($category->id == 1)
                 Electronics
            @elseif($category->id == 2)
                 Major Appliances
            @elseif($category->id == 3)
                 Small Home Appliances
            @endif
        </a>
    @endif
@endforeach
            </div>
        </div>

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        
                        <div class="product-image">
                            <a href="{{ route('products.show', $product->id) }}">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/280x280?text=Gorsel+Yok" alt="Görsel yok">
                                @endif
                            </a>
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-name">
                                <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            
                            <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                            <div class="product-meta">
                                <div class="product-price">₺{{ number_format($product->price, 2, ',', '.') }}</div>
                                <div class="product-stock">Stock: {{ $product->stock }}</div>
                            </div>
                            <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}')" @if($product->stock == 0) disabled @endif>
                                {{ $product->stock > 0 ? '➕ Add to Cart' : '❌ Out of Stock' }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state" style="text-align: center; padding: 40px 0; color: var(--text-light);">
                <h2>📦 No Products in This Category</h2>
            </div>
        @endif
    </section>

    <footer>
        <div class="footer-bottom">
            <p>&copy; 2026 ShopHub. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const API_BASE = '/api/cart';

        function openCart() {
            document.getElementById('cartModal').classList.add('active');
            document.getElementById('cartOverlay').classList.add('active');
            loadCart();
        }

        function closeCart() {
            document.getElementById('cartModal').classList.remove('active');
            document.getElementById('cartOverlay').classList.remove('active');
        }

        document.getElementById('cartOverlay').addEventListener('click', closeCart);

        async function addToCart(productId, productName) {
            try {
                const response = await fetch(`${API_BASE}/add`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ product_id: productId, quantity: 1 })
                });
                const data = await response.json();
                if (data.success) {
                    showToast(`${productName} added to cart.`);
                    updateCartCount();
                    if (document.getElementById('cartModal').classList.contains('active')) loadCart();
                } else {
                    showToast(data.message || 'Yetki hatası.', 'error');
                }
            } catch (error) {
                showToast('Hata oluştu.', 'error');
            }
        }

        async function loadCart() {
            try {
                const response = await fetch(`${API_BASE}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                
                const items = data.items ?? data ?? [];
                const total = data.total ?? items.reduce((acc, curr) => acc + (curr.price * curr.quantity), 0);
                
                renderCart(items, total);
            } catch (error) {
                console.error('Sepet yüklenemedi:', error);
            }
        }

        function renderCart(items, total) {
            const content = document.getElementById('cartContent');
            const footer = document.getElementById('cartFooter');

            if (!items || items.length === 0) {
                content.innerHTML = `<div class="cart-empty"><p>🛒</p><p>Sepetiniz boş</p></div>`;
                footer.innerHTML = '';
                return;
            }

            content.innerHTML = items.map(item => {
                const name = item.product?.name ?? "Ürün";
                const img = item.product?.image ? `/storage/${item.product.image}` : 'https://via.placeholder.com/80x80';
                return `
                    <div class="cart-item">
                        <div class="cart-item-image"><img src="${img}"></div>
                        <div class="cart-item-details">
                            <div class="cart-item-name">${name}</div>
                            <div class="cart-item-price">₺${(item.price * item.quantity).toLocaleString('tr-TR', {minimumFractionDigits: 2})}</div>
                            <div class="cart-item-controls">
                                <div class="quantity-control">
                                    <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">−</button>
                                    <input type="number" value="${item.quantity}" readonly>
                                    <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                                </div>
                                <button class="remove-btn" onclick="removeFromCart(${item.id})">Kaldır</button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            footer.innerHTML = `
                <div class="cart-summary">
                    <div class="cart-summary-row total">
                        <span>Toplam:</span>
                        <span>₺${total.toLocaleString('tr-TR', {minimumFractionDigits: 2})}</span>
                    </div>
                </div>
                <a href="/cart" class="checkout-btn">Sepete Git & Sipariş Et</a>
                <button class="clear-cart-btn" onclick="clearCart()">Sepeti Temizle</button>
            `;
        }

        async function updateQuantity(cartId, quantity) {
            if (quantity < 1) {
                removeFromCart(cartId);
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
                    body: JSON.stringify({ quantity })
                });
                const data = await response.json();
                if (data.success) {
                    loadCart();
                    updateCartCount();
                }
            } catch (error) {
                console.error(error);
            }
        }

        async function removeFromCart(cartId) {
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
                    loadCart();
                    updateCartCount();
                    showToast('Ürün sepetten kaldırıldı.');
                }
            } catch (error) {
                console.error(error);
            }
        }

        async function clearCart() {
            try {
                const response = await fetch(`${API_BASE}/clear`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });
                const data = await response.json();
                if (data.success) {
                    loadCart();
                    updateCartCount();
                    showToast('Sepet temizlendi.');
                }
            } catch (error) {
                console.error(error);
            }
        }

        async function updateCartCount() {
            try {
                const response = await fetch(`${API_BASE}/count`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                const badge = document.getElementById('cartBadge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            } catch (error) {
                console.error(error);
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }

        document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>
</body>
</html>