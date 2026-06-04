<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body style="margin:0; font-family: Arial;">

<div style="display:flex; height:100vh;">

    <!-- SIDEBAR -->
    <div style="width:250px; background:#2d3748; color:white; padding:20px;">
        <h2>Admin</h2>

        <ul style="list-style:none; padding:0;">
            <li>
                <a href="{{ route('products.index') }}" style="color:white;">Products</a>
            </li>
            <li>
                <a href="{{ route('products.create') }}" style="color:white;">Add Product</a>
            </li>
        </ul>
    </div>

    <!-- CONTENT -->
    <div style="flex:1; padding:20px;">
        @yield('content')
    </div>

</div>

</body>
</html>