<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Definisikan Periode (Default: Bulan Ini)
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();
        $filterType = $request->filter_type ?? 'monthly'; // daily, weekly, monthly, yearly

        // 2. Query Data (Hanya yang statusnya PAID/COMPLETED)
        $query = Order::where('payment_status', 'paid')
                      ->whereBetween('created_at', [
                          Carbon::parse($startDate)->startOfDay(), 
                          Carbon::parse($endDate)->endOfDay()
                      ]);

        $orders = $query->latest()->get();
        
        // 3. Hitung Total Pendapatan
        $totalRevenue = $orders->sum('total_price');

        // 4. Jika request Export Excel (CSV)
        if ($request->has('export_excel')) {
            return $this->exportExcel($orders);
        }

        return view('admin.reports.index', compact('orders', 'totalRevenue', 'startDate', 'endDate', 'filterType'));
    }

    // Fungsi Export CSV Sederhana (Tanpa Library Berat)
    private function exportExcel($orders)
    {
        $fileName = "laporan_penjualan_" . date('Y-m-d_H-i') . ".csv";
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Order ID', 'Tanggal', 'Pelanggan', 'Status', 'Total Bayar');

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, array(
                    '#' . $order->id,
                    $order->created_at->format('Y-m-d H:i'),
                    $order->customer_name,
                    $order->status,
                    $order->total_price
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}