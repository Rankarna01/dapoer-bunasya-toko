<x-layout>
    <x-slot:title>Keranjang Belanja - Dapoer Bunasya</x-slot>

    <h1 class="text-3xl font-bold text-accent mb-8">Keranjang Belanja Anda</h1>

    @if ($carts->isEmpty())
        <div class="text-center py-16 bg-[#2a2a2a] rounded-xl border border-dashed border-gray-600">
            <i class="fa-solid fa-basket-shopping text-6xl text-gray-600 mb-4"></i>
            <p class="text-gray-400 mb-6">Keranjang Anda masih kosong.</p>
            <a href="{{ route('catalog') }}"
                class="bg-secondary text-white px-6 py-2 rounded-lg hover:bg-secondary-dark transition">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                @foreach ($carts as $cart)
                    <div
                        class="flex items-center gap-4 bg-[#2a2a2a] p-4 rounded-xl shadow-md border border-secondary/10">
                        <img src="{{ Str::startsWith($cart->product->image, 'http') ? $cart->product->image : asset('storage/' . $cart->product->image) }}"
                            class="w-20 h-20 object-cover rounded-lg border border-gray-600">

                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-accent">{{ $cart->product->name }}</h3>
                            <p class="text-secondary text-sm">Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-gray-400 text-xs mb-1">Qty: {{ $cart->quantity }}</p>
                            <p class="text-white font-bold">Rp
                                {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</p>
                        </div>

                        <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400 ml-2 p-2"
                                onclick="return confirm('Hapus item ini?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="bg-[#2a2a2a] p-6 rounded-xl shadow-xl border border-secondary/20 h-fit">
                <h3 class="text-xl font-bold text-accent mb-6 border-b border-gray-700 pb-4">Ringkasan Pesanan</h3>

                <div class="flex justify-between mb-2 text-gray-400">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-6 text-gray-400">
                    <span>Pajak (0%)</span>
                    <span>Rp 0</span>
                </div>

                <div class="flex justify-between mb-8 text-xl font-bold text-white border-t border-gray-700 pt-4">
                    <span>Total</span>
                    <span class="text-secondary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <a href="{{ route('checkout') }}"
                    class="block w-full text-center bg-secondary text-white py-3 rounded-lg font-bold hover:bg-secondary-dark transition shadow-lg transform hover:-translate-y-1">
                    Lanjut ke Checkout <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    @endif
</x-layout>
