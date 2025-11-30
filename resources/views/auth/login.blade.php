<x-layout>
    <x-slot:title>Login - Dapoer Bunasya</x-slot>

    <div class="flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-[#2a2a2a] p-10 rounded-2xl shadow-2xl border border-secondary/20">
            <div class="text-center">
                <i class="fa-solid fa-circle-user text-5xl text-secondary mb-4"></i>
                <h2 class="text-3xl font-bold text-accent">Selamat Datang Kembali</h2>
                <p class="mt-2 text-sm text-gray-400">Masuk untuk melanjutkan pesanan Anda</p>
            </div>
            
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <input id="email" name="email" type="email" required class="appearance-none rounded-lg relative block w-full pl-10 px-3 py-3 bg-[#333] border border-gray-600 placeholder-gray-500 text-accent focus:outline-none focus:ring-secondary focus:border-secondary focus:z-10 sm:text-sm transition" placeholder="Alamat Email">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input id="password" name="password" type="password" required class="appearance-none rounded-lg relative block w-full pl-10 px-3 py-3 bg-[#333] border border-gray-600 placeholder-gray-500 text-accent focus:outline-none focus:ring-secondary focus:border-secondary focus:z-10 sm:text-sm transition" placeholder="Password">
                        </div>
                    </div>
                </div>

                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition shadow-lg transform hover:-translate-y-0.5">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        </span>
                        Masuk Sekarang
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-4">
                <p class="text-sm text-gray-400">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-medium text-secondary hover:text-accent transition">Daftar disini</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>