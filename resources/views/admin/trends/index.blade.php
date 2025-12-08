<x-admin-layout>
    <x-slot:title>Trend & Analitik - Admin</x-slot>

    <!-- LOAD CHART.JS DARI CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- HEADER (No Print) -->
    <div class="flex justify-between items-end mb-8 no-print">
        <div>
            <h1 class="text-2xl font-bold text-white">Trend Produk & Keuangan</h1>
            <p class="text-gray-400 text-sm">Analisa performa toko dalam 7 hari terakhir.</p>
        </div>
        <button onclick="window.print()" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary-dark transition flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak Analisa
        </button>
    </div>

    <!-- AREA CETAK -->
    <div class="print-area">
        
        <!-- KOP SURAT (Hanya Muncul saat Print) -->
        <div class="hidden print-header p-8 border-b-2 border-black mb-8">
            <div class="flex items-center gap-6">
                <div class="text-4xl text-black">
                    <i class="fa-solid fa-cake-candles"></i> 
                </div>
                <div class="flex-1 text-black">
                    <h1 class="text-3xl font-bold uppercase tracking-wide">Dapoer Bunasya</h1>
                    <p class="text-sm mt-1">Jl. Sisingamangaraja, Amplas, Medan</p>
                    <p class="text-sm">Laporan Analisa Trend & Performa Toko</p>
                </div>
            </div>
            <div class="mt-4 text-right text-black text-xs">
                Dicetak pada: {{ date('d F Y, H:i') }}
            </div>
        </div>

        <!-- GRID CHART -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- CHART 1: PRODUK TERLARIS (Doughnut Chart) -->
            <div class="bg-[#2a2a2a] p-6 rounded-xl border border-secondary/20 shadow-lg chart-container">
                <h3 class="text-lg font-bold text-white mb-4 chart-title"><i class="fa-solid fa-crown text-yellow-500 mr-2"></i> 5 Menu Paling Disukai</h3>
                <div class="relative h-64 w-full flex justify-center">
                    <canvas id="topProductsChart"></canvas>
                </div>
                <p class="text-xs text-gray-400 mt-4 text-center chart-desc">* Berdasarkan total item terjual (Lifetime)</p>
            </div>

            <!-- CHART 2: PENDAPATAN MINGGUAN (Line Chart) -->
            <div class="bg-[#2a2a2a] p-6 rounded-xl border border-secondary/20 shadow-lg chart-container">
                <h3 class="text-lg font-bold text-white mb-4 chart-title"><i class="fa-solid fa-arrow-trend-up text-green-500 mr-2"></i> Trend Pendapatan (7 Hari)</h3>
                <div class="relative h-64 w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
                <p class="text-xs text-gray-400 mt-4 text-center chart-desc">* Total omzet kotor per hari</p>
            </div>

        </div>

        <!-- REKOMENDASI SISTEM (Tambahan teks statis biar keren) -->
        <div class="mt-8 bg-[#2a2a2a] p-6 rounded-xl border border-gray-700 chart-container">
            <h3 class="text-lg font-bold text-white mb-2 chart-title">💡 Insight Singkat</h3>
            <ul class="list-disc list-inside text-gray-300 text-sm space-y-1 chart-desc">
                <li>Produk terlaris sebaiknya stoknya ditambah 20% untuk menghindari kehabisan.</li>
                <li>Jika grafik pendapatan menurun, pertimbangkan membuat promo diskon di hari sepi.</li>
                <li>Data ini diupdate secara realtime dari transaksi Online & Kasir.</li>
            </ul>
        </div>

        <!-- FOOTER TANDA TANGAN (Hanya Muncul saat Print) -->
        <div class="hidden print-footer mt-12 px-8 text-black text-right">
            <p class="mb-16">Mengetahui, Owner</p>
            <p class="font-bold underline">Ibu Bunasya</p>
        </div>
    </div>

    <!-- SCRIPT CHART.JS -->
    <script>
        // --- KONFIGURASI WARNA ---
        const colorPrimary = '#8D6E63'; // Coklat
        const colorSecondary = '#F5F5DC'; // Cream
        const colorBgDark = '#2a2a2a';
        
        // --- DATA DARI CONTROLLER ---
        const productLabels = @json($productLabels);
        const productData = @json($productData);
        const revenueLabels = @json($revenueLabels);
        const revenueValues = @json($revenueValues);

        // 1. CHART PRODUK (DOUGHNUT)
        const ctx1 = document.getElementById('topProductsChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: productLabels,
                datasets: [{
                    data: productData,
                    backgroundColor: [
                        '#8D6E63', // Coklat
                        '#A1887F', 
                        '#BCAAA4',
                        '#D7CCC8',
                        '#EFEBE9'  // Paling muda
                    ],
                    borderColor: '#1a1a1a',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#F5F5DC' } // Warna text legend cream
                    }
                }
            }
        });

        // 2. CHART PENDAPATAN (LINE)
        const ctx2 = document.getElementById('revenueChart').getContext('2d');
        // Bikin Gradient Warna
        let gradient = ctx2.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(141, 110, 99, 0.5)'); // Atas (transparan)
        gradient.addColorStop(1, 'rgba(141, 110, 99, 0)');   // Bawah (hilang)

        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: revenueValues,
                    borderColor: '#8D6E63',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#F5F5DC',
                    pointBorderColor: '#8D6E63',
                    pointRadius: 5,
                    fill: true,
                    tension: 0.4 // Garis lengkung halus
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#333' }, // Grid gelap
                        ticks: { color: '#999' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#999' }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>

    <!-- STYLE CETAK KHUSUS GRAFIK -->
    <style>
        @media print {
            @page { size: A4 landscape; margin: 1cm; } /* Landscape biar grafik lebar */
            
            body * { visibility: hidden; }
            .print-area, .print-area * { visibility: visible; color: black !important; }
            .print-area { position: absolute; left: 0; top: 0; width: 100%; background: white !important; padding: 20px; }
            
            .no-print, nav, aside { display: none !important; }
            .print-header, .print-footer { display: block !important; }

            /* Ubah background grafik jadi putih saat print */
            .bg-\[\#2a2a2a\], .chart-container {
                background-color: white !important;
                border: 1px solid #ddd !important;
                box-shadow: none !important;
                color: black !important;
            }
            
            /* Paksa teks jadi hitam */
            .text-white, .chart-title { color: black !important; }
            .text-gray-400, .text-gray-300, .chart-desc { color: #555 !important; }
            
            /* Penyesuaian Grid saat print */
            .grid { display: flex; flex-wrap: wrap; gap: 20px; }
            .lg\:grid-cols-2 > div { width: 48%; }
        }
    </style>
</x-admin-layout>