<x-layout>
    <x-slot:title>Katalog Kue - Dapoer Bunasya</x-slot>

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-accent">Katalog Menu</h1>
            <p class="text-gray-400 text-sm">Temukan kue favoritmu di sini.</p>
        </div>

        <form action="{{ route('catalog') }}" method="GET" class="relative w-full md:w-80">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kue..." class="w-full bg-[#2a2a2a] border border-gray-600 rounded-full py-2 px-5 text-white focus:outline-none focus:border-secondary">
            <button type="submit" class="absolute right-4 top-2.5 text-gray-400 hover:text-secondary">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div class="flex gap-3 overflow-x-auto pb-4 mb-6 no-scrollbar">
        <a href="{{ route('catalog') }}" class="px-4 py-2 rounded-full text-sm whitespace-nowrap border transition {{ !request('category') ? 'bg-secondary text-white border-secondary' : 'bg-[#2a2a2a] text-gray-400 border-gray-700 hover:border-secondary' }}">
            Semua
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('catalog', ['category' => $cat->slug]) }}" class="px-4 py-2 rounded-full text-sm whitespace-nowrap border transition {{ request('category') == $cat->slug ? 'bg-secondary text-white border-secondary' : 'bg-[#2a2a2a] text-gray-400 border-gray-700 hover:border-secondary' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    @if($products->isEmpty())
        <div class="text-center py-20">
            <i class="fa-solid fa-cookie-bite text-6xl text-gray-700 mb-4"></i>
            <p class="text-gray-400">Kue yang kamu cari tidak ditemukan.</p>
            <a href="{{ route('catalog') }}" class="text-secondary hover:underline mt-2 inline-block">Reset Filter</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif
</x-layout>