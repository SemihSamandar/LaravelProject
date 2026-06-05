<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
   public function index()
{
    $orders = Order::with('items.product')->latest()->get();
    return view('admin.orders', compact('orders'));
}
}
