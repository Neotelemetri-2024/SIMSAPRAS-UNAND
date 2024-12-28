@extends('layouts.user')

@section('content')
<section class="bg-gray-50 pt-32 min-h-screen">
    <div class="max-w-screen-xl px-4 mx-auto lg:px-6">
        <!-- Header Section -->
   <!-- Header Section -->
<div class="mb-8 text-center ">
    <h2 class="text-3xl font-bold text-gray-900">
        Daftar Sarana & Prasarana
    </h2>
    <p class="mt-2 text-gray-600">
        Temukan dan pinjam berbagai fasilitas yang tersedia di Universitas Andalas
    </p>
</div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <form action="{{ route('user.sarana') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Pencarian</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ $search ?? '' }}" 
                               placeholder="Cari berdasarkan nama atau deskripsi..."
                               class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="sm:w-48">
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Kategori</label>
                    <select name="kategori" class="w-full py-2.5 px-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ $filterKategori == $kat->id ? 'selected' : '' }}>
                                {{ $kat->jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:w-32 self-end">
                    <button type="submit" class="w-full h-[42px] text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 transition-colors duration-200">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Content Grid with Sidebar -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($sarana as $item)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <div class="aspect-video relative">
                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                 alt="{{ $item->nama }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute top-3 right-3">
                                <span class="px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded-full">
                                    {{ $item->kategoriSarana->jenis }}
                                </span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $item->nama }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $item->deskripsi }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    Kapasitas: {{ $item->kapasitas ?? 'Tidak tersedia' }}
                                </div>
                                <a href="{{ route('user.sarana.show', $item) }}" 
                                   class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-700">
                                    Lihat Detail
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <p class="mt-2 text-gray-500">Tidak ada sarana yang ditemukan</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $sarana->links() }}
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3 space-y-6">
            @if($pengumuman->count() > 0)
<div class="bg-white rounded-xl shadow-sm p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-gray-900 mb-4">Pengumuman Terkini</h3>
        <a href="{{ route('pengumuman.user') }}" class="text-sm text-green-600 hover:text-green-700">
            Lihat Semua 
            <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
    <div class="space-y-4">
        @foreach($pengumuman->take(3) as $item)
        <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition duration-200 cursor-pointer" onclick="openPengumumanModal('{{ $item->id }}')">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0 pr-4">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $item->judul }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ Str::limit(strip_tags($item->isi), 100) }}
                    </p>
                </div>
                <div>
                    <span class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Detail Pengumuman Modal (sama seperti sebelumnya) -->
@foreach($pengumuman->take(3) as $item)
<div id="pengumumanModal{{ $item->id }}" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden">
    <!-- Backdrop with higher z-index -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    
    <!-- Modal content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-2xl">
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ $item->judul }}
                    </h3>
                    <button type="button" onclick="closePengumumanModal('{{ $item->id }}')"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <div class="text-sm text-gray-600">
                        <p class="mb-2 text-xs text-gray-500">
                            Dipublikasikan pada: {{ $item->created_at->translatedFormat('d F Y H:i') }}
                        </p>
                        {!! $item->isi !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
                <!-- Trend Chart -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Tren Peminjaman</h3>
                    <canvas id="trendChart" height="200"></canvas>
                </div>

                <!-- Most Borrowed -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Paling Sering Dipinjam</h3>
                    <div class="space-y-4">
                        @foreach($topBorrowed as $item)
                        <div class="flex items-center gap-4">
                            <div class="h-16 w-16 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ asset('storage/' . $item->gambar) }}" 
                                     alt="{{ $item->nama }}"
                                     class="h-full w-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900 truncate">{{ $item->nama }}</h4>
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"/>
                                    </svg>
                                    <span class="text-sm text-gray-500">{{ $item->peminjaman_count }} kali dipinjam</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($trendData->pluck('month')),
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: @json($trendData->pluck('total')),
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
<script>
    function openPengumumanModal(id) {
        const modal = document.getElementById('pengumumanModal' + id);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closePengumumanModal(id) {
        const modal = document.getElementById('pengumumanModal' + id);
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modals = document.querySelectorAll('[id^="pengumumanModal"]');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    });
</script>
@endpush
@endsection