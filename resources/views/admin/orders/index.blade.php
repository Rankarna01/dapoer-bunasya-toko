<x-admin-layout>
    <x-slot:title>Kelola Pesanan - Admin</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-accent">Daftar Pesanan Masuk</h1>
    </div>

    <div class="bg-[#2a2a2a] rounded-xl border border-secondary/20 overflow-hidden shadow-xl">
        <table class="w-full text-left text-gray-400">
            <thead class="bg-[#222] text-secondary uppercase text-sm">
                <tr>
                    <th class="p-4">ID Order</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Status Bayar</th>
                    <th class="p-4">Status Pengiriman</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($orders as $order)
                <tr class="hover:bg-white/5 transition">
                    <td class="p-4 font-mono text-white">#{{ $order->id }}</td>
                    <td class="p-4">{{ $order->customer_name }}</td>
                    <td class="p-4 text-white font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    
                    <td class="p-4">
                        @if($order->payment_status == 'paid')
                            <span class="bg-green-900 text-green-300 px-2 py-1 rounded text-xs">LUNAS</span>
                        @else
                            <span class="bg-yellow-900 text-yellow-300 px-2 py-1 rounded text-xs uppercase">{{ $order->payment_status }}</span>
                        @endif
                    </td>

                    <td class="p-4">
                        @php
                            $colors = [
                                'pending' => 'bg-gray-700 text-gray-300',
                                'processed' => 'bg-blue-900 text-blue-300',
                                'on_delivery' => 'bg-orange-900 text-orange-300',
                                'delivered' => 'bg-green-900 text-green-300',
                                'completed' => 'bg-secondary text-white',
                            ];
                            $colorClass = $colors[$order->status] ?? 'bg-gray-700 text-gray-300';
                        @endphp
                        <span class="{{ $colorClass }} px-2 py-1 rounded text-xs uppercase font-bold tracking-wide">
                            {{ str_replace('_', ' ', $order->status) }}
                        </span>
                    </td>

                    <td class="p-4 text-sm">{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td class="p-4 text-center">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-secondary text-white px-3 py-1 rounded hover:bg-secondary-dark transition text-sm">
                            <i class="fa-solid fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>
</x-admin-layout>