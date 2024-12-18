@extends('layouts.user')

@section('content')
<section class="bg-white pt-24 pb-12">
    <div class="max-w-screen-xl mx-auto px-4 lg:px-6">
        <!-- Carousel Image Section -->
        <div class="mb-8 relative">
<div id="carousel" class="relative">
    <!-- Main Image -->
    <div class="relative h-[400px] overflow-hidden rounded-xl">
        @foreach($sarana->gambarSarana as $index => $gambar)
        <div class="carousel-item absolute w-full h-full transition-opacity duration-500 
            {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
            style="display: {{ $index === 0 ? 'block' : 'none' }}">
            <img src="{{ asset('storage/' . $gambar->gambar) }}" 
                 alt="{{ $sarana->nama }}" 
                 class="w-full h-full object-cover">
        </div>
        @endforeach
    </div>
    
    <!-- Navigation Buttons -->
    <button onclick="moveSlide(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    <button onclick="moveSlide(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <!-- Indicators -->
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
        @foreach($sarana->gambarSarana as $index => $gambar)
        <button onclick="goToSlide({{ $index }})" 
                class="w-3 h-3 rounded-full transition-colors duration-300
                {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}">
        </button>
        @endforeach
    </div>
</div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <h1 class="text-4xl font-bold mb-4">{{ $sarana->nama }}</h1>
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Deskripsi</h2>
                    <p class="text-gray-600 mb-6">{{ $sarana->deskripsi }}</p>
                    
                    <h2 class="text-2xl font-semibold mb-4">Fasilitas</h2>
                    <p class="text-gray-600">{{ $sarana->fasilitas }}</p>
                </div>

                @if($sarana->kategoriSarana->jenis === 'Gedung Beruangan')
                    <!-- Ruangan Section -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-semibold">Daftar Ruangan</h2>
                            
                            <!-- Search Form -->
                            <form action="{{ route('user.sarana.show', $sarana) }}" method="GET" class="flex">
                                <input type="text" name="search" value="{{ $search }}" 
                                       placeholder="Cari ruangan..." 
                                       class="px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-green-300 focus:outline-none">
                                <button type="submit" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-r-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300">
                                    Cari
                                </button>
                            </form>
                        </div>

                        <!-- Ruangan Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($ruangan as $room)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h3 class="text-xl font-semibold mb-2">{{ $room->nama }}</h3>
                                <p class="text-gray-600 mb-4">{{ $room->deskripsi }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Kapasitas: {{ $room->kapasitas }} orang</span>
                                    <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-2 text-center py-8">
                                <p class="text-gray-500">Tidak ada ruangan yang ditemukan.</p>
                            </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $ruangan->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <a href="#" class="inline-flex items-center px-6 py-3 text-lg font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300">
                            Ajukan Peminjaman
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">Informasi Penjaga</h2>
                        @forelse($sarana->penjaga as $penjaga)
                        <div class="mb-4 pb-4 border-b border-gray-200 last:border-0 last:pb-0 last:mb-0">
                            <h3 class="font-medium mb-2">{{ $penjaga->nama }}</h3>
                            <p class="text-gray-600 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                                {{ $penjaga->kontak }}
                            </p>
                        </div>
                        @empty
                        <p class="text-gray-500">Tidak ada informasi penjaga</p>
                        @endforelse
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">Jam Operasional</h2>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Senin - Jumat</span>
                                <span class="font-medium">08:00 - 16:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sabtu</span>
                                <span class="font-medium">08:00 - 12:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Minggu</span>
                                <span class="font-medium text-red-500">Tutup</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentSlide = 0;
    let autoplayInterval = null; // Pindah deklarasi ke sini
    const slides = document.querySelectorAll('.carousel-item');
    const indicators = document.querySelectorAll('.bottom-4 button');
    
    if (!slides.length) return;

    function showSlide(n) {
        currentSlide = n;
        
        slides.forEach((slide, index) => {
            if (index === n) {
                slide.style.opacity = '1';
                slide.style.display = 'block';
            } else {
                slide.style.opacity = '0';
                slide.style.display = 'none';
            }
        });
        
        indicators.forEach((indicator, index) => {
            if (index === n) {
                indicator.classList.add('bg-white');
                indicator.classList.remove('bg-white/50');
            } else {
                indicator.classList.remove('bg-white');
                indicator.classList.add('bg-white/50');
            }
        });
    }

    function moveSlide(direction) {
        let newSlide = (currentSlide + direction + slides.length) % slides.length;
        showSlide(newSlide);
    }

    function startAutoplay() {
        // Clear any existing interval first
        if (autoplayInterval) clearInterval(autoplayInterval);
        
        autoplayInterval = setInterval(() => {
            moveSlide(1);
        }, 5000);
    }

    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    }

    // Expose functions globally
    window.moveSlide = moveSlide;
    window.goToSlide = showSlide;

    // Initialize carousel
    showSlide(0);
    startAutoplay();

    // Handle hover
    const carousel = document.getElementById('carousel');
    if (carousel) {
        carousel.addEventListener('mouseenter', stopAutoplay);
        carousel.addEventListener('mouseleave', startAutoplay);
    }

    // Clean up on page leave
    window.addEventListener('beforeunload', stopAutoplay);
});
</script>
@endpush

@endsection