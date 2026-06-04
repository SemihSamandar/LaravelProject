<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Ürün Ekle - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            padding: 40px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background-color: #f8f9ff;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .image-upload-area {
            border: 2px dashed #667eea;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f8f9ff;
        }

        .image-upload-area:hover {
            border-color: #764ba2;
            background-color: #f0f2ff;
        }

        .image-upload-area.active {
            border-color: #27ae60;
            background-color: #f0fdf4;
        }

        .image-upload-area svg {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
            opacity: 0.6;
        }

        .image-upload-area p {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .image-upload-area small {
            color: #999;
            display: block;
            font-size: 12px;
        }

        #imagePreview {
            margin-top: 15px;
            display: none;
        }

        #imagePreview img {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        button {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
        }

        .error-message {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: none;
        }

        .error-message.show {
            display: block;
            animation: slideUp 0.3s ease-out;
        }

        .success-message {
            background: #efe;
            border: 1px solid #cfc;
            color: #3c3;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: none;
        }

        .success-message.show {
            display: block;
            animation: slideUp 0.3s ease-out;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .container {
                padding: 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 24px;
            }
        }

        input[type="file"] {
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✨ Yeni Ürün Ekle</h1>
            <p>Ürün bilgilerini doldurup görseli yükleyin</p>
        </div>

        @if ($errors->any())
            <div class="error-message show">
                @foreach ($errors->all() as $error)
                    <p>❌ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="success-message show">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf

            <!-- Ürün Adı -->
            <div class="form-group">
                <label for="name">📦 Ürün Adı</label>
                <input type="text" id="name" name="name" placeholder="Örn: Deri Çanta" required value="{{ old('name') }}">
            </div>

            <!-- Açıklama -->
            <div class="form-group">
                <label for="description">📝 Açıklama</label>
                <textarea id="description" name="description" placeholder="Ürünün detaylı açıklamasını yazın..." required>{{ old('description') }}</textarea>
            </div>

            <!-- Fiyat ve Stok -->
            <div class="form-row">
                <div class="form-group">
                    <label for="price">💰 Fiyat (TL)</label>
                    <input type="number" id="price" name="price" placeholder="0.00" step="0.01" required value="{{ old('price') }}">
                </div>

                <div class="form-group">
                    <label for="stock">📊 Stok</label>
                    <input type="number" id="stock" name="stock" placeholder="0" required value="{{ old('stock') }}">
                </div>
            </div>

            <!-- Görsel Yükleme -->
            <div class="form-group">
                <label for="image">🖼️ Ürün Görseli</label>
                <div class="image-upload-area" id="imageUploadArea">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <p><strong>Görsel yüklemek için tıklayın</strong></p>
                    <small>Sürükleyip bırakabilir veya tıklayabilirsiniz</small>
                    <input type="file" id="image" name="image" accept="image/*" required style="display: none;">
                </div>
                <div id="imagePreview"></div>
            </div>

            <!-- Butonlar -->
            <div class="button-group">
                <button type="submit" class="btn-primary">✅ Ürünü Ekle</button>
                <button type="reset" class="btn-secondary">🔄 Temizle</button>
            </div>

            <div class="back-link">
                <a href="{{ route('products.index') }}">← Ürünlere Dön</a>
            </div>
        </form>
    </div>

    <script>
        const imageUploadArea = document.getElementById('imageUploadArea');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        // Tıklama
        imageUploadArea.addEventListener('click', () => imageInput.click());

        // Dosya seçildiğinde
        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                showPreview(file);
            }
        });

        // Sürükle bırak
        imageUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageUploadArea.classList.add('active');
        });

        imageUploadArea.addEventListener('dragleave', () => {
            imageUploadArea.classList.remove('active');
        });

        imageUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            imageUploadArea.classList.remove('active');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                showPreview(files[0]);
            }
        });

        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Önizleme">`;
                imagePreview.style.display = 'block';
                imageUploadArea.classList.add('active');
            };
            reader.readAsDataURL(file);
        }

        // Form validasyonu
        document.getElementById('productForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const description = document.getElementById('description').value.trim();
            const price = parseFloat(document.getElementById('price').value);
            const stock = parseInt(document.getElementById('stock').value);

            if (!name) {
                e.preventDefault();
                alert('❌ Ürün adı zorunludur!');
                return;
            }

            if (!description) {
                e.preventDefault();
                alert('❌ Açıklama zorunludur!');
                return;
            }

            if (price < 0) {
                e.preventDefault();
                alert('❌ Fiyat 0 veya daha fazla olmalıdır!');
                return;
            }

            if (stock < 0) {
                e.preventDefault();
                alert('❌ Stok 0 veya daha fazla olmalıdır!');
                return;
            }

            if (!imageInput.files.length) {
                e.preventDefault();
                alert('❌ Lütfen bir görsel seçin!');
                return;
            }
        });
    </script>
</body>
</html>
