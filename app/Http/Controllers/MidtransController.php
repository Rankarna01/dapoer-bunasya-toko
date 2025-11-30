<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // 2. Buat Instance Notifikasi dari data yang dikirim Midtrans
        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Notification Error'], 500);
        }

        // 3. Ambil data penting
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderIdRaw = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Bersihkan Order ID (misal: 12-123456 menjadi 12) jika tadi pakai random number
        // Tapi kalau di OrderController kamu pakai "$order->id", maka split dulu
        // Format order_id di OrderController tadi: $order->id . '-' . rand()
        $orderIdParts = explode('-', $orderIdRaw);
        $realOrderId = $orderIdParts[0];

        // 4. Cari Order di Database
        $order = Order::with('items.product')->find($realOrderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Jika order sudah paid, jangan proses lagi (untuk menghindari stok berkurang 2x)
        if ($order->payment_status == 'paid') {
            return response()->json(['message' => 'Order already paid'], 200);
        }

        // 5. Logika Status Pembayaran
        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->update(['payment_status' => 'pending']);
                } else {
                    $this->makeOrderPaid($order);
                }
            }
        } else if ($transaction == 'settlement') {
            // INI YANG PALING PENTING (Sukses Bayar via Transfer/Gopay/dll)
            $this->makeOrderPaid($order);
        } else if ($transaction == 'pending') {
            $order->update(['payment_status' => 'pending']);
        } else if ($transaction == 'deny') {
            $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
        } else if ($transaction == 'expire') {
            $order->update(['payment_status' => 'expired', 'status' => 'cancelled']);
        } else if ($transaction == 'cancel') {
            $order->update(['payment_status' => 'cancelled', 'status' => 'cancelled']);
        }

        return response()->json(['message' => 'Callback received successfully']);
    }

    // --- FUNGSI UPDATE STATUS & KURANGI STOK ---
    private function makeOrderPaid($order)
    {
        // 1. Update Status Order
        $order->update([
            'payment_status' => 'paid',
            'status' => 'processed' // Langsung ubah jadi processed agar siap dikemas
        ]);

        // 2. Kurangi Stok Produk Otomatis
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                // Kurangi stok (decrement aman dari race condition)
                $product->decrement('stock', $item->quantity);
            }
        }
    }
}