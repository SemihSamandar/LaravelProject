<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepetim - ShopHub</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6fa;
        }

        /* ===== HEADER (ANA SAYFADAKİ İLE AYNI) ===== */
        header {
            background: white;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            max-width: 1200px;
            margin: auto;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            text-decoration: none;
            color: black;
        }

        .cart-badge {
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 7px;
            font-size: 12px;
            position: relative;
            top: -10px;
            left: -5px;
        }

        /* ===== CONTAINER ===== */
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        h1 {
            margin-bottom: 25px;
        }

        /* ===== CART ITEM ===== */
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }

        .cart-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cart-img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            background: #eee;
        }

        .cart-info h3 {
            margin: 0;
            font-size: 16px;
        }

        .cart-info p {
            margin: 5px 0 0;
            color: gray;
        }

        .price {
            font-weight: bold;
            color: green;
            font-size: 18px;
        }

        button {
            background: red;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: darkred;
        }

        /* ===== EMPTY ===== */
        .empty {
            text-align: center;
            margin-top: 60px;
            color: gray;
        }

        /* ===== TOTAL ===== */
        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<header>
    <nav>
        <a href="/" class="logo">🛍 ShopHub</a>
        <a href="/cart">🛒 Sepet <span id="badge" class="cart-badge" style="display:none;">0</span></a>
    </nav>
</header>

<div class="container">
    <h1>🛒 Sepetim</h1>

    <div id="cart-container"></div>

    <div id="total" class="total" style="display:none;">
        Toplam: <span id="total-price">0</span> ₺
    </div>
</div>

<script>

async function checkout() {
    if(!confirm("Satın almayı onaylıyor musun?")) return;

    const res = await fetch('/api/cart/checkout', {
        method: 'POST',
        headers: {
            'Accept': 'application/json'
        }
    });

    const data = await res.json();

    if(data.success){
        alert("Sipariş oluşturuldu!");
        loadCart(); // sepeti yeniler
    } else {
        alert(data.message);
    }
}


async function loadCart() {
    const res = await fetch('/api/cart');
    const result = await res.json();

    const data = result.items ?? [];
    const total = result.total ?? 0;

    const container = document.getElementById('cart-container');
    const totalBox = document.getElementById('total');
    const totalPrice = document.getElementById('total-price');

    container.innerHTML = '';

    if (!Array.isArray(data) || data.length === 0) {
        container.innerHTML = `<div class="empty">Sepet boş 😢</div>`;
        totalBox.style.display = 'none';
        return;
    }

    data.forEach(item => {

        const name = item.product?.name ?? "Ürün";
        const image = item.product?.image 
            ? `/storage/${item.product.image}` 
            : 'https://via.placeholder.com/80';

        const html = `
            <div class="cart-item">
                
                <div class="cart-left">
                    <img class="cart-img" src="${image}">
                    
                    <div class="cart-info">
                        <h3>${name}</h3>
                        <p>Adet: ${item.quantity}</p>
                    </div>
                </div>

                <div style="display:flex; gap:15px; align-items:center;">
                    <span class="price">${item.price} ₺</span>
                    <button onclick="removeItem(${item.id})">Sil</button>
                </div>

            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
    });

    totalPrice.innerText = total;
    totalBox.style.display = 'block';
}

async function removeItem(id) {
    await fetch('/api/cart/' + id, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json'
        }
    });

    loadCart();
}

document.addEventListener('DOMContentLoaded', loadCart);

</script>
<button onclick="checkout()" style="
    width:100%;
    padding:12px;
    background:green;
    color:white;
    border:none;
    border-radius:8px;
    margin-top:20px;
">
💳 Satın Al
</button>
</body>
</html>