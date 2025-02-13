@extends('layouts.user')

@section('content')
    <!-- Hero Section -->
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

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-screen-xl px-4 mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Utama</h2>
                <p class="text-gray-600">Nikmati kemudahan dalam peminjaman sarana dan prasarana</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group p-6 bg-white rounded-xl border border-gray-100 hover:border-green-100 transition-all duration-200 hover:shadow-lg">
                    <div class="mb-4 inline-flex items-center justify-center w-12 h-12 rounded-lg bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900">Cek Ketersediaan</h3>
                    <p class="text-gray-600 leading-relaxed">Lihat jadwal dan ketersediaan sarana secara langsung melalui kalender interaktif.</p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-6 bg-white rounded-xl border border-gray-100 hover:border-green-100 transition-all duration-200 hover:shadow-lg">
                    <div class="mb-4 inline-flex items-center justify-center w-12 h-12 rounded-lg bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900">Peminjaman Mudah</h3>
                    <p class="text-gray-600 leading-relaxed">Ajukan peminjaman kapan saja dan di mana saja dengan proses yang sederhana.</p>
                </div>

                <!-- Feature 3 -->
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

    <!-- How It Works -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-screen-xl px-4 mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
                <p class="text-gray-600">Proses peminjaman yang sederhana dalam tiga langkah mudah</p>
            </div>
            <div class="relative">
                <!-- Connection Line -->
                <div class="hidden lg:block absolute top-1/2 left-0 right-0 h-0.5 bg-green-100 transform -translate-y-1/2"></div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="relative bg-white p-6 rounded-xl shadow-sm">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white font-semibold">1</span>
                        </div>
                        <div class="pt-4 text-center">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Login</h3>
                            <p class="text-gray-600">Masuk menggunakan akun email institusi Anda</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative bg-white p-6 rounded-xl shadow-sm">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white font-semibold">2</span>
                        </div>
                        <div class="pt-4 text-center">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pilih Ruangan</h3>
                            <p class="text-gray-600">Pilih ruangan yang tersedia sesuai kebutuhan</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
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

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pertanyaan Umum</h2>
                <p class="text-gray-600">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
            </div>
            
            <div class="space-y-4">
                <!-- FAQ Items using Blade Each -->
                @foreach ([
                    [
                        'id' => 1,
                        'question' => 'Bagaimana cara mendaftar di SIMSAPRAS?',
                        'answer' => 'Pendaftaran SIMSAPRAS menggunakan akun email institusi Anda. Ikuti proses verifikasi yang sederhana untuk mulai menggunakan sistem.'
                    ],
                    [
                        'id' => 2,
                        'question' => 'Berapa lama proses persetujuan peminjaman?',
                        'answer' => 'Proses persetujuan peminjaman membutuhkan waktu maksimal 1x24 jam kerja. Untuk keperluan mendesak, silakan hubungi admin.'
                    ],
                    [
                        'id' => 3,
                        'question' => 'Apa saja persyaratan peminjaman ruangan?',
                        'answer' => 'Persyaratan utama meliputi status aktif sebagai mahasiswa/staff Unand, surat peminjaman resmi, dan rundown kegiatan.'
                    ]
                ] as $faq)
                    <div class="border border-gray-200 rounded-lg">
                        <div class="flex items-center justify-between w-full px-4 py-5 sm:p-6 text-left"
                                x-data="{ open: false }"
                                @click="open = !open">
                            <span class="text-base font-semibold text-gray-900">{{ $faq['question'] }}</span>
                        </div>
                        <div class="px-4 pb-5 sm:px-6 sm:pb-6">
                            <p class="text-gray-600">{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
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
                    <a href="#" 
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

@endsection