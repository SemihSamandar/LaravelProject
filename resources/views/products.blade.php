<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopHub - Premium Ürünler</title>
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

        .nav-links {
            display: flex;
            list-style: none;
            gap: 40px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-light);
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
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
            box-shadow: 0 8px 16px rgba(212, 175, 55, 0.2);
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
            margin-bottom: 60px;
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

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-state h2 {
            font-size: 32px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .empty-state p {
            font-size: 16px;
            color: var(--text-light);
            margin-bottom: 30px;
        }

        /* ===== FOOTER ===== */
        footer {
            background: var(--primary);
            color: var(--secondary);
            padding: 60px 20px;
            margin-top: 80px;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--accent);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 12px;
        }

        .footer-section a {
            color: var(--secondary);
            text-decoration: none;
            font-size: 14px;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .footer-section a:hover {
            opacity: 1;
            color: var(--accent);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            text-align: center;
            font-size: 14px;
            opacity: 0.8;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 16px;
            }

            .section-header h2 {
                font-size: 28px;
            }

            .nav-links {
                gap: 20px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 20px;
            }

            .admin-btn {
                padding: 8px 16px;
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            nav {
                height: auto;
                padding: 15px 20px;
                flex-wrap: wrap;
            }

            .logo {
                font-size: 20px;
            }

            .nav-links {
                width: 100%;
                flex-direction: column;
                gap: 15px;
                margin-top: 15px;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .hero {
                padding: 50px 20px;
            }

            .hero h1 {
                font-size: 28px;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card {
            animation: fadeIn 0.6s ease-out;
        }

        .product-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .product-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .product-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .product-card:nth-child(n+4) {
            animation-delay: 0.4s;
        }
    </style>
</head>
<body>
    <!-- ===== HEADER & NAVIGATION ===== -->
    <header>
        <nav>
            <a href="{{ route('products.index') }}" class="logo">ShopHub</a>
            
            <ul class="nav-links">
                <li><a href="#products">Ürünler</a></li>
                <li><a href="#about">Hakkında</a></li>
                <li><a href="#contact">İletişim</a></li>
                <li><a href="{{ route('products.create') }}" class="admin-btn">⚙️ Admin Panel</a></li>
            </ul>
        </nav>
    </header>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero">
        <div class="hero-content">
            <h1>Premium Ürünleri Keşfet</h1>
            <p>Kaliteli ve güvenilir ürünlere sahip olan online alışveriş platformumuzda siz de yerini alın.</p>
            <a href="#products" class="cta-button">Ürünleri Gör</a>
        </div>
    </section>

    <!-- ===== PRODUCTS SECTION ===== -->
    <section class="products-section" id="products">
        <div class="section-header">
            <h2>Öne Çıkan Ürünler</h2>
            <p>En popüler ve en çok tercih edilen ürünlerimiz</p>
        </div>

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     loading="lazy">
                            @else
                                <img src="https://via.placeholder.com/280x280?text={{ urlencode($product->name) }}" 
                                     alt="Görsel yok">
                            @endif
                            @if($product->stock > 0 && $product->stock < 5)
                                <div class="product-badge">Son Kalan!</div>
                            @endif
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            
                            @if($product->description)
                                <p class="product-description">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                            @endif
                            
                            <div class="product-meta">
                                <div class="product-price">
                                    ₺{{ number_format($product->price, 2, ',', '.') }}
                                </div>
                                <div class="product-stock @if($product->stock < 5) low @endif">
                                    @if($product->stock > 0)
                                        Stok: {{ $product->stock }}
                                    @else
                                        Stok Yok
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h2>📦 Ürün Bulunamadı</h2>
                <p>Şu anda hiç ürün bulunmamaktadır. Lütfen daha sonra tekrar kontrol edin.</p>
                <a href="{{ route('products.create') }}" class="cta-button">
                    ➕ Yeni Ürün Ekle
                </a>
            </div>
        @endif
    </section>

    <!-- ===== FOOTER ===== -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>🛍️ ShopHub</h3>
                <p style="font-size: 14px; opacity: 0.8; margin-top: 10px;">
                    Premium ürünler ve hızlı teslimat ile online alışverişin yeni standartı.
                </p>
            </div>

            <div class="footer-section">
                <h3>Hızlı Bağlantılar</h3>
                <ul>
                    <li><a href="#products">Ürünler</a></li>
                    <li><a href="{{ route('products.create') }}">Admin Panel</a></li>
                    <li><a href="#contact">İletişim</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Hizmetler</h3>
                <ul>
                    <li><a href="#">Hızlı Kargo</a></li>
                    <li><a href="#">Ücretsiz İade</a></li>
                    <li><a href="#">Güvenli Ödeme</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>İletişim</h3>
                <ul>
                    <li><a href="mailto:info@shophub.com">📧 info@shophub.com</a></li>
                    <li><a href="tel:+905551234567">📞 +90 555 123 45 67</a></li>
                    <li><a href="#">📍 Istanbul, Türkiye</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 ShopHub. Tüm hakları saklıdır. | <a href="#" style="color: var(--accent);">Gizlilik Politikası</a></p>
        </div>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>