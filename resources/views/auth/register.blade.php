<x-layout>
    <x-slot:title>Daftar Akun - Dapoer Bunasya</x-slot>

    <div class="flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-[#2a2a2a] p-10 rounded-2xl shadow-2xl border border-secondary/20">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-accent">Buat Akun Baru</h2>
                <p class="mt-2 text-sm text-gray-400">Daftar untuk mulai menikmati kue premium</p>
            </div>
            
            <form class="mt-8 space-y-4" action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <input name="name" type="text" required class="block w-full pl-10 px-3 py-3 bg-[#333] border border-gray-600 rounded-lg text-accent focus:ring-secondary focus:border-secondary sm:text-sm" placeholder="Nama Lengkap">
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <input name="phone" type="number" required class="block w-full pl-10 px-3 py-3 bg-[#333] border border-gray-600 rounded-lg text-accent focus:ring-secondary focus:border-secondary sm:text-sm" placeholder="Nomor WhatsApp">
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input name="email" type="email" required class="block w-full pl-10 px-3 py-3 bg-[#333] border border-gray-600 rounded-lg text-accent focus:ring-secondary focus:border-secondary sm:text-sm" placeholder="Alamat Email">
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input name="password" type="password" required class="block w-full pl-10 px-3 py-3 bg-[#333] border border-gray-600 rounded-lg text-accent focus:ring-secondary focus:border-secondary sm:text-sm" placeholder="Password">
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <input name="password_confirmation" type="password" required class="block w-full pl-10 px-3 py-3 bg-[#333] border border-gray-600 rounded-lg text-accent focus:ring-secondary focus:border-secondary sm:text-sm" placeholder="Ulangi Password">
                </div>
                
                @if ($errors->any())
                    <div class="text-red-500 text-xs">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="w-full py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition shadow-lg mt-6">
                    Daftar Sekarang
                </button>
            </form>
            
            <div class="text-center mt-4">
                <p class="text-sm text-gray-400">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-medium text-secondary hover:text-accent transition">Login disini</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>