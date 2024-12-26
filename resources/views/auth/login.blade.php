<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- <!-- Navbar -->
    <a
      href="{{ route('home') }}"
      class="fixed top-4 left-4 flex items-center text-gray-600 hover:text-green-600 transition-colors"
    >
      <span class="font-medium">< Kembali ke Beranda</span>
    </a> --}}

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
                        <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <x-text-input id="email"
                                class="pl-10 w-full border-2 border-gray-200 rounded-lg py-3 focus:ring-green-500 focus:border-green-500"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="nama@unand.ac.id" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-2" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M4 8V6a6 6 0 1112 0v2h1a2 2 0 012 2v8a2 2 0 01-2 2H3a2 2 0 01-2-2v-8a2 2 0 012-2h1zm2-2a4 4 0 118 0v2H6V6z" />
                                </svg>
                            </div>
                            <x-text-input id="password"
                                class="pl-10 w-full border-2 border-gray-200 rounded-lg py-3 focus:ring-green-500 focus:border-green-500"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <label for="remember_me" class="ml-2 text-sm text-gray-600">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-700">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-3 px-4 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition duration-300 font-semibold">
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
                        <a href="{{ route('home') }}" class="font-medium text-green-600 hover:text-green-700 ml-1">Lihat Beranda</a>
                        <div class="ml-auto">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-700 ml-1">
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
                        Kelola dan ajukan peminjaman fasilitas kampus dengan mudah dan efisien melalui SIMSAPRAS Universitas Andalas.
                    </p>

                    <div class="grid grid-cols-2 gap-6 mt-8">
                        <div class="bg-white p-6 rounded-xl shadow-md hover:bg-green-100">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Proses Cepat</h3>
                            <p class="text-gray-600">Peminjaman ruangan dapat diproses dalam waktu 1x24 jam kerja</p>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-md hover:bg-green-100">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Aman & Terpercaya</h3>
                            <p class="text-gray-600">Sistem terintegrasi dengan SSO Universitas Andalas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
