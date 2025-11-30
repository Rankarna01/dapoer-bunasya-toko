<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Toko Kue Premium' }}</title>

    <!-- Library Font & Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Config Warna -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1a1a1a', // Hitam Elegan
                        secondary: '#8D6E63', // Coklat Premium
                        accent: '#F5F5DC', // Cream / Soft Neutral
                        'secondary-dark': '#6D4C41',
                        'accent-dark': '#E8E8C8',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #1a1a1a;
            color: #F5F5DC;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #8D6E63;
            border-radius: 4px;
        }

        /* Animation Classes */
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="flex flex-col min-h-screen font-sans antialiased">

    <!-- NAVBAR -->
    <nav
        class="bg-primary/95 backdrop-blur-sm border-b border-secondary/30 p-4 sticky top-0 z-50 shadow-lg transition-all duration-300">
        <div class="container mx-auto flex flex-wrap justify-between items-center">

            <!-- LOGO -->
            <a href="/" class="text-2xl font-bold text-secondary tracking-widest flex items-center gap-2">
                <i class="fa-solid fa-cake-candles"></i> Dapoer<span class="text-accent">Bunasya</span>
            </a>

            <!-- TOMBOL MOBILE MENU (Toggle) -->
            <button id="mobile-menu-btn" class="md:hidden text-accent text-2xl hover:text-secondary transition focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- MENU DESKTOP (Hidden di Mobile) -->
            <div class="hidden md:flex items-center space-x-8 text-accent text-sm font-medium">

                <!-- Menu Utama -->
                <a href="/" class="hover:text-secondary transition flex items-center gap-1">
                    <i class="fa-solid fa-house"></i> Home
                </a>
                <a href="/katalog" class="hover:text-secondary transition flex items-center gap-1">
                    <i class="fa-solid fa-store"></i> Katalog
                </a>

                @auth
                    <!-- JIKA SUDAH LOGIN -->

                    <!-- Icon Cart -->
                    <a href="{{ route('cart') }}" class="hover:text-secondary transition relative mr-2">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                        <!-- Tanda seru / badge jumlah -->
                        <span
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full border border-primary">!</span>
                    </a>

                    <!-- Dropdown User -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 hover:text-secondary transition focus:outline-none">
                            <i class="fa-solid fa-circle-user text-2xl"></i>
                            <span class="font-semibold">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-xs ml-1"></i>
                        </button>

                        <!-- Isi Dropdown -->
                        <div
                            class="absolute right-0 mt-2 w-56 bg-[#2a2a2a] border border-gray-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300 z-50 overflow-hidden">

                            <!-- Header Dropdown -->
                            <div class="px-4 py-3 border-b border-gray-700">
                                <p class="text-sm text-white font-bold truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Pilihan Menu Berdasarkan Role -->
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 hover:bg-[#333] hover:text-secondary transition">
                                    <i class="fa-solid fa-gauge mr-2"></i> Dashboard Admin
                                </a>
                            @elseif(Auth::user()->role == 'kasir')
                                <a href="{{ route('kasir.dashboard') }}"
                                    class="block px-4 py-2 hover:bg-[#333] hover:text-secondary transition">
                                    <i class="fa-solid fa-cash-register mr-2"></i> Dashboard Kasir
                                </a>
                            @else
                                <a href="{{ route('customer.dashboard') }}"
                                    class="block px-4 py-2 hover:bg-[#333] hover:text-secondary transition">
                                    <i class="fa-solid fa-user mr-2"></i> Dashboard Saya
                                </a>
                                <a href="{{ route('my.orders') }}"
                                    class="block px-4 py-2 hover:bg-[#333] hover:text-secondary transition">
                                    <i class="fa-solid fa-receipt mr-2"></i> Pesanan Saya
                                </a>
                            @endif

                            <!-- Logout -->
                            <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-700">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-3 text-red-400 hover:bg-[#333] hover:text-red-500 transition text-sm font-medium">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- JIKA BELUM LOGIN (GUEST) -->
                    <div class="flex items-center gap-4 border-l border-gray-700 pl-6">
                        <a href="{{ route('login') }}" class="text-accent hover:text-white transition font-medium">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-secondary text-white px-6 py-2 rounded-full hover:bg-secondary-dark transition shadow-lg shadow-secondary/20 text-sm font-bold tracking-wide transform hover:-translate-y-0.5">
                            DAFTAR
                        </a>
                    </div>
                @endauth

            </div>

            <!-- MENU MOBILE (Muncul saat tombol ditekan) -->
            <div id="mobile-menu" class="hidden w-full md:hidden mt-4 border-t border-gray-700 pt-4 animate-fade-in-up">
                <div class="flex flex-col space-y-4">
                    <a href="/" class="text-accent hover:text-secondary py-2 border-b border-gray-800">
                        <i class="fa-solid fa-house w-6 text-center"></i> Home
                    </a>
                    <a href="/katalog" class="text-accent hover:text-secondary py-2 border-b border-gray-800">
                        <i class="fa-solid fa-store w-6 text-center"></i> Katalog
                    </a>

                    @auth
                         <!-- Mobile Logged In -->
                        <div class="py-2 border-b border-gray-800">
                             <p class="text-gray-400 text-xs mb-1">Login sebagai:</p>
                             <p class="text-white font-bold">{{ Auth::user()->name }}</p>
                        </div>
                        
                         @if (Auth::user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-accent hover:text-secondary py-2">Dashboard Admin</a>
                        @elseif(Auth::user()->role == 'kasir')
                             <a href="{{ route('kasir.dashboard') }}" class="text-accent hover:text-secondary py-2">Dashboard Kasir</a>
                        @else
                            <a href="{{ route('customer.dashboard') }}" class="text-accent hover:text-secondary py-2">Dashboard Saya</a>
                            <a href="{{ route('my.orders') }}" class="text-accent hover:text-secondary py-2">Pesanan Saya</a>
                            <a href="{{ route('cart') }}" class="text-accent hover:text-secondary py-2">Keranjang Belanja</a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-400 hover:text-red-500 py-2 w-full text-left">
                                <i class="fa-solid fa-right-from-bracket w-6 text-center"></i> Logout
                            </button>
                        </form>
                    @else
                        <!-- Mobile Guest -->
                        <div class="flex flex-col gap-3 pt-2">
                            <a href="{{ route('login') }}" class="text-center text-accent border border-gray-600 py-2 rounded-lg hover:bg-gray-800">Masuk</a>
                            <a href="{{ route('register') }}" class="text-center bg-secondary text-white py-2 rounded-lg hover:bg-secondary-dark">Daftar Sekarang</a>
                        </div>
                    @endauth
                </div>
            </div>

        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main class="flex-grow container mx-auto p-4 md:px-8 md:py-8">
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#111] border-t border-secondary/20 pt-16 pb-8 mt-20">
        <div class="container mx-auto px-4 md:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">

                <div class="space-y-4">
                    <a href="/" class="text-2xl font-bold text-secondary tracking-widest flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-cake-candles"></i> BAKERY<span class="text-white">LUXE</span>
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Menghadirkan kebahagiaan di setiap gigitan. Kue premium dengan bahan berkualitas tinggi untuk momen
                        spesial Anda.
                    </p>
                    <div class="flex gap-4 pt-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-[#222] flex items-center justify-center text-gray-400 hover:bg-secondary hover:text-white transition duration-300">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-[#222] flex items-center justify-center text-gray-400 hover:bg-secondary hover:text-white transition duration-300">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-[#222] flex items-center justify-center text-gray-400 hover:bg-secondary hover:text-white transition duration-300">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-bold text-lg mb-6 relative inline-block">
                        Jelajahi
                        <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-secondary"></span>
                    </h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="/" class="hover:text-secondary transition block transform hover:translate-x-1">Beranda</a></li>
                        <li><a href="{{ route('catalog') }}" class="hover:text-secondary transition block transform hover:translate-x-1">Katalog Menu</a></li>
                        <li><a href="#" class="hover:text-secondary transition block transform hover:translate-x-1">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-secondary transition block transform hover:translate-x-1">Galeri Testimoni</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-lg mb-6 relative inline-block">
                        Bantuan
                        <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-secondary"></span>
                    </h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-secondary transition block transform hover:translate-x-1">Cara Pemesanan</a></li>
                        <li><a href="#" class="hover:text-secondary transition block transform hover:translate-x-1">Info Pengiriman</a></li>
                        <li><a href="#" class="hover:text-secondary transition block transform hover:translate-x-1">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-secondary transition block transform hover:translate-x-1">FAQ / Pertanyaan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-lg mb-6 relative inline-block">
                        Hubungi Kami
                        <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-secondary"></span>
                    </h3>
                    <ul class="space-y-4 text-sm text-gray-400">
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

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm text-center md:text-left">
                    &copy; {{ date('Y') }} <strong class="text-white">Dapoer Bunasya</strong>. All rights reserved.
                </p>

                <div class="flex gap-3 opacity-50 grayscale hover:grayscale-0 transition duration-500">
                    <i class="fa-brands fa-cc-visa text-2xl text-white"></i>
                    <i class="fa-brands fa-cc-mastercard text-2xl text-white"></i>
                    <i class="fa-solid fa-wallet text-2xl text-white"></i>
                </div>
            </div>

        </div>
    </footer>

    <!-- SCRIPT TOGGLE MENU MOBILE -->
    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

</body>

</html>