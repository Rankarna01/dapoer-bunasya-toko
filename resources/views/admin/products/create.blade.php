<x-admin-layout>
    <x-slot:title>Tambah Produk - Admin</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-secondary mb-4 inline-block">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-3xl font-bold text-accent">Tambah Kue Baru</h1>
        </div>

        <div class="bg-[#2a2a2a] p-8 rounded-xl border border-secondary/20 shadow-xl">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-400 mb-2">Nama Produk</label>
                        <input type="text" name="name" required class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-400 mb-2">Kategori</label>
                        <select name="category_id" class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:outline-none">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-400 mb-2">Harga (Rp)</label>
                        <input type="number" name="price" required class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-400 mb-2">Stok Awal</label>
                        <input type="number" name="stock" required class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-400 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-gray-400 mb-2">Foto Produk</label>
                    <input type="file" name="image" accept="image/*" required class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-secondary file:text-white hover:file:bg-secondary-dark cursor-pointer">
                </div>

                <button type="submit" class="w-full bg-secondary text-white font-bold py-3 rounded-lg hover:bg-secondary-dark transition shadow-lg mt-4">
                    Simpan Produk
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>