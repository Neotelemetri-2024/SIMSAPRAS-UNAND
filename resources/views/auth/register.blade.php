<x-guest-layout>
    <div class="max-w-screen-xl mx-auto pt-10 pb-10">
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

                    <div>
                        <x-input-label for="kontak" :value="__('Kontak')" class="block text-sm font-medium text-gray-700 mb-2"/>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <x-text-input id="kontak"
                                class="pl-10 w-full border-2 border-gray-200 rounded-lg py-3 focus:ring-green-500 focus:border-green-500"
                                type="text"
                                name="kontak"
                                :value="old('kontak')"
                                required
                                autofocus
                                autocomplete="kontak"
                                placeholder="Masukkan nomor Handphone" />
                        </div>
                        <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
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

                    <div class="flex items-center justify-between">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
