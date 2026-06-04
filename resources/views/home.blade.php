<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendMağaza | Alışverişin Güvenli Adresi</title>
    <style>
        /* Genel Sayfa Düzeni */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            color: #333;
        }

        /* Üst Menü (Header) */
        header {
            background-color: #ffffff;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ff6600;
            text-decoration: none;
        }

        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #555;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #ff6600;
        }

        /* Karşılama Alanı (Hero Banner) */
        .hero {
            background: linear-gradient(135deg, #ff6600, #ff9900);
            color: white;
            padding: 60px 5%;
            text-align: center;
        }

        .hero h1 {
            margin: 0 0 15px 0;
            font-size: 36px;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 25px;
        }

        .btn-shop {
            background-color: white;
            color: #ff6600;
            padding: 12px 30px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s, background-color 0.3s;
        }

        .btn-shop:hover {
            transform: scale(1.05);
            background-color: #fff0e6;
        }

        /* Öne Çıkan Ürünler Alanı */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        /* Ürün Kartı Tasarımı */
        .product-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-img {
            width: 100%;
            height: 200px;
            background-color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-weight: bold;
        }

        .product-info {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-title {
            font-size: 16px;
            margin: 0 0 10px 0;
            font-weight: 600;
        }

        .product-price {
            font-size: 18px;
            color: #ff6600;
            font-weight: bold;
            margin-bottom: 15px;
            margin-top: auto;
        }

        .btn-add-cart {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-add-cart:hover {
            background-color: #ff6600;
        }

        /* Alt Bilgi (Footer) */
        footer {
            background-color: #222;
            color: #888;
            text-align: center;
            padding: 20px;
            margin-top: 60px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <header>
        <a href="#" class="logo">🛒 TrendMağaza</a>
        <nav>
            <a href="#">Ana Sayfa</a>
            <a href="/products">Ürünler</a>
            <a href="#">Kampanyalar</a>
            <a href="#">İletişim</a>
        </nav>
    </header>

    <section class="hero">
        <h1>Büyük Sezon İndirimi Başladı! 🚀</h1>
        <p>Aradığın tüm ürünlerde %50'ye varan fırsatları kaçırma.</p>
        <a href="/products" class="btn-shop">Alışverişe Başla</a>
    </section>

    <main class="container">
        <h2 class="section-title">Öne Çıkan Ürünler</h2>
        
        <div class="product-grid">
            
            <div class="product-card">
                <div class="product-img">Görsel Alanı (1)</div>
                <div class="product-info">
                    <h3 class="product-title">Kablosuz Kulak Üstü Kulaklık</h3>
                    <div class="product-price">1.299,00 TL</div>
                    <a href="#" class="btn-add-cart">Sepete Ekle</a>
                </div>
            </div>

            <div class="product-card">
                <div class="product-img">Görsel Alanı (2)</div>
                <div class="product-info">
                    <h3 class="product-title">Akıllı Saat V5 Pro</h3>
                    <div class="product-price">2.450,00 TL</div>
                    <a href="#" class="btn-add-cart">Sepete Ekle</a>
                </div>
            </div>

            <div class="product-card">
                <div class="product-img">Görsel Alanı (3)</div>
                <div class="product-info">
                    <h3 class="product-title">Ergonomik Oyuncu Mouse</h3>
                    <div class="product-price">650,00 TL</div>
                    <a href="#" class="btn-add-cart">Sepete Ekle</a>
                </div>
            </div>

            <div class="product-card">
                <div class="product-img">Görsel Alanı (4)</div>
                <div class="product-info">
                    <h3 class="product-title">Sırt Çantası (Su Geçirmez)</h3>
                    <div class="product-price">899,00 TL</div>
                    <a href="#" class="btn-add-cart">Sepete Ekle</a>
                </div>
            </div>

        </div>
    </main>

    <footer>
        &copy; 2026 TrendMağaza. Tüm Hakları Saklıdır.
    </footer>

</body>
</html>