<section class="bg-white">
    <x-guest-layout>
        <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50">
            <div class="w-full max-w-md">
                <!-- Header Section -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                        <i class="fas fa-key text-2xl text-green-600"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Ubah Password</h2>
                    <p class="mt-2 text-gray-600">Silakan masukkan password lama dan password baru Anda</p>
                </div>
    
                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-100 rounded-lg">
                            <p class="text-green-700">{{ session('status') }}</p>
                        </div>
                    @endif
    
                    <form method="POST" action="{{ route('password.change.update') }}" class="space-y-6">
                        @csrf
    
                        <!-- Current Password -->
                        <div class="space-y-1">
                            <label for="current_password" class="block text-sm font-medium text-gray-700">
                                Password Saat Ini
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input
                                    id="current_password"
                                    type="password"
                                    name="current_password"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    required
                                />
                            </div>
                            @error('current_password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <!-- New Password -->
                        <div class="space-y-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Password Baru
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    required
                                    placeholder="Minimal 8 karakter"
                                />
                            </div>
                            @error('password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <!-- Confirm New Password -->
                        <div class="space-y-1">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Konfirmasi Password Baru
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    required
                                    placeholder="Ulangi password baru"
                                />
                            </div>
                            @error('password_confirmation')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <button type="submit" 
                            class="w-full flex items-center justify-center px-4 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition-colors">
                            <i class="fas fa-check-circle mr-2"></i>
                            Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </x-guest-layout>
</section>
