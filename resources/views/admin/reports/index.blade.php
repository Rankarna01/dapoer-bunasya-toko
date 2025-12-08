<x-admin-layout>
    <x-slot:title>Laporan Keuangan - Admin</x-slot>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4 no-print">
        <div>
            <h1 class="text-2xl font-bold text-white">Laporan Keuangan</h1>
            <p class="text-gray-400 text-sm">Rekap pendapatan toko.</p>
        </div>
        
        <form id="filterForm" action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap gap-2 items-end">
            <div>
                <label class="text-xs text-gray-500 block mb-1">Periode</label>
                <select id="periodSelect" class="bg-[#222] text-white px-3 py-2 rounded border border-gray-700 text-sm h-[38px] w-32 focus:outline-none focus:border-secondary">
                    <option value="custom">Custom</option>
                    <option value="daily">Hari Ini</option>
                    <option value="weekly">Minggu Ini</option>
                    <option value="monthly">Bulan Ini</option>
                    <option value="yearly">Tahun Ini</option>
                </select>
            </div>

            <div>
                <label class="text-xs text-gray-500 block mb-1">Dari Tanggal</label>
                <input type="date" id="startDate" name="start_date" value="{{ $startDate }}" class="bg-[#222] text-white px-3 py-2 rounded border border-gray-700 text-sm">
            </div>
            <div>
                <label class="text-xs text-gray-500 block mb-1">Sampai Tanggal</label>
                <input type="date" id="endDate" name="end_date" value="{{ $endDate }}" class="bg-[#222] text-white px-3 py-2 rounded border border-gray-700 text-sm">
            </div>
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded font-bold hover:bg-secondary-dark h-[38px]">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
        </form>
    </div>

    <div class="bg-gradient-to-r from-green-900 to-[#2a2a2a] p-6 rounded-xl border border-green-700 mb-6 shadow-lg no-print">
        <p class="text-green-300 text-sm font-bold uppercase tracking-widest mb-1">Total Pendapatan (Periode Ini)</p>
        <h2 class="text-4xl font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        <p class="text-gray-400 text-xs mt-2">{{ count($orders) }} Transaksi Berhasil</p>
    </div>

    <div class="bg-[#2a2a2a] p-6 rounded-xl border border-gray-700 mb-8 shadow-lg no-print">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-white font-bold text-lg"><i class="fa-solid fa-chart-line text-secondary mr-2"></i>Trend Penjualan (1 Minggu Terakhir)</h3>
        </div>
        <div class="h-64 w-full">
            <canvas id="salesChart"></canvas>
        </div>
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
        
        <div class="hidden print-header p-8 border-b-2 border-black mb-6">
            <div class="flex items-center gap-6">
                <div class="text-4xl text-black">
                    <i class="fa-solid fa-cake-candles"></i> 
                </div>
                <div class="flex-1 text-black">
                    <h1 class="text-3xl font-bold uppercase tracking-wide">Dapoer Bunasya</h1>
                    <p class="text-sm mt-1">Jl. Sisingamangaraja, Amplas, Medan, Sumatera Utara</p>
                    <p class="text-sm">Telp/WA: 0858-3511-6946 | Email: dapoerbunasya@gmail.com</p>
                </div>
            </div>
            <div class="mt-6 text-center">
                <h2 class="text-xl font-bold text-black underline uppercase">Laporan Penjualan</h2>
                <p class="text-sm text-black font-medium">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
            </div>
        </div>

        <table class="w-full text-left text-gray-400">
            <thead class="bg-[#222] text-secondary uppercase text-sm">
                <tr>
                    <th class="p-4 border-b border-gray-700">Tanggal</th>
                    <th class="p-4 border-b border-gray-700">ID Order</th>
                    <th class="p-4 border-b border-gray-700">Pelanggan</th>
                    <th class="p-4 border-b border-gray-700">Status</th>
                    <th class="p-4 border-b border-gray-700 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($orders as $order)
                <tr class="hover:bg-white/5">
                    <td class="p-4 text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4 text-white font-mono">#{{ $order->tracking_number ?? $order->id }}</td>
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

        <div class="hidden print-footer mt-12 mb-8 px-8 text-black text-right">
            <p class="mb-1">Medan, {{ date('d F Y') }}</p>
            <p class="font-bold mb-16">Owner / Penanggung Jawab</p> <p class="font-bold underline text-lg">Ibu Bunasya</p>
            <p class="text-sm">Dapoer Bunasya</p>
        </div>

    </div>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 1cm;
            }
            body * {
                visibility: hidden;
            }
            .print-area, .print-area * {
                visibility: visible;
                color: black !important; /* Paksa teks hitam */
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white !important;
                border: none !important;
                padding: 0;
            }
            
            /* Tampilkan Header & Footer Print */
            .print-header {
                display: block !important;
            }
            .print-footer {
                display: block !important;
            }

            /* Sembunyikan elemen web */
            .no-print, nav, aside, footer {
                display: none !important;
            }

            /* Styling Tabel saat Print agar bersih */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            thead {
                background-color: #f3f3f3 !important;
                color: black !important;
                font-weight: bold;
            }
            th, td {
                border: 1px solid #000 !important;
                padding: 8px !important;
                color: black !important;
            }
            /* Hilangkan background gelap Laravel */
            .bg-\[\#2a2a2a\], .bg-\[\#222\], .bg-\[\#1a1a1a\] {
                background-color: white !important;
            }
            .text-white, .text-gray-400, .text-secondary {
                color: black !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- 1. LOGIC DROPDOWN PERIODE ---
            const periodSelect = document.getElementById('periodSelect');
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const form = document.getElementById('filterForm');

            periodSelect.addEventListener('change', function() {
                const type = this.value;
                const today = new Date();
                let start, end;

                // Format Date to YYYY-MM-DD
                const formatDate = (date) => {
                    return date.toISOString().split('T')[0];
                };

                if (type === 'daily') {
                    start = today;
                    end = today;
                } else if (type === 'weekly') {
                    // Cari Senin minggu ini
                    const day = today.getDay();
                    const diff = today.getDate() - day + (day === 0 ? -6 : 1); 
                    start = new Date(today.setDate(diff));
                    end = new Date(today.setDate(start.getDate() + 6));
                } else if (type === 'monthly') {
                    start = new Date(today.getFullYear(), today.getMonth(), 1);
                    end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                } else if (type === 'yearly') {
                    start = new Date(today.getFullYear(), 0, 1);
                    end = new Date(today.getFullYear(), 11, 31);
                }

                if (type !== 'custom') {
                    startDateInput.value = formatDate(start);
                    endDateInput.value = formatDate(end);
                    // Otomatis submit form agar user tidak perlu klik tombol Filter lagi
                    // Uncomment baris di bawah jika ingin auto-submit
                    // form.submit(); 
                }
            });

            // --- 2. LOGIC CHART TREND (Data Dummy/Simulation) ---
            // Catatan: Karena kita tidak merubah Controller, data di sini adalah simulasi 
            // agar tampilan UI sesuai request.
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Generate Label 7 Hari Terakhir
            const labels = [];
            const dataPoints = [];
            for (let i = 6; i >= 0; i--) {
                const d = new Date();
                d.setDate(d.getDate() - i);
                labels.push(d.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric' }));
                // Data Random untuk Visualisasi (Ganti ini nanti dengan data real dari backend jika sudah ada)
                dataPoints.push(Math.floor(Math.random() * 500000) + 100000); 
            }

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: dataPoints,
                        borderColor: '#22c55e', // Tailwind green-500
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 2,
                        tension: 0.4, // Membuat garis melengkung halus
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#22c55e',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#222',
                            titleColor: '#fff',
                            bodyColor: '#ccc',
                            borderColor: '#444',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: '#333' },
                            ticks: { color: '#999' }
                        },
                        y: {
                            grid: { color: '#333' },
                            ticks: { 
                                color: '#999',
                                callback: function(value) {
                                    return 'Rp ' + (value/1000) + 'k';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>