@extends('layouts.user')

@section('content')
<section class="bg-white pt-24 min-h-screen">
    <div class="max-w-screen-xl px-4 mx-auto lg:px-8">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-3">
                Daftar Sarana & Prasarana
            </h2>
            <p class="text-gray-600 text-lg">
                Temukan dan pinjam berbagai fasilitas yang tersedia di Universitas Andalas
            </p>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-12 border border-gray-100">
            <form action="{{ route('user.sarana') }}" method="GET" class="flex flex-col sm:flex-row gap-6">
                <div class="flex-1">
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Pencarian</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ $search ?? '' }}" 
                               placeholder="Cari berdasarkan nama atau deskripsi..."
                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="sm:w-48">
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Kategori</label>
                    <select name="kategori" class="w-full py-3 px-4 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ $filterKategori == $kat->id ? 'selected' : '' }}>
                                {{ $kat->jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:w-32 self-end">
                    <button type="submit" class="w-full h-12 text-white bg-green-500 hover:bg-green-600 font-medium rounded-xl text-sm px-6 transition-all duration-200 shadow-sm hover:shadow-md">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Content Grid with Sidebar -->
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($sarana as $item)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="aspect-video relative">
                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                 alt="{{ $item->nama }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute top-4 right-4">
                                <span class="px-4 py-1.5 text-xs font-semibold text-white bg-green-500 rounded-full shadow-sm">
                                    {{ $item->kategoriSarana->jenis }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-xl text-gray-900 mb-3">{{ $item->nama }}</h3>
                            <p class="text-gray-600 text-sm mb-6 line-clamp-2">{{ $item->deskripsi }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    Kapasitas: {{ $item->kapasitas ?? 'Tidak tersedia' }} orang
                                </div>
                                <a href="{{ route('user.sarana.show', $item) }}" 
                                   class="inline-flex items-center text-sm font-medium text-green-500 hover:text-green-600 transition-colors duration-200">
                                    Lihat Detail
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 py-16 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <p class="mt-4 text-gray-500 text-lg">Tidak ada sarana yang ditemukan</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $sarana->links() }}
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3 space-y-8">
                <!-- Pengumuman Section -->
                @if($pengumuman->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-xl text-gray-900">Pengumuman</h3>
                        <a href="{{ route('pengumuman.user') }}" class="text-sm text-green-500 hover:text-green-600 transition-colors duration-200">
                            Lihat Semua 
                            <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-4">
                        @foreach($pengumuman->take(3) as $item)
                        <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-all duration-200 cursor-pointer border border-gray-100" 
                             onclick="openPengumumanModal('{{ $item->id }}')">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0 pr-4">
                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $item->judul }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-2">
                                        {{ Str::limit(strip_tags($item->isi), 100) }}
                                    </p>
                                </div>
                                <span class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Tren Peminjaman</h3>
                    <canvas id="trendChart" height="200"></canvas>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Paling Sering Dipinjam</h3>
                    <div class="space-y-4">
                        @foreach($topBorrowed as $item)
                        <div class="flex items-center gap-4">
                            <div class="h-20 w-20 rounded-xl overflow-hidden flex-shrink-0 shadow-sm">
                                <img src="{{ asset('storage/' . $item->gambar) }}" 
                                     alt="{{ $item->nama }}"
                                     class="h-full w-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-lg text-gray-900 truncate">{{ $item->nama }}</h4>
                                <div class="flex items-center mt-2">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
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


@foreach($pengumuman->take(3) as $item)
<div id="pengumumanModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-2xl">
            <div class="relative bg-white rounded-2xl shadow-lg" data-modal-content>
                <div class="flex items-center justify-between p-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ $item->judul }}
                    </h3>
                    <button type="button" onclick="closePengumumanModal('{{ $item->id }}')"
                        class="text-gray-400 hover:bg-gray-100 hover:text-gray-900 rounded-lg p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <p class="mb-4 text-sm text-gray-500">
                        Dipublikasikan pada: {{ $item->created_at->translatedFormat('d F Y H:i') }}
                    </p>
                    <div class="prose max-w-none">
                        {!! $item->isi !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

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

// Close modal when pressing Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const visibleModals = document.querySelectorAll('[id^="pengumumanModal"]:not(.hidden)');
        visibleModals.forEach(modal => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
    }
});

// Close modal when clicking outside
document.addEventListener('mousedown', function(event) {
    const modals = document.querySelectorAll('[id^="pengumumanModal"]:not(.hidden)');
    modals.forEach(modal => {
        // Get the modal content element using data attribute
        const modalContent = modal.querySelector('[data-modal-content]');
        
        if (modalContent && !modalContent.contains(event.target)) {
            const id = modal.id.replace('pengumumanModal', '');
            closePengumumanModal(id);
        }
    });
});

</script>
@endpush
@endsection