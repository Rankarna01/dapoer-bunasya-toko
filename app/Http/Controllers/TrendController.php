<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrendController extends Controller
{
    public function index()
    {
        // 1. DATA PRODUK TERLARIS (Top 5)
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with('product') // Ambil nama produknya
            ->get();

        // Siapkan array untuk Chart.js
        $productLabels = [];
        $productData = [];
        foreach ($topProducts as $item) {
            $productLabels[] = $item->product->name;
            $productData[] = $item->total_sold;
        }

        // 2. DATA PENDAPATAN 7 HARI TERAKHIR
        $revenueData = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'), 
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Mapping agar tanggal yang kosong tetap ada (opsional, tapi biar rapi kita pakai data yg ada dulu)
        $revenueLabels = [];
        $revenueValues = [];
        
        foreach($revenueData as $data) {
            $revenueLabels[] = Carbon::parse($data->date)->format('d M');
            $revenueValues[] = $data->total;
        }

        return view('admin.trends.index', compact(
            'productLabels', 'productData', 
            'revenueLabels', 'revenueValues'
        ));
    }
}