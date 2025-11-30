<x-admin-layout>
    <x-slot:title>Edit Produk - Admin</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-secondary mb-4 inline-block">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-3xl font-bold text-accent">Edit Produk</h1>
        </div>

        <div class="bg-[#2a2a2a] p-8 rounded-xl border border-secondary/20 shadow-xl">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-400 mb-2">Nama Produk</label>
                        <input type="text" name="name" value="{{ $product->name }}" required class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-400 mb-2">Kategori</label>
                        <select name="category_id" class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:outline-none">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-400 mb-2">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ $product->price }}" required class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-400 mb-2">Stok</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" required class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-400 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:outline-none">{{ $product->description }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-400 mb-2">Ganti Foto (Opsional)</label>
                    <div class="flex items-center gap-4 mb-2">
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="w-16 h-16 rounded object-cover border border-gray-600">
                        <span class="text-xs text-gray-500">Foto Saat Ini</span>
                    </div>
                    <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-secondary file:text-white hover:file:bg-secondary-dark cursor-pointer">
                </div>

                <button type="submit" class="w-full bg-secondary text-white font-bold py-3 rounded-lg hover:bg-secondary-dark transition shadow-lg mt-4">
                    Update Produk
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>