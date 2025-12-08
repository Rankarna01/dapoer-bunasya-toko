<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>

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
                        'secondary-dark': '#6D4C41',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom Scrollbar untuk Admin */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #111;
        }

        ::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #8D6E63;
        }
    </style>
</head>

<body class="bg-[#121212] text-accent font-sans antialiased flex h-screen overflow-hidden">

    <!-- OVERLAY MOBILE (Hitam Transparan saat sidebar buka) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity duration-300"></div>

    <!-- SIDEBAR -->
    <!-- Perubahan: Class fixed, transform, transition untuk animasi mobile -->
    <aside id="sidebar" 
        class="fixed inset-y-0 left-0 z-50 w-64 bg-black border-r border-secondary/20 flex flex-col transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:flex shadow-2xl">
        
        <div class="h-16 flex items-center justify-center border-b border-gray-800 relative">
            <h1 class="text-xl font-bold tracking-widest text-secondary">
                <i class="fa-solid fa-crown mr-2"></i> ADMIN
            </h1>
            <!-- Tombol Close di Sidebar (Hanya Mobile) -->
            <button id="closeSidebar" class="absolute right-4 text-gray-400 md:hidden">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 space-y-2 px-4">

            <p class="text-xs font-bold text-gray-500 uppercase px-2 mb-2 tracking-wider">Utama</p>

            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'bg-secondary text-white shadow-lg shadow-secondary/20' : 'text-gray-400 hover:bg-[#222] hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition duration-200">
                <i class="fa-solid fa-chart-line w-6"></i> Dashboard
            </a>

            <p class="text-xs font-bold text-gray-500 uppercase px-2 mt-6 mb-2 tracking-wider">Transaksi</p>

            <a href="{{ route('admin.orders.index') }}"
                class="{{ request()->routeIs('admin.orders*') ? 'bg-secondary text-white shadow-lg shadow-secondary/20' : 'text-gray-400 hover:bg-[#222] hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition duration-200">
                <i class="fa-solid fa-cart-shopping w-6"></i> Pesanan Masuk
            </a>

            <p class="text-xs font-bold text-gray-500 uppercase px-2 mt-6 mb-2 tracking-wider">Master Data</p>

            <a href="{{ route('admin.products.index') }}"
                class="{{ request()->routeIs('admin.products*') ? 'bg-secondary text-white shadow-lg shadow-secondary/20' : 'text-gray-400 hover:bg-[#222] hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition duration-200">
                <i class="fa-solid fa-box-open w-6"></i> Produk Kue
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="{{ request()->routeIs('admin.categories*') ? 'bg-secondary text-white shadow-lg shadow-secondary/20' : 'text-gray-400 hover:bg-[#222] hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition duration-200">
                <i class="fa-solid fa-tags w-6"></i> Kategori
            </a>

            <a href="{{ route('admin.customers.index') }}"
                class="{{ request()->routeIs('admin.customers*') ? 'bg-secondary text-white shadow-lg shadow-secondary/20' : 'text-gray-400 hover:bg-[#222] hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition duration-200">
                <i class="fa-solid fa-users w-6"></i> Pelanggan
            </a>

            <p class="text-xs font-bold text-gray-500 uppercase px-2 mt-6 mb-2 tracking-wider">Laporan</p>

            <a href="{{ route('admin.reports.index') }}"
                class="{{ request()->routeIs('admin.reports*') ? 'bg-secondary text-white shadow-lg shadow-secondary/20' : 'text-gray-400 hover:bg-[#222] hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition duration-200">
                <i class="fa-solid fa-file-invoice-dollar w-6"></i> Keuangan
            </a>
             <p class="text-xs font-bold text-gray-500 uppercase px-2 mt-6 mb-2 tracking-wider">Analitik</p>

            <a href="{{ route('admin.trends.index') }}"
                class="{{ request()->routeIs('admin.trends*') ? 'bg-secondary text-white shadow-lg shadow-secondary/20' : 'text-gray-400 hover:bg-[#222] hover:text-white' }} flex items-center px-4 py-3 rounded-xl transition duration-200">
                <i class="fa-solid fa-chart-pie w-6"></i> Trend Produk
            </a>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-[#222] text-red-400 px-4 py-2 rounded-lg hover:bg-red-900/20 hover:text-red-500 transition border border-transparent hover:border-red-900">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

        <header class="h-16 bg-[#1a1a1a]/90 backdrop-blur border-b border-gray-800 flex items-center justify-between px-4 md:px-8 z-10">
            
            <!-- TOMBOL TOGGLE (Hanya muncul di Mobile) -->
            <button id="sidebarToggle" class="text-white text-2xl md:hidden mr-4">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="flex items-center justify-between w-full">
                <div class="text-gray-400 text-sm">
                    Halo, <span class="text-white font-bold">{{ Auth::user()->name }}</span> 👋
                </div>
                <a href="/" target="_blank"
                    class="text-sm text-secondary hover:text-white transition flex items-center gap-2">
                    <i class="fa-solid fa-globe"></i> <span class="hidden md:inline">Lihat Website</span>
                </a>
                
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#121212] p-4 md:p-8">
            {{ $slot }}
        </main>
        
        <!-- FOOTER ADMIN -->
        {{-- <footer class="bg-[#111] border-t border-secondary/20 pt-8 pb-8 mt-auto">
            <div class="container mx-auto px-4 md:px-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                    
                    <div class="space-y-4">
                        <a href="/" class="text-xl font-bold text-secondary tracking-widest flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-cake-candles"></i> BAKERY<span class="text-white">LUXE</span>
                        </a>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Menghadirkan kebahagiaan di setiap gigitan. Kue premium dengan bahan berkualitas tinggi untuk momen spesial Anda.
                        </p>
                        <div class="flex gap-4 pt-4">
                            <a href="#" class="w-8 h-8 rounded-full bg-[#222] flex items-center justify-center text-gray-400 hover:bg-secondary hover:text-white transition duration-300">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="#" class="w-8 h-8 rounded-full bg-[#222] flex items-center justify-center text-gray-400 hover:bg-secondary hover:text-white transition duration-300">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <a href="#" class="w-8 h-8 rounded-full bg-[#222] flex items-center justify-center text-gray-400 hover:bg-secondary hover:text-white transition duration-300">
                                <i class="fa-brands fa-tiktok"></i>
                            </a>
                        </div>
                    </div>
    
                    <div>
                        <h3 class="text-white font-bold text-base mb-4 relative inline-block">
                            Jelajahi
                            <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-secondary"></span>
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="/" class="hover:text-secondary transition block">Beranda</a></li>
                            <li><a href="{{ route('catalog') }}" class="hover:text-secondary transition block">Katalog Menu</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Galeri Testimoni</a></li>
                        </ul>
                    </div>
    
                    <div>
                        <h3 class="text-white font-bold text-base mb-4 relative inline-block">
                            Bantuan
                            <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-secondary"></span>
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-secondary transition block">Cara Pemesanan</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Info Pengiriman</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Syarat & Ketentuan</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">FAQ / Pertanyaan</a></li>
                        </ul>
                    </div>
    
                    <div>
                        <h3 class="text-white font-bold text-base mb-4 relative inline-block">
                            Hubungi Kami
                            <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-secondary"></span>
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-location-dot text-secondary mt-1"></i>
                                <span>Jl.Singangamaraja Amplas,<br>Medan</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fa-solid fa-phone text-secondary"></i>
                                <span>+62 858-3511-6946</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fa-solid fa-envelope text-secondary"></i>
                                <span>dapoerbunasya@gmail.com</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <i class="fa-solid fa-clock text-secondary"></i>
                                <span>Buka Setiap Hari: 08.00 - 21.00</span>
                            </li>
                        </ul>
                    </div>
    
                </div>
    
                <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 text-sm text-center md:text-left">
                        &copy; {{ date('Y') }} <strong class="text-white">dapoerbunasya</strong>. All rights reserved.
                    </p>
                    
                    <div class="flex gap-3 opacity-50 grayscale hover:grayscale-0 transition duration-500">
                        <i class="fa-brands fa-cc-visa text-xl text-white"></i>
                        <i class="fa-brands fa-cc-mastercard text-xl text-white"></i>
                        <i class="fa-solid fa-wallet text-xl text-white"></i> 
                    </div>
                </div>
                
            </div>
        </footer> --}}
    </div>

    <!-- SCRIPT TOGGLE SIDEBAR -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('closeSidebar');

        // Buka Sidebar
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        // Tutup Sidebar (klik tombol close atau klik background gelap)
        function closeMenu() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        closeBtn.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);
    </script>
</body>

</html>