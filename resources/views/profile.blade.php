@extends('layouts.user')
@section('content')
<div class="pt-24 pb-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <!-- Header Profile -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-green-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $pengguna->name ?? 'Tidak diketahui' }}</h1>
                    <p class="text-gray-600">{{ $pengguna->email ?? 'Tidak diketahui' }}</p>
                    @if($pengguna->kontak)
                    <p class="text-sm text-gray-500">{{ $pengguna->kontak }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Layout 2 Kolom -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Statistik -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Peminjaman</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalPeminjaman }}</p>
                            </div>
                            <i class="fas fa-book text-green-600 text-xl"></i>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Status Akun</p>
                                <p class="text-2xl font-bold text-green-600">Aktif</p>
                            </div>
                            <i class="fas fa-check text-green-600 text-xl"></i>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Bergabung</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $tahunBergabung }}</p>
                            </div>
                            <i class="fas fa-calendar text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                    <div class="space-y-3">
                        @foreach([
                            ['title' => 'Peminjaman', 'icon' => 'building', 'route' => 'user.sarana'],
                            ['title' => 'Riwayat', 'icon' => 'history', 'route' => 'riwayat.index'],
                            ['title' => 'Password', 'icon' => 'key', 'route' => 'password.change'],
                            ['title' => 'Pengaduan', 'icon' => 'comments', 'route' => 'user.pengaduan.show']
                        ] as $action)
                        <a href="{{ route($action['route']) }}" 
                           class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-{{ $action['icon'] }} text-green-600 text-lg"></i>
                            <span class="font-medium text-gray-900">{{ $action['title'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Aktivitas Terbaru -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h2>
                    @forelse($aktivitasTerbaru as $aktivitas)
                    <div class="flex items-center justify-between py-4 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-book text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">
                                    @if(!empty($aktivitas->ruangan) && !empty($aktivitas->ruangan->nama))
                                        {{ $aktivitas->ruangan->nama }}
                                    @else
                                        {{ !empty($aktivitas->sarana) && !empty($aktivitas->sarana->nama) ? $aktivitas->sarana->nama : 'Peminjaman' }}
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500">
                                    @if($aktivitas->status == 'diajukanbatal')
                                        Pengajuan Pembatalan
                                    @else
                                        {{ ucfirst($aktivitas->status) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <span class="text-sm text-gray-400">{{ $aktivitas->created_at->diffForHumans() }}</span>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <i class="fas fa-book text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">Belum ada aktivitas</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection