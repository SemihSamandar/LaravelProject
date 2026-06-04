@extends('layouts.admin')

@section('content')

<style>
    .page-wrapper {
        padding: 30px;
        background: #f4f6f9;
        min-height: 100vh;
    }

    .container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
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

    input:focus,
    textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background-color: #f8f9ff;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
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
        transition: 0.3s;
        background-color: #f8f9ff;
    }

    .image-upload-area:hover {
        border-color: #764ba2;
    }

    .image-upload-area.active {
        border-color: #27ae60;
        background-color: #f0fdf4;
    }

    #imagePreview {
        margin-top: 15px;
        display: none;
    }

    #imagePreview img {
        max-width: 100%;
        border-radius: 8px;
    }

    .button-group {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    button {
        flex: 1;
        padding: 14px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .btn-secondary {
        background: #e0e0e0;
    }

    .error-message {
        background: #fee;
        border: 1px solid #fcc;
        color: #c33;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .success-message {
        background: #efe;
        border: 1px solid #cfc;
        color: #090;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
</style>

<div class="page-wrapper">
    <div class="container">

        <div class="header">
            <h1>✨ Add Product</h1>
            <p>Fill product details and upload image</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>❌ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="success-message">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf

            <div class="form-group">
                <label>📦 Product Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>📝 Description</label>
                <textarea name="description" required>{{ old('description') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>💰 Price</label>
                    <input type="number" name="price" step="0.01" value="{{ old('price') }}" required>
                </div>

                <div class="form-group">
                    <label>📊 Stock</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>🖼️ Product Image</label>
                <div class="image-upload-area" id="uploadArea">
                    Click or drag image
                    <input type="file" name="image" id="imageInput" hidden required>
                </div>
                <div id="imagePreview"></div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-primary">Save</button>
                <button type="reset" class="btn-secondary">Clear</button>
            </div>

        </form>
    </div>
</div>

<script>
    const uploadArea = document.getElementById('uploadArea');
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');

    uploadArea.addEventListener('click', () => input.click());

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.innerHTML = `<img src="${e.target.result}">`;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    uploadArea.addEventListener('dragover', e => {
        e.preventDefault();
        uploadArea.classList.add('active');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('active');
    });

    uploadArea.addEventListener('drop', e => {
        e.preventDefault();
        input.files = e.dataTransfer.files;
        uploadArea.classList.remove('active');
        input.dispatchEvent(new Event('change'));
    });
</script>

@endsection