<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Dapoer Bunasya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #121212; color: #F5F5DC; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #8D6E63; border-radius: 4px; }
    </style>
</head>
<body class="h-screen flex overflow-hidden">

    <!-- BAGIAN KIRI: DAFTAR PRODUK -->
    <div class="flex-1 flex flex-col border-r border-gray-800">
        
        <!-- Header POS -->
        <div class="h-16 bg-[#1a1a1a] flex items-center justify-between px-6 border-b border-gray-800">
            <a href="{{ route('kasir.dashboard') }}" class="text-secondary hover:text-white flex items-center gap-2 font-bold">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-xl font-bold tracking-widest text-white">
                <i class="fa-solid fa-cash-register mr-2 text-secondary"></i> KASIR
            </h1>
            <div class="text-sm text-gray-400">
                <i class="fa-solid fa-user-circle"></i> {{ Auth::user()->name }}
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="p-4 bg-[#1a1a1a] border-b border-gray-800 flex gap-4">
            <form action="{{ route('kasir.pos') }}" method="GET" class="flex-1 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kue..." class="flex-1 bg-[#222] border border-gray-700 text-white rounded-lg px-4 py-2 focus:border-secondary focus:outline-none">
                <select name="category" onchange="this.form.submit()" class="bg-[#222] border border-gray-700 text-white rounded-lg px-4 py-2 focus:border-secondary focus:outline-none cursor-pointer">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>

        <!-- Grid Produk -->
        <div class="flex-1 overflow-y-auto p-4 bg-[#121212]">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $product)
                    <form action="{{ route('kasir.pos.add', $product->id) }}" method="POST" class="h-full">
                        @csrf
                        <button type="submit" class="w-full h-full bg-[#1e1e1e] rounded-xl border border-gray-800 hover:border-secondary transition p-3 text-left group flex flex-col">
                            <div class="relative w-full h-32 mb-3 overflow-hidden rounded-lg">
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <div class="absolute bottom-0 right-0 bg-black/70 text-white text-xs px-2 py-1 rounded-tl-lg">
                                    Stok: {{ $product->stock }}
                                </div>
                            </div>
                            <h3 class="font-bold text-white text-sm line-clamp-1 group-hover:text-secondary">{{ $product->name }}</h3>
                            <p class="text-secondary font-bold mt-auto">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    </div>

    <!-- BAGIAN KANAN: KERANJANG & BAYAR -->
    <div class="w-96 bg-[#1a1a1a] flex flex-col shadow-2xl z-20">
        <div class="h-16 flex items-center justify-between px-6 border-b border-gray-800 bg-[#1a1a1a]">
            <h2 class="font-bold text-white">Keranjang</h2>
            <form action="{{ route('kasir.pos.clear') }}" method="POST" onsubmit="return confirm('Kosongkan keranjang?')">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-400 text-sm"><i class="fa-solid fa-trash"></i> Reset</button>
            </form>
        </div>

        <!-- List Item -->
        <div class="flex-1 overflow-y-auto p-4 space-y-3">
            @forelse($cart as $id => $item)
                <div class="bg-[#222] p-3 rounded-lg border border-gray-700 flex justify-between items-center">
                    <div class="flex-1">
                        <h4 class="text-white text-sm font-bold">{{ $item['name'] }}</h4>
                        <p class="text-secondary text-xs">@ Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <form action="{{ route('kasir.pos.decrease', $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-6 h-6 rounded bg-gray-700 text-white hover:bg-red-500 flex items-center justify-center text-xs">-</button>
                        </form>
                        <span class="text-white text-sm font-bold w-4 text-center">{{ $item['quantity'] }}</span>
                        <form action="{{ route('kasir.pos.add', $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-6 h-6 rounded bg-gray-700 text-white hover:bg-green-500 flex items-center justify-center text-xs">+</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 mt-10">
                    <i class="fa-solid fa-basket-shopping text-4xl mb-2"></i>
                    <p>Keranjang Kosong</p>
                </div>
            @endforelse
        </div>

        <!-- Bagian Pembayaran -->
        <div class="p-6 bg-[#222] border-t border-gray-800">
            <div class="flex justify-between text-gray-400 text-sm mb-1">
                <span>Subtotal</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-white font-bold text-xl mb-4">
                <span>Total</span>
                <span class="text-secondary">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            @if(session('error'))
                <div class="bg-red-500/20 text-red-400 p-2 rounded text-xs mb-4 text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('kasir.pos.process') }}" method="POST">
                @csrf
                <!-- Input Nama Pelanggan (Opsional) -->
                <div class="mb-3">
                    <input type="text" name="customer_name" placeholder="Nama Pelanggan (Opsional)" class="w-full bg-[#111] border border-gray-700 rounded p-2 text-white text-sm focus:border-secondary focus:outline-none">
                </div>
                
                <!-- Input Uang Tunai -->
                <div class="mb-4 relative">
                    <span class="absolute left-3 top-2 text-gray-500 text-sm">Rp</span>
                    <input type="number" name="cash_amount" required placeholder="Uang Tunai" class="w-full bg-[#111] border border-gray-700 rounded p-2 pl-8 text-white text-sm focus:border-secondary focus:outline-none">
                </div>

                <button type="submit" class="w-full bg-secondary text-white py-3 rounded-lg font-bold hover:bg-secondary-dark transition shadow-lg flex items-center justify-center gap-2 disabled:opacity-50" {{ empty($cart) ? 'disabled' : '' }}>
                    <i class="fa-solid fa-print"></i> BAYAR & CETAK
                </button>
            </form>
        </div>
    </div>

</body>
</html>