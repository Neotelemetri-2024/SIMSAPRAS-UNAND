@extends('layouts.user')
@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden">
    <!-- Background with overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-800"></div>
    
    <!-- Navigation -->
    <nav class="relative z-10 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-white font-semibold text-xl">MyProfile</div>
                <button onclick="toggleEditForm()" class="bg-white/10 px-4 py-2 rounded-lg hover:bg-white/20 transition-colors text-white flex items-center space-x-2">
                    <i class="fas fa-pen"></i>
                    <span>Edit Profile</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-6 py-24">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <!-- Profile Image -->
            <div class="relative">
                <div class="w-32 h-32 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <i class="fas fa-user text-white/80 text-4xl"></i>
                </div>
                <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-emerald-400 rounded-full border-4 border-green-800"></div>
            </div>

            <!-- Profile Info -->
            <div class="text-center md:text-left">
                <h1 class="text-4xl font-bold text-white mb-4">{{ $pengguna->name ?? 'Tidak diketahui' }}</h1>
                <div class="flex flex-col md:flex-row gap-6 text-lg text-white/80">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-phone-alt"></i>
                        <span>{{ $pengguna->kontak ?? 'Tidak diketahui' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $pengguna->email ?? 'Tidak diketahui' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-green-50">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Stat Card 1 -->
            <div class="bg-white rounded-xl p-6 hover:shadow-lg transition-all border border-green-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Total Peminjaman</h3>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-book text-green-600"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">0</p>
                <p class="text-sm text-gray-500 mt-1">Peminjaman aktif</p>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-white rounded-xl p-6 hover:shadow-lg transition-all border border-green-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Status Akun</h3>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-green-600">Aktif</p>
                <p class="text-sm text-gray-500 mt-1">Status saat ini</p>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-white rounded-xl p-6 hover:shadow-lg transition-all border border-green-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Bergabung Sejak</h3>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar text-green-600"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">2024</p>
                <p class="text-sm text-gray-500 mt-1">Tahun bergabung</p>
            </div>
        </div>
    </div>
</div>

<!-- Additional Info Section -->
<div class="max-w-7xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Recent Activity -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Aktivitas Terbaru</h2>
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-white rounded-xl hover:shadow-md transition-all border border-green-100">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-book text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Belum ada aktivitas</p>
                        <p class="text-sm text-gray-500">Aktivitas akan muncul di sini</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Aksi Cepat</h2>
            <div class="grid grid-cols-2 gap-4">
                <button class="group p-4 bg-white rounded-xl hover:bg-green-600 hover:shadow-md transition-all text-left border border-green-100">
                    <i class="fas fa-book text-green-600 mb-2 group-hover:text-white"></i>
                    <h3 class="font-semibold text-gray-900 group-hover:text-white">Pinjam Buku</h3>
                    <p class="text-sm text-gray-500 group-hover:text-white/80">Mulai peminjaman baru</p>
                </button>
                <button class="group p-4 bg-white rounded-xl hover:bg-green-600 hover:shadow-md transition-all text-left border border-green-100">
                    <i class="fas fa-history text-green-600 mb-2 group-hover:text-white"></i>
                    <h3 class="font-semibold text-gray-900 group-hover:text-white">Riwayat</h3>
                    <p class="text-sm text-gray-500 group-hover:text-white/80">Lihat riwayat peminjaman</p>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection