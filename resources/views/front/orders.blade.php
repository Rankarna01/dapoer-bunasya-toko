<x-layout>
    <x-slot:title>Pesanan Saya - Dapoer Bunasya</x-slot>

    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-accent mb-2">Lacak Pesanan</h1>
        <p class="text-gray-400 mb-8">Pantau perjalanan kue premium Anda dari dapur hingga ke rumah.</p>

        @if (session('success'))
            <div class="bg-green-600/20 border border-green-500 text-green-200 p-4 rounded-xl mb-6">
                <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if ($orders->isEmpty())
            <div class="bg-[#2a2a2a] rounded-xl p-12 text-center border border-dashed border-gray-600">
                <i class="fa-solid fa-receipt text-6xl text-gray-600 mb-4"></i>
                <h3 class="text-xl text-white font-bold mb-2">Belum ada pesanan</h3>
                <a href="{{ route('catalog') }}"
                    class="bg-secondary text-white px-6 py-2 rounded-lg hover:bg-secondary-dark transition mt-4 inline-block">
                    Pesan Sekarang
                </a>
            </div>
        @else
            <div class="space-y-8">
                @foreach ($orders as $order)
                    <div
                        class="bg-[#2a2a2a] rounded-2xl overflow-hidden border border-secondary/20 shadow-2xl relative">

                        <div class="bg-[#222] p-5 border-b border-gray-700 flex justify-between items-center">
                            <div>
                                <span class="text-gray-500 text-xs font-bold tracking-widest uppercase">Order
                                    #{{ $order->id }}</span>
                                <p class="text-gray-300 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                {{ $order->payment_status == 'paid' ? 'bg-secondary/20 text-secondary' : 'bg-yellow-500/20 text-yellow-500' }}">
                                {{ $order->payment_status == 'paid' ? 'SUDAH DIBAYAR' : 'BELUM BAYAR' }}
                            </span>
                        </div>

                        @if ($order->payment_status == 'paid' && $order->status != 'cancelled')
                            <div class="p-6 pb-2">
                                <div class="flex items-center justify-between relative px-2 md:px-10">
                                    <div
                                        class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-700 -z-0">
                                    </div>

                                    <div class="relative z-10 text-center bg-[#2a2a2a] px-2">
                                        <div
                                            class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center border-2 {{ in_array($order->status, ['paid', 'processed', 'on_delivery', 'delivered', 'completed']) ? 'bg-green-600 border-green-600 text-white shadow-[0_0_15px_rgba(22,163,74,0.5)]' : 'bg-gray-800 border-gray-600 text-gray-500' }}">
                                            <i class="fa-solid fa-wallet text-sm md:text-lg"></i>
                                        </div>
                                        <p class="text-[10px] md:text-xs mt-2 text-gray-400 font-bold uppercase">Dibayar
                                        </p>
                                    </div>

                                    <div class="relative z-10 text-center bg-[#2a2a2a] px-2">
                                        <div
                                            class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center border-2 transition-all duration-500
                                        {{ in_array($order->status, ['processed', 'on_delivery', 'delivered', 'completed']) ? 'bg-secondary border-secondary text-white shadow-[0_0_15px_rgba(141,110,99,0.6)]' : 'bg-gray-800 border-gray-600 text-gray-500' }}
                                        {{ $order->status == 'processed' ? 'animate-pulse' : '' }}">
                                            <i class="fa-solid fa-fire-burner text-sm md:text-lg"></i>
                                        </div>
                                        <p
                                            class="text-[10px] md:text-xs mt-2 {{ $order->status == 'processed' ? 'text-secondary animate-pulse' : 'text-gray-400' }} font-bold uppercase">
                                            Disiapkan</p>
                                    </div>

                                    <div class="relative z-10 text-center bg-[#2a2a2a] px-2">
                                        <div
                                            class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center border-2 transition-all duration-500
                                        {{ in_array($order->status, ['on_delivery', 'delivered', 'completed']) ? 'bg-orange-600 border-orange-600 text-white shadow-[0_0_15px_rgba(234,88,12,0.6)]' : 'bg-gray-800 border-gray-600 text-gray-500' }}
                                        {{ $order->status == 'on_delivery' ? 'animate-bounce' : '' }}">
                                            <i class="fa-solid fa-motorcycle text-sm md:text-lg"></i>
                                        </div>
                                        <p
                                            class="text-[10px] md:text-xs mt-2 {{ $order->status == 'on_delivery' ? 'text-orange-500' : 'text-gray-400' }} font-bold uppercase">
                                            Diantar</p>
                                    </div>

                                    <div class="relative z-10 text-center bg-[#2a2a2a] px-2">
                                        <div
                                            class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center border-2 
                                        {{ $order->status == 'completed' ? 'bg-blue-600 border-blue-600 text-white shadow-[0_0_15px_rgba(37,99,235,0.6)]' : 'bg-gray-800 border-gray-600 text-gray-500' }}">
                                            <i class="fa-solid fa-star text-sm md:text-lg"></i>
                                        </div>
                                        <p
                                            class="text-[10px] md:text-xs mt-2 {{ $order->status == 'completed' ? 'text-blue-500' : 'text-gray-400' }} font-bold uppercase">
                                            Selesai</p>
                                    </div>
                                </div>

                                <div class="text-center mt-6 bg-[#333] p-3 rounded-lg mx-6">
                                    <p class="text-accent text-sm">
                                        Status saat ini:
                                        <span class="font-bold text-white">
                                            @if ($order->status == 'processed')
                                                <i class="fa-solid fa-fire-burner text-secondary mr-2"></i> Pesanan Anda
                                                sedang dibuat dengan cinta oleh Chef kami.
                                            @elseif($order->status == 'on_delivery')
                                                <i class="fa-solid fa-motorcycle text-orange-500 mr-2"></i> Kurir sedang
                                                meluncur ke lokasi Anda!
                                            @elseif($order->status == 'delivered')
                                                <i class="fa-solid fa-box-open text-green-500 mr-2"></i> Paket sudah
                                                sampai! Mohon konfirmasi terima pesanan.
                                            @elseif($order->status == 'completed')
                                                <i class="fa-solid fa-star text-yellow-400 mr-2"></i> Transaksi Selesai.
                                                Terima kasih!
                                            @else
                                                <i class="fa-regular fa-clock text-gray-400 mr-2"></i> Menunggu proses
                                                selanjutnya.
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="p-6 pt-2">
                            <h4 class="text-gray-500 text-xs uppercase mb-4 font-bold border-b border-gray-700 pb-2">
                                Detail Produk</h4>
                            <div class="space-y-4">
                                @foreach ($order->items as $item)
                                    <div class="flex items-center gap-4">
                                        <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/' . $item->product->image) }}"
                                            class="w-16 h-16 object-cover rounded-lg border border-gray-600">
                                        <div class="flex-1">
                                            <h4 class="text-white font-bold">{{ $item->product->name }}</h4>
                                            <p class="text-xs text-gray-400">{{ $item->quantity }} x Rp
                                                {{ number_format($item->price, 0, ',', '.') }}</p>

                                            @if ($order->status == 'completed')
                                                <button
                                                    onclick="openReviewModal('{{ $item->product->id }}', '{{ $item->product->name }}', '{{ $order->id }}')"
                                                    class="text-[10px] text-yellow-500 hover:text-yellow-400 underline mt-1">
                                                    <i class="fa-solid fa-star"></i> Beri Ulasan
                                                </button>
                                            @endif
                                        </div>
                                        <div class="text-white font-bold">Rp
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div
                            class="bg-[#1f1f1f] p-5 flex flex-col md:flex-row justify-between items-center gap-4 border-t border-gray-700">
                            <div class="text-center md:text-left">
                                <span class="text-gray-400 text-xs">Total Pembayaran</span>
                                <p class="text-secondary font-bold text-2xl">Rp
                                    {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>

                            <div class="flex gap-3">
                                @if ($order->payment_status == 'pending')
                                    <button onclick="window.location.reload()"
                                        class="bg-secondary text-white px-6 py-2 rounded-full hover:bg-secondary-dark transition shadow-lg animate-pulse font-bold">
                                        Bayar Sekarang
                                    </button>
                                @endif

                                @if ($order->status == 'delivered')
                                    <form action="{{ route('orders.complete', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition shadow-lg font-bold flex items-center gap-2">
                                            <i class="fa-solid fa-check"></i> Pesanan Diterima
                                        </button>
                                    </form>
                                @endif

                                <a href="https://wa.me/628123456789"
                                    class="border border-gray-600 text-gray-400 px-4 py-2 rounded-full hover:bg-white hover:text-black transition flex items-center gap-2 text-sm">
                                    <i class="fa-brands fa-whatsapp"></i> Bantuan
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="reviewModal"
        class="fixed inset-0 bg-black/80 z-[60] hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-[#2a2a2a] w-full max-w-md rounded-2xl border border-secondary/30 shadow-2xl p-6 relative">
            <button onclick="closeReviewModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white"><i
                    class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="text-xl font-bold text-white mb-1">Beri Ulasan Produk</h3>
            <p class="text-secondary text-sm mb-6" id="modalProductName">Nama Produk</p>

            <form id="reviewForm" action="" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">

                <div class="flex gap-2 justify-center mb-6">
                    @for ($i = 1; $i <= 5; $i++)
                        <label class="cursor-pointer">
                            <input type="radio" name="rating" value="{{ $i }}" class="hidden peer"
                                required>
                            <i
                                class="fa-solid fa-star text-3xl text-gray-600 peer-checked:text-yellow-400 hover:text-yellow-400 transition"></i>
                        </label>
                    @endfor
                </div>

                <div class="mb-4">
                    <label class="text-xs text-gray-400 uppercase font-bold">Komentar Anda</label>
                    <textarea name="comment" rows="3"
                        class="w-full bg-[#111] border border-gray-600 rounded-lg p-3 text-white mt-2 focus:border-secondary focus:outline-none"
                        placeholder="Kuenya enak banget..."></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-secondary text-white py-3 rounded-lg font-bold hover:bg-secondary-dark transition">Kirim
                    Ulasan</button>
            </form>
        </div>
    </div>

    <script>
        function openReviewModal(productId, productName, orderId) {
            document.getElementById('reviewModal').classList.remove('hidden');
            document.getElementById('modalProductId').value = productId;
            document.getElementById('modalProductName').innerText = productName;

            // Set action URL dinamis
            let url = "{{ route('orders.review', ':id') }}";
            url = url.replace(':id', orderId);
            document.getElementById('reviewForm').action = url;
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }
    </script>
</x-layout>
