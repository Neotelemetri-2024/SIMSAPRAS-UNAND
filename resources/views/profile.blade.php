@extends('layouts.user')
@section('content')
<div class="bg-gradient-to-r from-green-600 to-green-800 pt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="relative flex-shrink-0">
                <div class="w-36 h-36 bg-white/15 backdrop-blur rounded-full flex items-center justify-center border-4 border-white/20">
                    <i class="fas fa-user text-white/90 text-5xl"></i>
                </div>
                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-400 rounded-full border-4 border-green-800"></div>
            </div>

            <div class="text-center md:text-left space-y-4">
                <h1 class="text-4xl md:text-5xl font-bold text-white">{{ $pengguna->name ?? 'Tidak diketahui' }}</h1>
                <div class="flex flex-col sm:flex-row gap-4 text-lg text-white/90">
                    <div class="flex items-center gap-3 bg-white/10 px-4 py-2 rounded-lg">
                        <i class="fas fa-phone-alt"></i>
                        <span>{{ $pengguna->kontak ?? 'Tidak diketahui' }}</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 px-4 py-2 rounded-lg">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $pengguna->email ?? 'Tidak diketahui' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-green-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Total Peminjaman</h3>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-book text-green-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $totalPeminjaman }}</p>
                <p class="text-sm text-gray-500 mt-1">Peminjaman aktif</p>
            </div>
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
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Bergabung Sejak</h3>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar text-green-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $tahunBergabung }}</p>
                <p class="text-sm text-gray-500 mt-1">Tahun bergabung</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900">Aktivitas Terbaru</h2>
            @forelse($aktivitasTerbaru as $aktivitas)
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-book text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">
                            Peminjaman 
                            @if(!empty($aktivitas->ruangan) && !empty($aktivitas->ruangan->nama))
                                {{ $aktivitas->ruangan->nama }}
                            @else
                                {{ !empty($aktivitas->sarana) && !empty($aktivitas->sarana->nama) ? $aktivitas->sarana->nama : '' }}
                            @endif
                        </p>
                        <p class="text-gray-500">Status: 
                            @if($aktivitas->status == 'diajukanbatal')
                            Pengajuan Pembatalan
                            @else
                            {{ ucfirst($aktivitas->status) }}</p>
                            @endif
                        <p class="text-sm text-gray-400">{{ $aktivitas->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-book text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Belum ada aktivitas</p>
                        <p class="text-gray-500">Aktivitas akan muncul di sini</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900">Aksi Cepat</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach([
                    ['title' => 'Peminjaman', 'desc' => 'Mulai peminjaman baru', 'icon' => 'building', 'route' => 'user.sarana'],
                    ['title' => 'Riwayat', 'desc' => 'Lihat riwayat peminjaman', 'icon' => 'history', 'route' => 'riwayat.index'],
                    ['title' => 'Ubah Password', 'desc' => 'Perbarui password akun', 'icon' => 'key', 'route' => 'password.change'],
                    ['title' => 'Pengaduan', 'desc' => 'Beri tahu kami yang perlu diperbaiki', 'icon' => 'comments', 'route' => 'user.pengaduan.show']
                ] as $action)
                <a href="{{ route($action['route']) }}" 
                   class="group bg-white rounded-2xl p-6 shadow-lg hover:bg-green-600 hover:shadow-md transition-all">
                    <i class="fas fa-{{ $action['icon'] }} text-2xl text-green-600 group-hover:text-white mb-4 block"></i>
                    <h3 class="font-semibold text-gray-900 group-hover:text-white mb-1">{{ $action['title'] }}</h3>
                    <p class="text-sm text-gray-500 group-hover:text-white/90">{{ $action['desc'] }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection