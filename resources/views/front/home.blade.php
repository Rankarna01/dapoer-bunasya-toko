<x-layout>
    <x-slot:title>Home - Dapoer Bunasya</x-slot>

    <section class="relative py-5 md:py-5 overflow-hidden">
        
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-secondary/10 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 bg-secondary/5 rounded-full blur-3xl -z-10"></div>

        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="order-2 lg:order-1 space-y-6 animate-fade-in-up">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary/10 border border-secondary/20 text-secondary text-xs font-bold tracking-widest uppercase">
                        <i class="fa-solid fa-crown"></i> Premium Bakery
                    </div>
                    
                    <h1 class="text-4xl md:text-6xl font-bold text-accent leading-tight">
                        Rasakan Kemewahan <br> 
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-[#c7a99b]">
                            Dalam Setiap Gigitan
                        </span>
                    </h1>
                    
                    <p class="text-gray-400 text-lg leading-relaxed max-w-lg">
                        Kami menghadirkan perpaduan resep autentik Eropa dengan bahan-bahan lokal terbaik. Tekstur lembut, rasa kaya, dan pengalaman tak terlupakan.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('catalog') }}" class="group relative px-8 py-4 bg-secondary text-white font-bold rounded-full overflow-hidden shadow-lg shadow-secondary/30 transition-all hover:scale-105">
                            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-in-out"></span>
                            <span class="relative flex items-center gap-2">
                                Pesan Sekarang <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </a>

                        <a href="#about" class="px-8 py-4 border border-gray-600 text-gray-300 font-bold rounded-full hover:border-secondary hover:text-secondary transition text-center">
                            Tentang Kami
                        </a>
                    </div>

                    {{-- <div class="flex gap-8 pt-8 border-t border-gray-800 mt-8">
                        <div>
                            <h4 class="text-2xl font-bold text-white">50+</h4>
                            <p class="text-xs text-gray-500 uppercase">Varian Kue</p>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-white">1k+</h4>
                            <p class="text-xs text-gray-500 uppercase">Pelanggan Puas</p>
                        </div>
                    </div> --}}
                </div>

                <div class="order-1 lg:order-2 relative group">
                    <div class="relative z-10 rounded-3xl overflow-hidden shadow-2xl border-4 border-[#2a2a2a] transform transition duration-500 group-hover:-translate-y-2 group-hover:rotate-1">
                        <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1000&auto=format&fit=crop" 
                             alt="Premium Cake" 
                             class="w-full h-[400px] md:h-[500px] object-cover">
                        
                        <div class="absolute bottom-6 left-6 bg-black/80 backdrop-blur-md border border-secondary/30 p-4 rounded-xl shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center text-white">
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 border-2 border-secondary/20 rounded-3xl transform translate-x-4 translate-y-4 -z-0"></div>
                </div>

            </div>
        </div>
    </section>

    <section class="relative py-20 md:py-28">
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full max-w-4xl bg-secondary/5 blur-[100px] rounded-full -z-10 pointer-events-none"></div>

        <div class="container mx-auto px-4">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div class="max-w-2xl relative">
                    <div class="w-12 h-1 bg-secondary mb-4 rounded-full"></div>
                    
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">
                        Produk Kue <span class="text-secondary italic">Dapoer Bunasya</span>
                    </h2>
                    <p class="text-gray-400 text-base leading-relaxed">
                        Produk *best-seller* kami yang ada di Toko Dapoer Bunasya. <br class="hidden md:block"> Favorit pelanggan yang wajib Anda coba.
                    </p>
                </div>

                <a href="{{ route('catalog') }}" class="hidden md:inline-flex items-center gap-2 text-white border border-gray-600 px-6 py-3 rounded-full hover:border-secondary hover:text-secondary hover:bg-secondary/5 transition duration-300 group">
                    Lihat Katalog Lengkap 
                    <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            
            <div class="mt-10 text-center md:hidden">
                 <a href="{{ route('catalog') }}" class="inline-block w-full text-center bg-[#222] border border-gray-700 text-white px-6 py-4 rounded-xl hover:bg-secondary hover:border-secondary transition font-semibold">
                    Lihat Semua Produk
                </a>
            </div>

        </div>
    </section>

    <section class="bg-[#222] rounded-2xl p-8 md:p-12 mb-12 border border-secondary/10 shadow-2xl">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-accent mb-2">Mengapa Memilih Kami?</h2>
            <div class="h-1 w-20 bg-secondary mx-auto rounded"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6 rounded-xl hover:bg-white/5 transition duration-300 group">
                <div class="w-16 h-16 bg-primary border border-secondary rounded-full flex items-center justify-center mx-auto mb-4 text-2xl group-hover:scale-110 transition duration-300 shadow-[0_0_15px_rgba(141,110,99,0.3)]">
                    <i class="fa-solid fa-wheat-awn text-secondary"></i>
                </div>
                <h3 class="text-xl font-semibold text-accent mb-2">Bahan Premium</h3>
                <p class="text-gray-400 text-sm font-light">Menggunakan butter wisman asli dan coklat belgia import terbaik.</p>
            </div>
            
            <div class="p-6 rounded-xl hover:bg-white/5 transition duration-300 group">
                <div class="w-16 h-16 bg-primary border border-secondary rounded-full flex items-center justify-center mx-auto mb-4 text-2xl group-hover:scale-110 transition duration-300 shadow-[0_0_15px_rgba(141,110,99,0.3)]">
                    <i class="fa-solid fa-fire-burner text-secondary"></i>
                </div>
                <h3 class="text-xl font-semibold text-accent mb-2">Fresh from Oven</h3>
                <p class="text-gray-400 text-sm font-light">Dibuat setiap pagi hari ini untuk menjamin kualitas rasa.</p>
            </div>
            
            <div class="p-6 rounded-xl hover:bg-white/5 transition duration-300 group">
                <div class="w-16 h-16 bg-primary border border-secondary rounded-full flex items-center justify-center mx-auto mb-4 text-2xl group-hover:scale-110 transition duration-300 shadow-[0_0_15px_rgba(141,110,99,0.3)]">
                    <i class="fa-solid fa-truck-fast text-secondary"></i>
                </div>
                <h3 class="text-xl font-semibold text-accent mb-2">Pengiriman Cepat</h3>
                <p class="text-gray-400 text-sm font-light">Layanan antar aman menjamin kue sampai dengan sempurna.</p>
            </div>
        </div>
    </section>
</x-layout>