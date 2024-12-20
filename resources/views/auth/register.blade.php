<x-guest-layout>
    <!-- Navbar -->


    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-screen-xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('assets/images/unand.png') }}" alt="Logo UNAND" class="w-10 h-10">
                    <div>
                        <span class="text-green-600 font-bold">SIMSAPRAS</span>
                        <span class="text-gray-600 text-sm ml-2">Universitas Andalas</span>
                    </div>
                </div>
                <div>
                    <a href="/" class="text-sm text-gray-600 hover:text-green-600">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-screen-xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Side - Register Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h1>
                    <p class="text-gray-600">Daftar untuk mengakses SIMSAPRAS</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="block text-sm font-medium text-gray-700 mb-2"/>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <x-text-input id="name"
                                class="pl-10 w-full border-2 border-gray-200 rounded-lg py-3 focus:ring-green-500 focus:border-green-500"
                                type="text"
                                name="name"
                                :value="old('name')"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Masukkan nama lengkap" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-2"/>
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
                                autocomplete="username"
                                placeholder="nama@unand.ac.id" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 mb-2"/>
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
                                autocomplete="new-password"
                                placeholder="Minimal 8 karakter" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700 mb-2"/>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M4 8V6a6 6 0 1112 0v2h1a2 2 0 012 2v8a2 2 0 01-2 2H3a2 2 0 01-2-2v-8a2 2 0 012-2h1zm2-2a4 4 0 118 0v2H6V6z" />
                                </svg>
                            </div>
                            <x-text-input id="password_confirmation"
                                class="pl-10 w-full border-2 border-gray-200 rounded-lg py-3 focus:ring-green-500 focus:border-green-500"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Ulangi password" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('login') }}" class="text-sm text-green-600 hover:text-green-700">
                            {{ __('Sudah mendaftar?') }}
                        </a>

                        <x-primary-button class="ml-4 bg-green-600 hover:bg-green-700 focus:ring-green-500">
                            {{ __('Daftar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Right Side - Info -->
            <div class="hidden lg:block">
                <div class="space-y-8">
                    <h2 class="text-4xl font-extrabold text-gray-900">
                        Bergabung dengan
                        <span class="text-green-600 block">SIMSAPRAS</span>
                    </h2>

                    <p class="text-lg text-gray-600">
                        Nikmati kemudahan dalam peminjaman sarana dan prasarana Universitas Andalas
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-700">Proses pendaftaran cepat dan mudah</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-700">Manajemen peminjaman yang efisien</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-700">Terintegrasi dengan sistem Unand</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
