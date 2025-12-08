<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminOrderController;



/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/katalog', [FrontController::class, 'catalog'])->name('catalog');
Route::get('/produk/{product:slug}', [FrontController::class, 'detail'])->name('product.detail');

// AUTH (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| 2. CUSTOMER ROUTES (Harus Login sebagai Pelanggan)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    // Dashboard Pelanggan
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');

    // Keranjang Belanja
    Route::get('/keranjang', [OrderController::class, 'cart'])->name('cart');
    Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [OrderController::class, 'removeCart'])->name('cart.remove');
    Route::patch('/pesanan/{order}/selesai', [OrderController::class, 'markAsCompleted'])->name('orders.complete');
    Route::post('/pesanan/{order}/review', [OrderController::class, 'submitReview'])->name('orders.review');
    // Checkout & Pembayaran
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');

    // Riwayat Pesanan
    Route::get('/pesanan-saya', [OrderController::class, 'myOrders'])->name('my.orders');
});


/*
|--------------------------------------------------------------------------
| 3. WEBHOOK MIDTRANS (Wajib di luar Auth & CSRF)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans-callback', [MidtransController::class, 'callback']);


/*
|--------------------------------------------------------------------------
| 4. ADMIN ROUTES (Harus Login sebagai Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'adminIndex'])->name('dashboard');
    Route::get('/customers', [\App\Http\Controllers\UserController::class, 'indexCustomer'])->name('customers.index');
    Route::delete('/customers/{user}', [\App\Http\Controllers\UserController::class, 'destroyCustomer'])->name('customers.destroy');
    // Manajemen Produk (Resource Controller)
    Route::resource('products', ProductController::class);
    // ... route admin lainnya ...
     Route::get('/laporan', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

    // --- TAMBAHKAN INI (Menu Trend & Analitik) ---
    Route::get('/trends', [\App\Http\Controllers\TrendController::class, 'index'])->name('trends.index');
    // Manajemen Laporan Keuangan (Tambahkan baris ini)
    Route::get('/laporan', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

    // ...
    // Manajemen Kategori
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    // Manajemen Pesanan (Menggunakan AdminOrderController)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show'); // Ini solusi error tadi
    Route::patch('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.update');
});


/*
|--------------------------------------------------------------------------
| 5. CASHIER ROUTES (Harus Login sebagai Kasir)
|--------------------------------------------------------------------------
*/
Route::prefix('kasir')->middleware(['auth', 'role:kasir'])->name('kasir.')->group(function () {
    Route::get('/', [DashboardController::class, 'cashierIndex'])->name('dashboard');
    
    // POS SYSTEM
    Route::get('/pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos');
    Route::post('/pos/add/{id}', [\App\Http\Controllers\PosController::class, 'addToCart'])->name('pos.add');
    Route::post('/pos/decrease/{id}', [\App\Http\Controllers\PosController::class, 'decreaseCart'])->name('pos.decrease');
    Route::post('/pos/clear', [\App\Http\Controllers\PosController::class, 'clearCart'])->name('pos.clear');
    Route::post('/pos/process', [\App\Http\Controllers\PosController::class, 'processTransaction'])->name('pos.process');
    Route::get('/pos/print/{order}', [\App\Http\Controllers\PosController::class, 'printStruk'])->name('print');
});
Route::get('/debug/force-paid/{id}', function($id) {
    $order = \App\Models\Order::find($id);
    if($order) {
        $order->update(['payment_status' => 'paid', 'status' => 'processed']);
        return redirect()->back()->with('success', 'Order dipaksa LUNAS!');
    }
    return "Order tidak ditemukan";
});

Route::get('/debug/force-paid/{id}', function ($id) {
    $order = \App\Models\Order::with('items')->find($id);

    if (!$order) return "Order tidak ditemukan!";

    // 1. Ubah Status
    $order->update([
        'payment_status' => 'paid',
        'status' => 'processed'
    ]);

    // 2. Kurangi Stok (Penting!)
    foreach ($order->items as $item) {
        $product = \App\Models\Product::find($item->product_id);
        $product->decrement('stock', $item->quantity);
    }

    return redirect()->route('my.orders')->with('success', 'Berhasil dipaksa LUNAS (Mode Debug)');
});
