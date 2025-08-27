@extends('layouts.user')

@section('content')
    <section class="relative bg-gradient-to-br from-white to-green-50 pt-12 overflow-hidden">
        <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-green-50 to-transparent"></div>
        <div class="max-w-screen-xl px-4 py-16 mx-auto lg:py-24">
            <div class="grid lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7 space-y-8 relative">
                    <div class="space-y-4">
                        <div class="inline-flex items-center px-4 py-1.5 rounded-full border border-green-100 bg-green-50">
                            <span class="text-sm font-medium text-green-600">SIMSAPRAS UNAND</span>
                        </div>
                        <h1 class="text-4xl font-bold tracking-tight md:text-5xl lg:text-6xl text-gray-900">
                            Sistem Informasi Peminjaman
                            <span class="text-green-600 inline-block">Sarana & Prasarana</span>
                        </h1>
                        <p class="text-lg text-gray-600 leading-relaxed max-w-2xl">
                            Peminjaman Sarana & Prasarana Universitas Andalas dengan mudah dan efisien.
                            Sistem modern untuk manajemen fasilitas kampus yang lebih baik.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('user.sarana') }}"
                            class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-green-600 rounded-lg shadow-sm hover:bg-green-700 transition duration-200 group">
                            Mulai Sekarang
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-5 relative">
                    <div class="absolute inset-0 bg-green-100 rounded-2xl opacity-20 blur-2xl"></div>
                    <img src="/assets/images/unandnosky.png"
                        alt="UNAND"
                        class="relative rounded-lg shadow-lg transform hover:scale-[1.02] transition-transform duration-300">
                </div>
            </div>
        </div>
    </section>

    @if($pengumuman->count())
    <section class="py-12 bg-gradient-to-r from-yellow-50 to-orange-50 border-y border-yellow-200">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="mb-6 flex items-center gap-2">
                <div class="animate-pulse">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-4v14c-1.543-2.766-5.067-4-9.168-4H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-yellow-700">Pengumuman Terbaru</h2>
            </div>

            {{-- Carousel Container - MODIFIED --}}
            <div class="relative">
                {{-- This is the main scrolling container --}}
                <div id="pengumumanCarousel" class="grid grid-flow-col auto-cols-[90%] sm:auto-cols-[48%] md:auto-cols-[32%] gap-4 overflow-x-auto scroll-snap-type-x-mandatory scroll-smooth pb-4 -mb-4" style="-ms-overflow-style: none; scrollbar-width: none;">
                    @foreach($pengumuman->take(5) as $item)
                    {{-- Carousel Item - MODIFIED --}}
                    <div class="scroll-snap-align-start h-full">
                        <div class="bg-white border-l-4 border-yellow-400 rounded-lg p-4 shadow-md h-full flex flex-col">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 mb-1 line-clamp-2">{{ $item->judul }}</h3>
                                <p class="text-gray-600 text-sm mb-2 line-clamp-3">
                                    {{ strip_tags($item->isi) }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                <span class="text-xs text-gray-400">{{ $item->created_at->format('d M Y') }}</span>
                                <button onclick="showPengumuman('{{ addslashes($item->judul) }}', `{!! addslashes($item->isi) !!}`)"
                                        class="text-yellow-600 text-sm hover:underline font-medium">Selengkapnya →</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Navigation Buttons - MODIFIED (positioning) --}}
                @if($pengumuman->count() > 3)
                <button onclick="prevSlide()" class="absolute top-1/2 -translate-y-1/2 -left-4 bg-white/80 hover:bg-white rounded-full p-2 z-20 shadow-md transition-all duration-200 hidden md:block">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="nextSlide()" class="absolute top-1/2 -translate-y-1/2 -right-4 bg-white/80 hover:bg-white rounded-full p-2 z-20 shadow-md transition-all duration-200 hidden md:block">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                @endif
            </div>

            {{-- "View All" Button --}}
            <div class="mt-8 text-center">
                <a href="{{ route('pengumuman.index') }}" class="text-sm font-semibold text-yellow-700 hover:text-yellow-800 hover:underline transition-colors duration-200">
                    Lihat Semua Pengumuman →
                </a>
            </div>
        </div>
    </section>
    @endif


    {{-- Toast & Modal Sections (No changes here) --}}
    @if($pengumuman->count())
    <div id="pengumumanToast" class="fixed top-20 right-4 z-50 max-w-sm bg-white border-l-4 border-yellow-400 rounded-lg shadow-lg p-4 transform translate-x-full transition-transform duration-300">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-gray-900">Pengumuman Baru!</p>
                <p class="text-sm text-gray-600 mt-1">{{ $pengumuman->first()->judul }}</p>
                <div class="mt-2 flex space-x-2">
                    <button onclick="showPengumuman('{{ addslashes($pengumuman->first()->judul) }}', `{!! addslashes($pengumuman->first()->isi) !!}`)"
                            class="text-xs text-yellow-600 hover:underline">Lihat</button>
                    <button onclick="closeToast()" class="text-xs text-gray-400 hover:text-gray-600">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($pengumuman->count())
    <div id="pengumumanBanner" class="fixed top-0 left-0 right-0 z-30 bg-gradient-to-r from-yellow-400 to-orange-400 text-white py-2 transform -translate-y-full transition-transform duration-300">
        <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2L3 7v11a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V7l-7-5z"/>
                </svg>
                <span class="text-sm font-medium">{{ $pengumuman->first()->judul }}</span>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="showPengumuman('{{ addslashes($pengumuman->first()->judul) }}', `{!! addslashes($pengumuman->first()->isi) !!}`)"
                        class="text-xs bg-white/20 px-2 py-1 rounded hover:bg-white/30 transition">Lihat</button>
                <button onclick="closeBanner()" class="text-white/80 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    <div id="pengumumanModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full p-8 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closePengumuman()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <h3 id="modalJudul" class="text-2xl font-bold mb-4 text-gray-900"></h3>
            <div id="modalIsi" class="prose max-w-none text-gray-700 text-base leading-relaxed"></div>
        </div>
    </div>

    <section id="features" class="py-20 bg-white">
        <div class="max-w-screen-xl px-4 mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Utama</h2>
                <p class="text-gray-600">Nikmati kemudahan dalam peminjaman sarana dan prasarana</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group p-6 bg-white rounded-xl border border-gray-100 hover:border-green-100 transition-all duration-200 hover:shadow-lg">
                    <div class="mb-4 inline-flex items-center justify-center w-12 h-12 rounded-lg bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900">Cek Ketersediaan</h3>
                    <p class="text-gray-600 leading-relaxed">Lihat jadwal dan ketersediaan sarana secara langsung melalui kalender interaktif.</p>
                </div>

                <div class="group p-6 bg-white rounded-xl border border-gray-100 hover:border-green-100 transition-all duration-200 hover:shadow-lg">
                    <div class="mb-4 inline-flex items-center justify-center w-12 h-12 rounded-lg bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900">Peminjaman Mudah</h3>
                    <p class="text-gray-600 leading-relaxed">Ajukan peminjaman kapan saja dan di mana saja dengan proses yang sederhana.</p>
                </div>

                <div class="group p-6 bg-white rounded-xl border border-gray-100 hover:border-green-100 transition-all duration-200 hover:shadow-lg">
                    <div class="mb-4 inline-flex items-center justify-center w-12 h-12 rounded-lg bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900">Pantau Status</h3>
                    <p class="text-gray-600 leading-relaxed">Lacak status peminjaman Anda dan terima notifikasi pembaruan secara langsung.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-20 bg-gray-50">
        <div class="max-w-screen-xl px-4 mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
                <p class="text-gray-600">Proses peminjaman yang sederhana dalam tiga langkah mudah</p>
            </div>
            <div class="relative">
                <div class="hidden lg:block absolute top-1/2 left-0 right-0 h-0.5 bg-green-100 transform -translate-y-1/2"></div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="relative bg-white p-6 rounded-xl shadow-sm">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white font-semibold">1</span>
                        </div>
                        <div class="pt-4 text-center">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Login</h3>
                            <p class="text-gray-600">Masuk menggunakan akun email institusi/pribadi Anda</p>
                        </div>
                    </div>

                    <div class="relative bg-white p-6 rounded-xl shadow-sm">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white font-semibold">2</span>
                        </div>
                        <div class="pt-4 text-center">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pilih Ruangan</h3>
                            <p class="text-gray-600">Pilih ruangan yang tersedia sesuai kebutuhan</p>
                        </div>
                    </div>

                    <div class="relative bg-white p-6 rounded-xl shadow-sm">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white font-semibold">3</span>
                        </div>
                        <div class="pt-4 text-center">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi</h3>
                            <p class="text-gray-600">Terima konfirmasi dan gunakan fasilitas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pertanyaan Umum</h2>
                <p class="text-gray-600">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
            </div>
            
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between w-full px-4 py-5 sm:p-6 text-left">
                        <span class="text-base font-semibold text-gray-900">Bagaimana cara mendaftar di SIMSAPRAS?</span>
                    </div>
                    <div class="px-4 pb-5 sm:px-6 sm:pb-6">
                        <p class="text-gray-600">Pendaftaran SIMSAPRAS menggunakan akun email institusi/pribadi Anda. Ikuti proses verifikasi yang sederhana untuk mulai menggunakan sistem.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between w-full px-4 py-5 sm:p-6 text-left">
                        <span class="text-base font-semibold text-gray-900">Berapa lama proses persetujuan peminjaman?</span>
                    </div>
                    <div class="px-4 pb-5 sm:px-6 sm:pb-6">
                        <p class="text-gray-600">Proses persetujuan peminjaman membutuhkan waktu maksimal 1x24 jam kerja. Untuk keperluan mendesak, silakan hubungi admin.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between w-full px-4 py-5 sm:p-6 text-left">
                        <span class="text-base font-semibold text-gray-900">Apa saja persyaratan peminjaman ruangan?</span>
                    </div>
                    <div class="px-4 pb-5 sm:px-6 sm:pb-6">
                        <p class="text-gray-600">Persyaratan utama meliputi status aktif sebagai mahasiswa/staff Unand, surat peminjaman resmi, dan rundown kegiatan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @can('not-user')
    <section class="relative py-20 bg-gradient-to-br from-green-600 to-green-700 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.1] bg-[size:16px]"></div>
        <div class="relative max-w-screen-xl mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-white mb-4">
                    Mulai Gunakan SIMSAPRAS
                </h2>
                <p class="text-lg text-green-100 mb-8">
                    Pinjam sarana dan prasarana dengan lebih efisien melalui sistem modern kami
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-green-600 bg-white rounded-lg shadow-sm hover:bg-green-50 transition duration-200">
                        Daftar Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="#features"
                        class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white border border-white/20 rounded-lg hover:bg-white/10 transition duration-200">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endcan
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalSlides = {{ $pengumuman->count() }};
        
        if (totalSlides > 0) {
            const carousel = document.getElementById('pengumumanCarousel');
            let autoSlideInterval;

            const getScrollAmount = () => {
                // Get the first item in the carousel
                const firstItem = carousel.querySelector(':first-child');
                if (!firstItem) return 0;

                // Get the gap from the parent grid style
                const gap = parseFloat(getComputedStyle(carousel).gap) || 16;
                return firstItem.offsetWidth + gap;
            };

            window.nextSlide = () => {
                const scrollAmount = getScrollAmount();
                // If scrolling would go past the end, snap to the end
                if (carousel.scrollLeft + scrollAmount >= carousel.scrollWidth - carousel.clientWidth) {
                    carousel.scrollLeft = carousel.scrollWidth - carousel.clientWidth;
                } else {
                    carousel.scrollLeft += scrollAmount;
                }
                resetInterval();
            };

            window.prevSlide = () => {
                const scrollAmount = getScrollAmount();
                carousel.scrollLeft -= scrollAmount;
                resetInterval();
            };
            
            const autoScroll = () => {
                // If we are at the end, loop back to the beginning
                const isAtEnd = Math.ceil(carousel.scrollLeft) >= carousel.scrollWidth - carousel.clientWidth;
                if (isAtEnd) {
                    carousel.scrollLeft = 0;
                } else {
                    carousel.scrollLeft += getScrollAmount();
                }
            };
            
            const startInterval = () => {
                if (totalSlides > 1) { // Only auto-scroll if there's more than one item
                    autoSlideInterval = setInterval(autoScroll, 5000);
                }
            };
            
            const resetInterval = () => {
                clearInterval(autoSlideInterval);
                startInterval();
            };

            // Start auto-scrolling
            startInterval();
            
            // Pause auto-scrolling when the user hovers over the carousel
            carousel.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
            carousel.addEventListener('mouseleave', startInterval);
        }

        // Toast notification
        setTimeout(() => {
            const toast = document.getElementById('pengumumanToast');
            if (toast) {
                toast.classList.remove('translate-x-full');
            }
        }, 2000);

        window.closeToast = function() {
            const toast = document.getElementById('pengumumanToast');
            if (toast) {
                toast.classList.add('translate-x-full');
            }
        }

        // Banner notification
        setTimeout(() => {
            const banner = document.getElementById('pengumumanBanner');
            if (banner) {
                banner.classList.remove('-translate-y-full');
                // Auto-hide after 10 seconds
                setTimeout(() => banner.classList.add('-translate-y-full'), 10000);
            }
        }, 1000);

        window.closeBanner = function() {
            const banner = document.getElementById('pengumumanBanner');
            if (banner) {
                banner.classList.add('-translate-y-full');
            }
        }

        // Modal functions
        window.showPengumuman = function(judul, isi) {
            document.getElementById('modalJudul').textContent = judul;
            document.getElementById('modalIsi').innerHTML = isi;
            document.getElementById('pengumumanModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        window.closePengumuman = function() {
            document.getElementById('pengumumanModal').classList.add('hidden');
            document.body.style.overflow = ''; // Restore scrolling
        }
    });
    </script>
    @endpush
@endsection