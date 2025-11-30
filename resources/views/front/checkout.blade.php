<x-layout>
    <x-slot:title>Checkout - Dapoer Bunasya</x-slot>

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-accent mb-8">Pengiriman</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <form action="{{ route('checkout.process') }}" method="POST" class="bg-[#2a2a2a] p-6 rounded-xl border border-secondary/20 shadow-xl">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-400 mb-2">Nama Penerima</label>
                        <input type="text" name="customer_name" value="{{ Auth::user()->name }}" class="w-full bg-[#333] border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-secondary focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-gray-400 mb-2">Nomor WhatsApp</label>
                        <input type="text" name="customer_phone" value="{{ Auth::user()->phone }}" class="w-full bg-[#333] border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-secondary focus:border-secondary">
                    </div>
                    <div>
                        <label class="block text-gray-400 mb-2">Alamat Lengkap</label>
                        <textarea name="shipping_address" rows="4" class="w-full bg-[#333] border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-secondary focus:border-secondary" placeholder="Jalan, No Rumah, Kelurahan, Kecamatan...">{{ Auth::user()->address }}</textarea>
                    </div>
                </div>

                <button type="submit" class="w-full bg-secondary text-white font-bold py-3 mt-6 rounded-lg hover:bg-secondary-dark transition shadow-lg">
                    Lanjut ke Pembayaran
                </button>
            </form>

            <div class="bg-[#222] p-6 rounded-xl border border-gray-700 h-fit">
                <h3 class="text-lg font-bold text-accent mb-4">Ringkasan Item</h3>
                <ul class="space-y-3 mb-4">
                    @foreach($carts as $item)
                        <li class="flex justify-between text-sm text-gray-400">
                            <span>{{ $item->quantity }}x {{ $item->product->name }}</span>
                            <span>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="border-t border-gray-700 pt-4 flex justify-between text-xl font-bold text-white">
                    <span>Total Bayar</span>
                    <span class="text-secondary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</x-layout>