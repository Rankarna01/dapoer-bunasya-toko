<x-layout>
    <x-slot:title>{{ $product->name }} - Dapoer Bunasya</x-slot>

    <div class="mb-8 text-sm text-gray-400">
        <a href="/" class="hover:text-secondary"><i class="fa-solid fa-house"></i> Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('catalog') }}" class="hover:text-secondary">Katalog</a>
        <span class="mx-2">/</span>
        <span class="text-secondary">{{ $product->name }}</span>
    </div>

    <div class="bg-[#2a2a2a] rounded-2xl p-6 md:p-10 shadow-2xl border border-secondary/20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

            <div class="relative overflow-hidden rounded-xl border-2 border-secondary/10 group">
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                
                <div class="absolute top-4 left-4">
                    <span class="bg-secondary text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-lg">
                        {{ $product->category->name }}
                    </span>
                </div>
            </div>

            <div class="flex flex-col justify-center">
                <h1 class="text-3xl md:text-4xl font-bold text-accent mb-4">{{ $product->name }}</h1>

                <div class="text-2xl text-secondary font-bold mb-6 border-b border-gray-700 pb-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <p class="text-gray-300 leading-relaxed mb-8">
                    {{ $product->description }}
                    <br><br>
                    <span class="text-sm text-gray-500 italic"><i class="fa-solid fa-circle-info mr-1"></i> Stok
                        tersedia: {{ $product->stock }} pcs</span>
                </p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf

                    <div class="flex items-center gap-4 mb-6">
                        <label class="text-gray-400">Jumlah:</label>
                        <div class="flex items-center border border-gray-600 rounded-lg overflow-hidden">
                            <input type="number" name="quantity" value="1" min="1"
                                max="{{ $product->stock }}"
                                class="w-20 text-center bg-[#333] text-accent p-2 focus:outline-none rounded">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        @auth
                            <button type="submit"
                                class="flex-1 bg-secondary text-white py-3 rounded-lg font-semibold hover:bg-secondary-dark transition shadow-lg flex items-center justify-center gap-2">
                                <i class="fa-solid fa-cart-plus"></i> Masukkan Keranjang
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                                class="flex-1 bg-gray-600 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition text-center">
                                Login untuk Memesan
                            </a>
                        @endauth

                        <a href="https://wa.me/628123456789"
                            class="flex-1 border border-green-600 text-green-500 py-3 rounded-lg font-semibold hover:bg-green-600 hover:text-white transition flex items-center justify-center gap-2">
                            <i class="fa-brands fa-whatsapp text-xl"></i> Tanya via WA
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-layout>
