<x-admin-layout>
    <x-slot:title>Data Pelanggan</x-slot>
    <h1 class="text-2xl font-bold text-white mb-6">Data Pelanggan</h1>
    <div class="bg-[#2a2a2a] rounded-xl border border-secondary/20 overflow-hidden">
        <table class="w-full text-left text-gray-400">
            <thead class="bg-[#222] text-secondary uppercase text-sm">
                <tr>
                    <th class="p-4">Nama</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">No HP</th>
                    <th class="p-4">Alamat</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($customers as $c)
                <tr class="hover:bg-white/5">
                    <td class="p-4 text-white font-bold">{{ $c->name }}</td>
                    <td class="p-4">{{ $c->email }}</td>
                    <td class="p-4">{{ $c->phone }}</td>
                    <td class="p-4 text-sm truncate max-w-xs">{{ $c->address }}</td>
                    <td class="p-4 text-center">
                         <form action="{{ route('admin.customers.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus pelanggan ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-400"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>