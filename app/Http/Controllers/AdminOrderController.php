<?php

namespace App\Http\Controllers;

use App\Models\Order; // <-- Bu satırın eklendiğinden emin olun!
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')->latest()->get();
        return view('admin.orders', compact('orders'));
    }
}