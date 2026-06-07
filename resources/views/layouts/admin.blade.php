<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - ShopHub')</title>
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
            --sidebar-bg: #1a2332;
            --sidebar-hover: #252f42;
            --accent: #2d5a8c;
            --accent-light: #e8f1f8;
            --text-dark: #1a1a1a;
            --text-light: #666666;
            --text-muted: #999999;
            --border: #e0e0e0;
            --border-dark: #2d3f52;
            --bg-light: #fafbfc;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.12);
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        /* ===== LAYOUT ===== */
        #app {
            display: flex;
            height: 100vh;
            flex-direction: row;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, var(--sidebar-bg) 0%, #22334a 100%);
            color: white;
            padding: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.15);
            overflow-y: auto;
            position: relative;
            z-index: 999;
        }

        /* Scrollbar styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* ===== SIDEBAR HEADER ===== */
        .sidebar-header {
            padding: 32px 24px;
            border-bottom: 1px solid var(--border-dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo {
            font-size: 28px;
        }

        .sidebar-title {
            font-size: 20px;
            font-weight: 800;
            font-family: 'Playfair Display', serif;
            color: white;
        }

        /* ===== SIDEBAR NAV ===== */
        .sidebar-nav {
            flex: 1;
            padding: 24px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-section {
            margin-bottom: 24px;
        }

        .nav-section-title {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 12px;
            margin-bottom: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .nav-item:hover {
            background: var(--sidebar-hover);
            color: white;
            padding-left: 20px;
        }

        .nav-item.active {
            background: var(--accent);
            color: white;
        }

        .nav-item-icon {
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
        }

        .nav-item-text {
            flex: 1;
        }

        /* ===== SIDEBAR FOOTER ===== */
        .sidebar-footer {
            padding: 24px;
            border-top: 1px solid var(--border-dark);
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: auto;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: white;
            margin-bottom: 2px;
        }

        .user-role {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.1);
            color: rgba(239, 68, 68, 0.9);
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.5);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ===== TOP BAR ===== */
        .topbar {
            background: var(--secondary);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-sm);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-dark);
            display: none;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
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

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            font-size: 13px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .topbar-item:hover {
            color: var(--accent);
        }

        .notification-badge {
            background: var(--danger);
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 700;
        }

        /* ===== CONTENT AREA ===== */
        .content {
            flex: 1;
            overflow-y: auto;
            padding: 32px;
        }

        .content-header {
            margin-bottom: 32px;
            animation: fadeInDown 0.6s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-title {
            font-size: 32px;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .content-subtitle {
            font-size: 14px;
            color: var(--text-light);
        }

        /* ===== CARDS ===== */
        .card {
            background: var(--secondary);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .card:hover {
            border-color: var(--accent);
            box-shadow: var(--shadow-md);
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px;
            color: var(--primary);
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--bg-light);
            color: var(--text-dark);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: white;
            border-color: var(--accent);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        /* ===== GRID ===== */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }

        .stat-card {
            background: var(--secondary);
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
        }

        .stat-icon {
            font-size: 28px;
            margin-bottom: 12px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            #app {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                max-height: 70px;
                flex-direction: row;
                padding: 0 16px;
                align-items: center;
                position: sticky;
                top: 0;
            }

            .sidebar-header {
                padding: 16px;
                border-bottom: none;
                border-right: 1px solid var(--border-dark);
            }

            .sidebar-nav {
                padding: 0;
                flex-direction: row;
                gap: 0;
                flex: 1;
                margin: 0;
                overflow-x: auto;
            }

            .nav-section {
                margin-bottom: 0;
            }

            .nav-section-title {
                display: none;
            }

            .nav-item {
                padding: 16px 12px;
                white-space: nowrap;
            }

            .sidebar-footer {
                display: none;
            }

            .menu-toggle {
                display: block;
            }

            .topbar {
                padding: 12px 16px;
            }

            .content {
                padding: 20px;
            }

            .content-title {
                font-size: 24px;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .sidebar-title {
                font-size: 16px;
            }

            .nav-item-text {
                display: none;
            }

            .breadcrumb {
                display: none;
            }

            .content {
                padding: 16px;
            }

            .content-title {
                font-size: 20px;
            }

            .topbar-item span {
                display: none;
            }
        }
    </style>
</head>

<body>

<div id="app">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <!-- Header -->
        <div class="sidebar-header">
            <div class="sidebar-logo">✨</div>
            <div class="sidebar-title">ShopHub</div>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <!-- Main Section -->
            <div class="nav-section">
                <div class="nav-section-title">Ürün Yönetimi</div>

                <a href="{{ route('products.index') }}" class="nav-item">
                    <span class="nav-item-icon">📦</span>
                    <span class="nav-item-text">Ürünler</span>
                </a>

                <a href="{{ route('products.create') }}" class="nav-item">
                    <span class="nav-item-icon">➕</span>
                    <span class="nav-item-text">Yeni Ürün Ekle</span>
                </a>

<a href="{{ route('admin.orders.index') }}">
    <span>📦 Siparişler</span>
</a>

            </div>
        </nav>

        <!-- Footer -->
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">A</div>
                <div class="user-details">
                    <div class="user-name">Admin</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
            <button class="logout-btn" onclick="alert('Çıkış yapılıyor...')">
                🚪 Çıkış
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOP BAR -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle">☰</button>
                <div class="breadcrumb">
                    <a href="{{ route('products.index') }}">Ürünler</a>
                    <span>/</span>
                    <span>@yield('breadcrumb', 'Sayfa')</span>
                </div>
            </div>

            <div class="topbar-right">
                <div class="topbar-item">
                    🏠
                    <a href="/" style="color: inherit; text-decoration: none;">Ana Sayfa</a>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>

<script>
    // Mobile menu toggle
    document.querySelector('.menu-toggle')?.addEventListener('click', function() {
        document.querySelector('.sidebar').style.display = 
            document.querySelector('.sidebar').style.display === 'none' ? 'flex' : 'none';
    });

    // Active nav item based on current route
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-item').forEach(item => {
        if (item.href.includes(currentPath.split('/')[currentPath.split('/').length - 1])) {
            item.classList.add('active');
        }
    });

    // Smooth transitions
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function(e) {
            if (this.href === '#') e.preventDefault();
        });
    });
</script>

</body>
</html>