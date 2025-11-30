<x-layout>
    <x-slot:title>Dashboard Pelanggan - Dapoer Bunasya</x-slot>

    <div class="max-w-5xl mx-auto">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-secondary rounded-full flex items-center justify-center text-2xl font-bold text-white">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold text-accent">Halo, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-400">Selamat datang kembali di Dapoer Bunasya.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="space-y-4">
                <a href="{{ route('my.orders') }}" class="block bg-[#2a2a2a] p-6 rounded-xl border border-secondary/20 hover:border-secondary transition group">
                    <div class="flex items-center justify-between mb-2">
                        <i class="fa-solid fa-receipt text-2xl text-secondary group-hover:scale-110 transition"></i>
                        <i class="fa-solid fa-arrow-right text-gray-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Riwayat Pesanan</h3>
                    <p class="text-gray-400 text-xs">Cek status pengiriman & nota.</p>
                </a>

                <a href="{{ route('cart') }}" class="block bg-[#2a2a2a] p-6 rounded-xl border border-secondary/20 hover:border-secondary transition group">
                    <div class="flex items-center justify-between mb-2">
                        <i class="fa-solid fa-cart-shopping text-2xl text-secondary group-hover:scale-110 transition"></i>
                        <i class="fa-solid fa-arrow-right text-gray-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Keranjang Belanja</h3>
                    <p class="text-gray-400 text-xs">Lihat item yang belum dibayar.</p>
                </a>
            </div>

            <div class="md:col-span-2 bg-[#2a2a2a] p-8 rounded-xl border border-gray-700">
                <h3 class="text-xl font-bold text-white mb-6 border-b border-gray-600 pb-4">Data Pribadi & Alamat</h3>
                
                <form action="#" method="POST"> @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="text-gray-400 text-sm mb-1 block">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()->name }}" readonly class="w-full bg-[#111] border border-gray-600 rounded p-2 text-gray-300 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="text-gray-400 text-sm mb-1 block">Email</label>
                            <input type="text" value="{{ Auth::user()->email }}" readonly class="w-full bg-[#111] border border-gray-600 rounded p-2 text-gray-300 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-gray-400 text-sm mb-1 block">Nomor WhatsApp</label>
                        <input type="text" value="{{ Auth::user()->phone ?? '-' }}" readonly class="w-full bg-[#111] border border-gray-600 rounded p-2 text-gray-300">
                    </div>

                    <div class="mb-6">
                        <label class="text-gray-400 text-sm mb-1 block">Alamat Pengiriman Utama</label>
                        <textarea readonly class="w-full bg-[#111] border border-gray-600 rounded p-2 text-gray-300 h-24">{{ Auth::user()->address ?? 'Belum ada alamat tersimpan. Silakan belanja untuk mengisi otomatis.' }}</textarea>
                    </div>

                    <p class="text-xs text-yellow-500">* Data alamat akan otomatis terupdate saat Anda melakukan Checkout.</p>
                </form>
            </div>
        </div>
    </div>
</x-layout>