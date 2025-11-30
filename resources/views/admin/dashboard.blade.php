<x-admin-layout>
    <x-slot:title>Dashboard - Dapoer Bunasya Admin</x-slot>

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-white">Ringkasan Bisnis</h2>
            <p class="text-gray-400 text-sm mt-1">Pantau performa toko Anda hari ini.</p>
        </div>
        <div class="hidden md:block">
            <span class="bg-[#2a2a2a] border border-gray-700 text-gray-300 px-4 py-2 rounded-full text-sm">
                <i class="fa-regular fa-calendar mr-2"></i> {{ date('d F Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="relative overflow-hidden bg-[#1e1e1e] p-6 rounded-2xl border border-gray-800 hover:border-secondary transition duration-300 hover:-translate-y-1 hover:shadow-[0_10px_40px_-15px_rgba(141,110,99,0.3)] group">
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-secondary text-xs mt-2 font-medium"><i class="fa-solid fa-arrow-trend-up mr-1"></i> Lifetime</p>
                </div>
                <div class="bg-secondary/10 p-3 rounded-xl text-secondary border border-secondary/20">
                    <i class="fa-solid fa-coins text-xl"></i>
                </div>
            </div>
            <i class="fa-solid fa-coins absolute -bottom-6 -right-6 text-9xl text-secondary/5 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500"></i>
        </div>

        <div class="relative overflow-hidden bg-[#1e1e1e] p-6 rounded-2xl border border-gray-800 hover:border-orange-500 transition duration-300 hover:-translate-y-1 hover:shadow-[0_10px_40px_-15px_rgba(249,115,22,0.3)] group">
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Perlu Diproses</p>
                    <h3 class="text-3xl font-bold text-white">{{ $pendingOrders }}</h3>
                    <p class="text-orange-400 text-xs mt-2 font-medium"><i class="fa-solid fa-circle-exclamation mr-1"></i> Pesanan Aktif</p>
                </div>
                <div class="bg-orange-500/10 p-3 rounded-xl text-orange-500 border border-orange-500/20">
                    <i class="fa-solid fa-bell text-xl"></i>
                </div>
            </div>
            <i class="fa-solid fa-stopwatch absolute -bottom-6 -right-6 text-9xl text-orange-500/5 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-500"></i>
        </div>

        <div class="relative overflow-hidden bg-[#1e1e1e] p-6 rounded-2xl border border-gray-800 hover:border-blue-500 transition duration-300 hover:-translate-y-1 hover:shadow-[0_10px_40px_-15px_rgba(59,130,246,0.3)] group">
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Transaksi</p>
                    <h3 class="text-3xl font-bold text-white">{{ $totalOrders }}</h3>
                    <p class="text-blue-400 text-xs mt-2 font-medium"><i class="fa-solid fa-receipt mr-1"></i> Sukses & Gagal</p>
                </div>
                <div class="bg-blue-500/10 p-3 rounded-xl text-blue-500 border border-blue-500/20">
                    <i class="fa-solid fa-clipboard-list text-xl"></i>
                </div>
            </div>
            <i class="fa-solid fa-chart-simple absolute -bottom-6 -right-6 text-9xl text-blue-500/5 group-hover:scale-110 transition-transform duration-500"></i>
        </div>

        <div class="relative overflow-hidden bg-[#1e1e1e] p-6 rounded-2xl border border-gray-800 hover:border-purple-500 transition duration-300 hover:-translate-y-1 hover:shadow-[0_10px_40px_-15px_rgba(168,85,247,0.3)] group">
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Kue</p>
                    <h3 class="text-3xl font-bold text-white">{{ $totalProducts }}</h3>
                    <p class="text-purple-400 text-xs mt-2 font-medium"><i class="fa-solid fa-tag mr-1"></i> Varian Tersedia</p>
                </div>
                <div class="bg-purple-500/10 p-3 rounded-xl text-purple-500 border border-purple-500/20">
                    <i class="fa-solid fa-box-open text-xl"></i>
                </div>
            </div>
            <i class="fa-solid fa-layer-group absolute -bottom-6 -right-6 text-9xl text-purple-500/5 group-hover:scale-110 transition-transform duration-500"></i>
        </div>
    </div>

    <div class="bg-[#1e1e1e] rounded-xl border border-gray-800 p-6 shadow-xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-secondary to-transparent"></div>

        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-white">Transaksi Terbaru</h3>
                <p class="text-xs text-gray-500">5 Pesanan terakhir yang masuk ke sistem.</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="group text-sm text-secondary hover:text-white transition flex items-center gap-2">
                Lihat Semua <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-gray-400 text-sm">
                <thead class="bg-[#111] text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 rounded-l-lg">ID Order</th>
                        <th class="p-4">Pelanggan</th>
                        <th class="p-4">Total</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-white/5 transition duration-200 group">
                        <td class="p-4 font-mono text-secondary group-hover:text-white transition">#{{ $order->id }}</td>
                        <td class="p-4 font-medium text-white">{{ $order->customer_name }}</td>
                        <td class="p-4 font-bold text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-gray-700 text-gray-300',
                                    'paid' => 'bg-green-900/50 text-green-400 border border-green-800',
                                    'processed' => 'bg-blue-900/50 text-blue-400 border border-blue-800',
                                    'on_delivery' => 'bg-orange-900/50 text-orange-400 border border-orange-800',
                                    'delivered' => 'bg-teal-900/50 text-teal-400 border border-teal-800',
                                    'completed' => 'bg-secondary/20 text-secondary border border-secondary/30',
                                    'cancelled' => 'bg-red-900/50 text-red-400 border border-red-800',
                                ];
                                $colorClass = $statusColors[$order->status] ?? 'bg-gray-700 text-gray-300';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] uppercase font-bold tracking-wide {{ $colorClass }}">
                                {{ str_replace('_', ' ', $order->status) }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-[#333] hover:bg-secondary hover:text-white text-gray-400 w-8 h-8 rounded flex items-center justify-center transition ml-auto">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-4xl mb-3 opacity-50"></i>
                            <p>Belum ada transaksi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>