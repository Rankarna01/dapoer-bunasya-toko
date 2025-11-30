<x-admin-layout>
    <x-slot:title>Kelola Produk - Admin</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-accent">Daftar Produk Kue</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary-dark transition shadow-lg">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded-lg mb-4 shadow-lg animate-fade-in-up">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#2a2a2a] rounded-xl border border-secondary/20 overflow-hidden shadow-xl">
        <table class="w-full text-left text-gray-400">
            <thead class="bg-[#222] text-secondary uppercase text-sm">
                <tr>
                    <th class="p-4">Foto</th>
                    <th class="p-4">Nama Produk</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4">Stok</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($products as $product)
                <tr class="hover:bg-white/5 transition">
                    <td class="p-4">
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                             class="w-16 h-16 object-cover rounded-lg border border-gray-600">
                    </td>
                    <td class="p-4 font-bold text-white">{{ $product->name }}</td>
                    <td class="p-4 text-sm">{{ $product->category->name }}</td>
                    <td class="p-4 text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="{{ $product->stock < 5 ? 'text-red-500 font-bold' : 'text-green-500' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="p-4 flex justify-center gap-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white p-2 rounded hover:bg-red-700 transition">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="p-4">
            {{ $products->links() }}
        </div>
    </div>
</x-admin-layout>