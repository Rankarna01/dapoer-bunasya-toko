<x-admin-layout>
    <x-slot:title>Kategori - Admin</x-slot>

    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold text-white">Kategori Kue</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-secondary px-4 py-2 rounded text-white">Tambah Kategori</a>
    </div>

    <div class="bg-[#2a2a2a] rounded-xl border border-secondary/20 overflow-hidden">
        <table class="w-full text-left text-gray-400">
            <thead class="bg-[#222] text-secondary uppercase text-sm">
                <tr>
                    <th class="p-4">Nama Kategori</th>
                    <th class="p-4">Slug</th>
                    <th class="p-4">Jumlah Produk</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($categories as $cat)
                <tr class="hover:bg-white/5">
                    <td class="p-4 text-white font-bold">{{ $cat->name }}</td>
                    <td class="p-4 text-sm">{{ $cat->slug }}</td>
                    <td class="p-4">{{ $cat->products_count }} Item</td>
                    <td class="p-4 flex justify-center gap-2">
                        <a href="{{ route('admin.categories.edit', $cat->id) }}" class="bg-blue-600 text-white p-2 rounded"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Produk didalamnya akan kehilangan kategori.')">
                            @csrf @method('DELETE')
                            <button class="bg-red-600 text-white p-2 rounded"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>