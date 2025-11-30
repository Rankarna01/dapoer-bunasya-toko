<x-admin-layout>
    <x-slot:title>Edit Kategori - Admin</x-slot>

    <div class="max-w-md mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-secondary mb-4 inline-block">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-2xl font-bold text-white">Edit Kategori</h1>
        </div>

        <div class="bg-[#2a2a2a] p-8 rounded-xl border border-secondary/20 shadow-xl">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-gray-400 mb-2 text-sm font-medium">Nama Kategori</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $category->name) }}" 
                           required 
                           class="w-full bg-[#333] border border-gray-600 rounded-lg p-3 text-white focus:border-secondary focus:ring-1 focus:ring-secondary focus:outline-none transition">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('admin.categories.index') }}" class="w-1/3 bg-gray-700 text-gray-300 py-3 rounded-lg font-bold text-center hover:bg-gray-600 transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-secondary text-white py-3 rounded-lg font-bold hover:bg-secondary-dark transition shadow-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>