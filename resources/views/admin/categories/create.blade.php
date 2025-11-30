<x-admin-layout>
    <x-slot:title>Tambah Kategori</x-slot>
    <div class="max-w-md">
        <h1 class="text-2xl font-bold text-white mb-6">Tambah Kategori</h1>
        <div class="bg-[#2a2a2a] p-6 rounded-xl border border-secondary/20">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <label class="block text-gray-400 mb-2">Nama Kategori</label>
                <input type="text" name="name" required class="w-full bg-[#333] text-white p-3 rounded mb-4 focus:outline-none focus:border-secondary border border-transparent">
                <button class="w-full bg-secondary text-white py-3 rounded font-bold">Simpan</button>
            </form>
        </div>
    </div>
</x-admin-layout>