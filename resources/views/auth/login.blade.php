<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!-- Main Content -->
    <div class="max-w-screen-xl mx-auto px-4 py-8 pt-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Side - Login Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h1>
                    <p class="text-gray-600">Masuk ke Sistem Peminjaman Sarana Prasarana</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')"
                            class="block text-sm font-medium text-gray-700 mb-2" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <x-text-input id="email"
                                class="pl-10 w-full border-2 border-gray-200 rounded-lg py-3 focus:ring-green-500 focus:border-green-500"
                                type="email" name="email" :value="old('email')" required autofocus
                                autocomplete="username" placeholder="Masukkan Email Anda" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')"
                            class="block text-sm font-medium text-gray-700 mb-2" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M4 8V6a6 6 0 1112 0v2h1a2 2 0 012 2v8a2 2 0 01-2 2H3a2 2 0 01-2-2v-8a2 2 0 012-2h1zm2-2a4 4 0 118 0v2H6V6z" />
                                </svg>
                            </div>
                            <x-text-input id="password"
                                class="pl-10 w-full border-2 border-gray-200 rounded-lg py-3 focus:ring-green-500 focus:border-green-500"
                                type="password" name="password" required autocomplete="current-password"
                                placeholder="••••••••" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eyeIcon">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <label for="remember_me" class="ml-2 text-sm text-gray-600">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-green-600 hover:text-green-700">
                                {{ __('Lupa password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 text-white rounded-lg py-3 px-4 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition duration-300 font-semibold">
                        {{ __('Log in') }}
                    </button>

                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">atau</span>
                        </div>
                    </div>

                    <div class="text-sm text-gray-600 flex items-center justify-between">
                        <a href="{{ route('home') }}" class="font-medium text-green-600 hover:text-green-700 ml-1">Lihat
                            Beranda</a>
                        <div class="ml-auto">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                                class="font-medium text-green-600 hover:text-green-700 ml-1">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Side - Info -->
            <div class="hidden lg:block">
                <div class="space-y-8">
                    <h2 class="text-4xl font-extrabold text-gray-900">
                        Sistem Informasi Peminjaman
                        <span class="text-green-600 block">Sarana & Prasarana</span>
                    </h2>

                    <p class="text-lg text-gray-600">
                        Ajukan peminjaman fasilitas kampus dengan mudah dan efisien melalui SIMSAPRAS Universitas
                        Andalas.
                    </p>

                    <div class="grid grid-cols-2 gap-6 mt-8">
                        <div class="bg-white p-6 rounded-xl shadow-md hover:bg-green-100">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Proses Cepat</h3>
                            <p class="text-gray-600">Peminjaman ruangan dapat diproses dalam waktu 1x24 jam kerja</p>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-md hover:bg-green-100">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Aman & Terpercaya</h3>
                            <p class="text-gray-600">Sistem terintegrasi dan sudah terverifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            togglePassword.addEventListener('click', function() {
                // Toggle tipe input
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Ganti ikon mata
                if (type === 'text') {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    `;
                } else {
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            });
        });
    </script>
</x-guest-layout>
