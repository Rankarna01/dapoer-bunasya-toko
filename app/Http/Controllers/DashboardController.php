<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // 1. DASHBOARD ADMIN
    public function adminIndex()
    {
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');
        $totalOrders = Order::count();
        $pendingOrders = Order::whereIn('status', ['pending', 'paid', 'processed'])->count();
        $totalProducts = Product::count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalRevenue', 'totalOrders', 'pendingOrders', 'totalProducts', 'recentOrders'));
    }

    // 2. DASHBOARD KASIR (INI YANG KURANG TADI)
    public function cashierIndex()
    {
        // Hitung penjualan kasir ini HARI INI
        $todayRevenue = Order::where('user_id', Auth::id()) // Transaksi oleh kasir ini
                             ->where('payment_status', 'paid')
                             ->whereDate('created_at', Carbon::today())
                             ->sum('total_price');

        // Hitung total transaksi kasir ini HARI INI
        $todayTransactionCount = Order::where('user_id', Auth::id())
                                      ->whereDate('created_at', Carbon::today())
                                      ->count();

        return view('kasir.dashboard', compact('todayRevenue', 'todayTransactionCount'));
    }
}