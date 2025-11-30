<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PosController extends Controller
{
    // 1. HALAMAN UTAMA POS
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter Pencarian
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        // Filter Kategori
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }
        
        $products = $query->get();
        $categories = Category::all();
        
        // Ambil Cart dari Session (Khusus Kasir)
        $cart = session()->get('pos_cart', []);
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('kasir.pos', compact('products', 'categories', 'cart', 'total'));
    }

    // 2. TAMBAH ITEM KE KERANJANG KASIR
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('pos_cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $product->id, // Penting simpan ID
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('pos_cart', $cart);
        return redirect()->back();
    }

    // 3. KURANGI QTY / HAPUS ITEM
    public function decreaseCart($id)
    {
        $cart = session()->get('pos_cart', []);

        if(isset($cart[$id])) {
            if($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }
            session()->put('pos_cart', $cart);
        }
        return redirect()->back();
    }

    // 4. BATALKAN TRANSAKSI (CLEAR CART)
    public function clearCart()
    {
        session()->forget('pos_cart');
        return redirect()->back();
    }

    // 5. PROSES BAYAR & CETAK
    public function processTransaction(Request $request)
    {
        $cart = session()->get('pos_cart', []);
        if(empty($cart)) return redirect()->back()->with('error', 'Keranjang kosong!');

        $totalPrice = 0;
        foreach($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Hitung Kembalian
        $bayar = $request->cash_amount;
        if($bayar < $totalPrice) {
            return redirect()->back()->with('error', 'Uang pembayaran kurang!');
        }

        // 1. Simpan Order
        $order = Order::create([
            'user_id' => Auth::id(), // Kasir yang menangani
            'customer_name' => $request->customer_name ?? 'Pelanggan Umum',
            'customer_phone' => '-', 
            'shipping_address' => 'Pembelian di Toko (POS)',
            'total_price' => $totalPrice,
            'status' => 'completed', // Langsung selesai
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'tracking_number' => 'POS-' . strtoupper(Str::random(8)),
        ]);

        // 2. Simpan Item & Kurangi Stok
        foreach($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Kurangi Stok
            $product = Product::find($id);
            if($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        // 3. Bersihkan Cart
        session()->forget('pos_cart');

        // 4. Redirect ke Halaman Cetak Struk
        return redirect()->route('kasir.print', ['order' => $order->id, 'bayar' => $bayar, 'kembali' => ($bayar - $totalPrice)]);
    }

    // 6. HALAMAN CETAK STRUK
    public function printStruk(Order $order, Request $request)
    {
        $bayar = $request->bayar;
        $kembali = $request->kembali;
        return view('kasir.struk', compact('order', 'bayar', 'kembali'));
    }
}