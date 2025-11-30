<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir - Dapoer Bunasya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1a1a1a',
                        secondary: '#8D6E63',
                        accent: '#F5F5DC',
                    },
                    fontFamily: { sans: ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-[#121212] text-accent font-sans antialiased min-h-screen flex flex-col">

    <!-- NAVBAR SIMPLE -->
    <nav class="bg-[#1a1a1a] border-b border-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center text-white font-bold text-lg">
                    <i class="fa-solid fa-cash-register"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg leading-tight">Dashboard Kasir</h1>
                    <p class="text-gray-400 text-xs">Halo, {{ Auth::user()->name }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-red-400 hover:text-red-500 text-sm font-bold flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="flex-grow container mx-auto p-4 md:p-8 flex flex-col justify-center">
        
        <!-- MENU UTAMA -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto w-full">
            
            <!-- TOMBOL MASUK POS (BESAR) -->
            <a href="{{ route('kasir.pos') }}" class="group bg-gradient-to-br from-secondary to-[#6D4C41] p-8 rounded-3xl shadow-2xl hover:shadow-[0_0_40px_rgba(141,110,99,0.4)] hover:scale-105 transition-all duration-300 relative overflow-hidden h-64 flex flex-col justify-center items-center text-center border border-white/10">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-4 backdrop-blur-sm group-hover:scale-110 transition duration-500">
                    <i class="fa-solid fa-store text-4xl text-white"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Buka Mesin Kasir</h2>
                <p class="text-white/80 text-sm">Mulai transaksi penjualan baru (POS)</p>
            </a>

            <!-- INFO STATISTIK HARI INI -->
            <div class="flex flex-col gap-6">
                <!-- Card Omzet -->
                <div class="bg-[#1e1e1e] p-6 rounded-3xl border border-gray-800 flex items-center justify-between h-full group hover:border-green-500/50 transition">
                    <div>
                        <p class="text-gray-400 text-sm uppercase tracking-widest mb-1">Pendapatan Hari Ini</p>
                        <h3 class="text-3xl font-bold text-white group-hover:text-green-400 transition">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-500">
                        <i class="fa-solid fa-coins text-xl"></i>
                    </div>
                </div>

                <!-- Card Jumlah Transaksi -->
                <div class="bg-[#1e1e1e] p-6 rounded-3xl border border-gray-800 flex items-center justify-between h-full group hover:border-blue-500/50 transition">
                    <div>
                        <p class="text-gray-400 text-sm uppercase tracking-widest mb-1">Transaksi Hari Ini</p>
                        <h3 class="text-3xl font-bold text-white group-hover:text-blue-400 transition">{{ $todayTransactionCount }} <span class="text-base text-gray-500 font-normal">Pesanan</span></h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                        <i class="fa-solid fa-receipt text-xl"></i>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <footer class="text-center py-6 text-gray-600 text-sm">
        &copy; {{ date('Y') }} Dapoer Bunasya POS System.
    </footer>

</body>
</html>