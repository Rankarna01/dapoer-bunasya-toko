<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // 1. LIHAT SEMUA PESANAN
    public function index()
    {
        // Ambil order urut dari yang terbaru
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // 2. LIHAT DETAIL (ALAMAT & ITEM)
    public function show(Order $order)
    {
        // Load detail item dan produknya
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    // 3. UPDATE STATUS PENGANTARAN
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processed,on_delivery,delivered,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}