<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50">
        <div class="w-full max-w-md">
            <!-- Logo atau Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-lock text-2xl text-green-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
            </div>

            <!-- Card Container -->
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <!-- Description -->
                <div class="mb-6 text-center">
                    <p class="text-gray-600">
                        {{ __('Masukkan email Anda untuk menerima link reset password.') }}
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Email') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="nama@example.com"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col gap-4">
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center px-4 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition-colors"
                        >
                            <i class="fas fa-paper-plane mr-2"></i>
                            {{ __('Kirim Link Reset Password') }}
                        </button>
                        
                        <a
                            href="{{ route('login') }}"
                            class="text-center text-sm text-gray-600 hover:text-green-600 transition-colors"
                        >
                            <i class="fas fa-arrow-left mr-1"></i>
                            {{ __('Kembali ke Login') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>