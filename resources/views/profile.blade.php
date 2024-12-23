@extends('layouts.user')
@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden">
        <!-- Header Section with Avatar -->
        <div class="relative bg-gradient-to-r from-green-600 to-green-400 p-12">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                    <rect width="100" height="100" fill="url(#grid)"/>
                </svg>
            </div>

            <!-- Edit Button -->
            <button
                class="absolute top-4 right-4 bg-white/30 hover:bg-white/50 rounded-full p-3 transition-all flex items-center justify-center group"
                onclick="toggleEditForm()"
            >
                <i class="fas fa-pen text-white text-lg group-hover:scale-110 transition-transform"></i>
            </button>

            <!-- Profile Info -->
            <div class="flex flex-col items-center relative">
                <!-- Avatar Container with Animation -->
                <div class="relative mb-6">
                    <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-user text-5xl text-gray-400"></i>
                    </div>
                    <!-- Status Indicator -->
                    <div class="absolute bottom-2 right-2 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                </div>

                <!-- User Info Container -->
                <div class="space-y-3 text-center">
                    <h2 class="text-3xl font-bold text-white mb-2 text-center" id="name">
                        {{ $pengguna->name ?? 'Tidak diketahui' }}
                    </h2>
                    
                    <!-- Contact Info with Icons -->
                    <div class="flex items-center justify-center space-x-2 text-green-50">
                        <i class="fas fa-phone-alt"></i>
                        <p class="text-green-50" id="kontak">
                            {{ $pengguna->kontak ?? 'Tidak diketahui' }}
                        </p>
                    </div>
                    
                    <div class="flex items-center justify-center space-x-2 text-green-50">
                        <i class="fas fa-envelope"></i>
                        <p class="text-green-50" id="email">
                            {{ $pengguna->email ?? 'Tidak diketahui' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info Section -->
        <div class="p-6 bg-white">
            <div class="grid grid-cols-2 gap-4">
                <!-- Stats or Additional Info -->
                <div class="bg-gray-50 p-4 rounded-xl text-center hover:shadow-md transition-shadow">
                    <p class="text-gray-500 text-sm">Total Peminjaman</p>
                    <p class="text-2xl font-bold text-green-600">0</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl text-center hover:shadow-md transition-shadow">
                    <p class="text-gray-500 text-sm">Status</p>
                    <p class="text-2xl font-bold text-green-600">Aktif</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection