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
    <section class="py-12 bg-white border-t border-gray-100">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Informasi Terbaru</h2>
                <p class="text-gray-600 text-sm">Pantau pengumuman dan informasi penting dari SIMSAPRAS</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($pengumuman->take(3) as $item)
                <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-500">{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                    <h3 class="font-medium text-gray-900 mb-2 line-clamp-2 text-sm">{{ $item->judul }}</h3>
                    <p class="text-gray-600 text-xs mb-3 line-clamp-2">
                        {{ strip_tags($item->isi) }}
                    </p>
                    <button onclick="showPengumuman('{{ addslashes($item->judul) }}', `{!! addslashes($item->isi) !!}`)"
                            class="text-green-600 text-xs hover:text-green-700 font-medium">Baca selengkapnya →</button>
                </div>
                @endforeach
            </div>
            
            @if($pengumuman->count() > 3)
            <div class="text-center mt-6">
                <a href="{{ route('pengumuman.user') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                    Lihat semua pengumuman →
                </a>
            </div>
            @endif
        </div>
    </section>
    @endif


    {{-- Toast & Modal Sections - Minimalis --}}
    @if($pengumuman->count())
    <div id="pengumumanToast" class="fixed top-20 right-4 z-50 max-w-md bg-white border border-gray-200 rounded-lg shadow-lg p-4 transform translate-x-full transition-transform duration-300">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-green-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-gray-900">Informasi Baru</p>
                <p class="text-sm text-gray-600 mt-1">{{ $pengumuman->first()->judul }}</p>
                <div class="mt-3 flex space-x-3">
                    <button onclick="showPengumuman('{{ addslashes($pengumuman->first()->judul) }}', `{!! addslashes($pengumuman->first()->isi) !!}`)"
                            class="text-sm text-green-600 hover:underline font-medium">Lihat</button>
                    <button onclick="closeToast()" class="text-sm text-gray-400 hover:text-gray-600">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($pengumuman->count())
    <div id="pengumumanBanner" class="fixed top-0 left-0 right-0 z-30 bg-green-50 border-b border-green-200 text-gray-800 py-2 transform -translate-y-full transition-transform duration-300">
        <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">{{ $pengumuman->first()->judul }}</span>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="showPengumuman('{{ addslashes($pengumuman->first()->judul) }}', `{!! addslashes($pengumuman->first()->isi) !!}`)"
                        class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200 transition">Lihat</button>
                <button onclick="closeBanner()" class="text-gray-500 hover:text-gray-700">
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

    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-screen-xl px-4 mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Fitur Utama</h2>
                <p class="text-gray-600 text-sm">Nikmati kemudahan dalam peminjaman sarana dan prasarana</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-white rounded-lg shadow-sm">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-green-50 text-green-600 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">Cek Ketersediaan</h3>
                    <p class="text-gray-600 text-sm">Lihat jadwal dan ketersediaan sarana secara langsung</p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow-sm">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-green-50 text-green-600 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">Peminjaman Mudah</h3>
                    <p class="text-gray-600 text-sm">Ajukan peminjaman kapan saja dengan proses sederhana</p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow-sm">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-green-50 text-green-600 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">Pantau Status</h3>
                    <p class="text-gray-600 text-sm">Lacak status peminjaman dan terima notifikasi</p>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-16 bg-white">
        <div class="max-w-screen-xl px-4 mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Cara Kerja</h2>
                <p class="text-gray-600 text-sm">Proses peminjaman yang sederhana dalam tiga langkah mudah</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white font-semibold mb-3">1</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Login</h3>
                    <p class="text-gray-600 text-sm">Masuk menggunakan akun email institusi/pribadi Anda</p>
                </div>

                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white font-semibold mb-3">2</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Pilih Ruangan</h3>
                    <p class="text-gray-600 text-sm">Pilih ruangan yang tersedia sesuai kebutuhan</p>
                </div>

                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white font-semibold mb-3">3</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi</h3>
                    <p class="text-gray-600 text-sm">Terima konfirmasi dan gunakan fasilitas</p>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-16 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Pertanyaan Umum</h2>
                <p class="text-gray-600 text-sm">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
            </div>
            
            <div class="space-y-3">
                <div class="border border-gray-200 rounded-lg">
                    <button onclick="toggleFAQ(1)" class="flex items-center justify-between w-full px-4 py-4 text-left hover:bg-gray-50 transition-colors">
                        <span class="text-sm font-semibold text-gray-900">Bagaimana cara mendaftar di SIMSAPRAS?</span>
                        <svg id="icon-1" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="answer-1" class="hidden px-4 pb-4">
                        <p class="text-sm text-gray-600">Pendaftaran SIMSAPRAS menggunakan akun email institusi/pribadi Anda. Ikuti proses verifikasi yang sederhana untuk mulai menggunakan sistem.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg">
                    <button onclick="toggleFAQ(2)" class="flex items-center justify-between w-full px-4 py-4 text-left hover:bg-gray-50 transition-colors">
                        <span class="text-sm font-semibold text-gray-900">Berapa lama proses persetujuan peminjaman?</span>
                        <svg id="icon-2" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="answer-2" class="hidden px-4 pb-4">
                        <p class="text-sm text-gray-600">Proses persetujuan peminjaman membutuhkan waktu maksimal 1x24 jam kerja. Untuk keperluan mendesak, silakan hubungi admin.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg">
                    <button onclick="toggleFAQ(3)" class="flex items-center justify-between w-full px-4 py-4 text-left hover:bg-gray-50 transition-colors">
                        <span class="text-sm font-semibold text-gray-900">Apa saja persyaratan peminjaman ruangan?</span>
                        <svg id="icon-3" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="answer-3" class="hidden px-4 pb-4">
                        <p class="text-sm text-gray-600">Persyaratan utama meliputi status aktif sebagai mahasiswa/staff Unand, surat peminjaman resmi, dan rundown kegiatan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @can('not-user')
    <section class="py-16 bg-green-600">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="text-2xl font-bold text-white mb-3">
                    Mulai Gunakan SIMSAPRAS
                </h2>
                <p class="text-green-100 mb-6 text-sm">
                    Pinjam sarana dan prasarana dengan lebih efisien melalui sistem modern kami
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-green-600 bg-white rounded-lg hover:bg-green-50 transition duration-200">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('panduan.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white border border-white/20 rounded-lg hover:bg-white/10 transition duration-200">
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

        // FAQ Toggle function
        window.toggleFAQ = function(id) {
            const answer = document.getElementById('answer-' + id);
            const icon = document.getElementById('icon-' + id);
            
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
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