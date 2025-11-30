@props(['product'])

<div class="bg-[#2a2a2a] rounded-xl overflow-hidden shadow-lg border border-secondary/20 hover:border-secondary transition duration-300 group">
    <div class="relative h-48 overflow-hidden">
        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
             alt="{{ $product->name }}" 
             class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
             
        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
    </div>

    <div class="p-5">
        <p class="text-xs text-secondary uppercase tracking-widest mb-1">{{ $product->category->name }}</p>
        <h3 class="text-xl font-bold text-accent mb-2 group-hover:text-secondary transition">{{ $product->name }}</h3>
        
        <div class="flex justify-between items-center mt-4">
            <span class="text-white font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            
            <a href="{{ route('product.detail', $product->slug) }}" class="bg-secondary text-white px-4 py-2 rounded-lg text-sm hover:bg-secondary-dark transition shadow-md">
                Lihat Detail
            </a>
        </div>
    </div>
</div>