<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // 1. Tampilkan Keranjang
    public function cart()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        
        // Hitung total harga
        $total = $carts->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('front.cart', compact('carts', 'total'));
    }

    // 2. Logic Tambah ke Keranjang
    public function addToCart(Request $request, $id)
    {
        // Cek login dulu (Middleware auth sudah menangani, tapi untuk keamanan ganda)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk belanja.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($id);

        // Cek apakah produk sudah ada di keranjang user ini?
        $existingCart = Cart::where('user_id', Auth::id())
                            ->where('product_id', $product->id)
                            ->first();

        if ($existingCart) {
            // Jika ada, update quantity
            $existingCart->quantity += $request->quantity;
            $existingCart->save();
        } else {
            // Jika belum, buat baru
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('cart')->with('success', 'Produk berhasil masuk keranjang!');
    }

    // 3. Hapus Item Keranjang
    public function removeCart($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Item dihapus.');
    }

    public function checkout()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        
        if ($carts->isEmpty()) {
            return redirect()->route('catalog');
        }

        $total = $carts->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('front.checkout', compact('carts', 'total'));
    }
    // 5. PROSES BAYAR (Integrasi Midtrans)
    public function processCheckout(Request $request)
    {
        // A. Validasi Input User
        $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'shipping_address' => 'required',
        ]);
        // ...
        // Kita panggil ulang user berdasarkan ID-nya pakai Model User langsung
        $user = \App\Models\User::find(Auth::id()); 
        
        $user->update([
            'address' => $request->shipping_address,
            'phone' => $request->customer_phone,
            'name' => $request->customer_name
        ]);
        // ...

        // B. Ambil Data Keranjang
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        if ($carts->isEmpty()) return redirect()->route('catalog');

        $totalPrice = $carts->sum(fn($item) => $item->product->price * $item->quantity);

        // C. Simpan ke Tabel Orders
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'pending',
            'tracking_number' => 'ORD-' . Str::upper(Str::random(10)), // Generate nomor resi unik
        ]);

        // D. Pindahkan Item dari Keranjang ke OrderItems
        foreach ($carts as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }
        

        // E. Kosongkan Keranjang
        Cart::where('user_id', Auth::id())->delete();

        // --- F. INTEGRASI MIDTRANS MULAI DISINI ---
        
        // Set konfigurasi midtrans
         // Set konfigurasi midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // 🔥 TAMBAHKAN BARIS INI (JURUS PAKSA NOTIFIKASI) 🔥
        // Ganti URL ini dengan domain hostinger kamu yang valid
        Config::$overrideNotifUrl = 'https://lime-goose-354032.hostingersite.com/midtrans-callback';

        // Buat params untuk dikirim ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . rand(), 
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => Auth::user()->email,
                'phone' => $request->customer_phone,
            ],
        ];

        // Minta Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($params);

        // Kirim Token dan Order ke view pembayaran
        return view('front.payment', compact('snapToken', 'order'));
    }

    public function myOrders()
    {
        // Ambil pesanan milik user yang login, urutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
                        ->with('items.product') // Load detail item & produknya
                        ->latest()
                        ->get();

        return view('front.orders', compact('orders'));
    }

    // ... method lainnya ...

    // 7. USER SELESAIKAN PESANAN
    public function markAsCompleted(Order $order)
    {
        // Pastikan hanya pemilik order yang bisa
        if ($order->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $order->update(['status' => 'completed']);
        return back()->with('success', 'Terima kasih! Pesanan telah selesai.');
    }

    // 8. KIRIM RATING / ULASAN
    public function submitReview(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        \App\Models\Review::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }
}



