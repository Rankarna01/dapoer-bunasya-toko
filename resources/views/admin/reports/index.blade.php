<x-admin-layout>
    <x-slot:title>Laporan Keuangan - Admin</x-slot>

    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4 no-print">
        <div>
            <h1 class="text-2xl font-bold text-white">Laporan Keuangan</h1>
            <p class="text-gray-400 text-sm">Rekap pendapatan toko.</p>
        </div>
        
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap gap-2 items-end">
            <div>
                <label class="text-xs text-gray-500 block mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="bg-[#222] text-white px-3 py-2 rounded border border-gray-700 text-sm">
            </div>
            <div>
                <label class="text-xs text-gray-500 block mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="bg-[#222] text-white px-3 py-2 rounded border border-gray-700 text-sm">
            </div>
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded font-bold hover:bg-secondary-dark h-[38px]">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
        </form>
    </div>

    <div class="bg-gradient-to-r from-green-900 to-[#2a2a2a] p-6 rounded-xl border border-green-700 mb-8 shadow-lg">
        <p class="text-green-300 text-sm font-bold uppercase tracking-widest mb-1">Total Pendapatan (Periode Ini)</p>
        <h2 class="text-4xl font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        <p class="text-gray-400 text-xs mt-2">{{ count($orders) }} Transaksi Berhasil</p>
    </div>

    <div class="flex gap-4 mb-6 no-print">
        <a href="{{ request()->fullUrlWithQuery(['export_excel' => 'true']) }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center gap-2">
            <i class="fa-solid fa-file-excel"></i> Export Excel
        </a>
        <button onclick="window.print()" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak PDF
        </button>
    </div>

    <div class="bg-[#2a2a2a] rounded-xl border border-secondary/20 overflow-hidden print-area">
        <div class="hidden print-header p-4 text-center border-b border-gray-700">
            <h2 class="text-xl font-bold text-black">Laporan Penjualan Dapoer Bunasya</h2>
            <p class="text-sm">Periode: {{ $startDate }} s/d {{ $endDate }}</p>
        </div>

        <table class="w-full text-left text-gray-400">
            <thead class="bg-[#222] text-secondary uppercase text-sm">
                <tr>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">ID Order</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($orders as $order)
                <tr class="hover:bg-white/5">
                    <td class="p-4 text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4 text-white font-mono">#{{ $order->id }}</td>
                    <td class="p-4">{{ $order->customer_name }}</td>
                    <td class="p-4 text-xs uppercase">{{ $order->status }}</td>
                    <td class="p-4 text-right text-white font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500">Tidak ada data penjualan pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-[#1a1a1a] border-t border-secondary/50">
                <tr>
                    <td colspan="4" class="p-4 text-right text-white font-bold uppercase">Total Pendapatan</td>
                    <td class="p-4 text-right text-secondary font-bold text-lg">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-area, .print-area * {
                visibility: visible;
                color: black !important; /* Paksa hitam utk kertas */
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white !important;
                border: none !important;
            }
            .print-header {
                display: block !important;
                margin-bottom: 20px;
            }
            .no-print {
                display: none !important;
            }
            /* Hilangkan warna gelap background saat print */
            .bg-\[\#2a2a2a\], .bg-\[\#222\], .bg-\[\#1a1a1a\] {
                background-color: white !important;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                border: 1px solid #ddd;
            }
        }
    </style>
</x-admin-layout>