<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50">
        <div class="w-full max-w-md">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-key text-2xl text-green-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Set Password Baru</h2>
                <p class="mt-2 text-gray-600">Buat password baru yang kuat untuk akun Anda</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Field -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            {{ __('Email') }}
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 {{$errors->has('email') ? 'border-red-300' : ''}}"
                                value="{{ old('email', $request->email) }}"
                                required
                                autofocus
                                autocomplete="username"
                            />
                        </div>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            {{ __('Password Baru') }}
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 {{$errors->has('password') ? 'border-red-300' : ''}}"
                                required
                                autocomplete="new-password"
                                placeholder="Minimal 8 karakter"
                            />
                        </div>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            {{ __('Konfirmasi Password') }}
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 {{$errors->has('password_confirmation') ? 'border-red-300' : ''}}"
                                required
                                autocomplete="new-password"
                                placeholder="Ulangi password baru"
                            />
                        </div>
                        @error('password_confirmation')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center px-4 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition-colors"
                        >
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    {{ __('Sudah ingat password Anda?') }}
                    <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-medium">
                        {{ __('Login di sini') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>