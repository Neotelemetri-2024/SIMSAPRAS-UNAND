@extends('layouts.user')

@section('content')
    <!-- Hero Section with Wave Bottom -->
    <section class="relative bg-gradient-to-br from-green-50 to-blue-50 pt-12 overflow-hidden">
        <!-- Background Patterns -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%2334d399\' fill-opacity=\'0.2\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\'/%3E%3C/g%3E%3C/svg%3E')"></div>
        </div>
        
        <div class="max-w-screen-xl px-4 py-20 mx-auto lg:py-24 relative">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 space-y-8 relative">
                    <div class="space-y-4">
                        <div class="inline-flex items-center px-4 py-1.5 rounded-full border border-green-100 bg-green-50 shadow-sm">
                            <span class="text-sm font-medium text-green-600">SIMSAPRAS UNAND</span>
                        </div>
                        <h1 class="text-4xl font-bold tracking-tight md:text-5xl lg:text-6xl text-gray-900">
                            Sistem Informasi Peminjaman 
                            <span class="text-green-600 relative inline-block">
                                Sarana & Prasarana
                                <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 300 12" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 8.5C52 2.5 102 8.5 152 10.5C202 12.5 252 6.5 302 2.5" stroke="#34D399" stroke-width="3" stroke-linecap="round" fill="none"/>
                                </svg>
                            </span>
                        </h1>
                        <p class="text-lg text-gray-600 leading-relaxed max-w-2xl">
                            Peminjaman Sarana & Prasarana Universitas Andalas dengan mudah dan efisien. 
                            Sistem modern untuk manajemen fasilitas kampus yang lebih baik.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('user.sarana') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-lg hover:shadow-green-500/30 transition duration-300 transform hover:-translate-y-1 group">
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
                    <div class="absolute -inset-4 bg-gradient-to-br from-green-100 to-blue-100 rounded-2xl opacity-20 blur-3xl"></div>
                    <div class="p-2 bg-white rounded-xl shadow-xl backdrop-blur-sm transform hover:scale-[1.02] transition-all duration-300 relative">
                        <div class="absolute -top-3 -right-3 bg-green-500 text-white text-xs px-3 py-1 rounded-full shadow-lg">UNAND</div>
                        <img src="/assets/images/unandnosky.png" 
                            alt="UNAND" 
                            class="relative rounded-lg w-full">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Wave Bottom -->
        <div class="wave-bottom">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="#ffffff" opacity=".25"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="#ffffff" opacity=".5"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#ffffff"></path>
            </svg>
        </div>
    </section>

    <!-- Features Section with Cards -->
    <section id="features" class="py-20 bg-white relative">
        <div class="absolute left-0 top-1/4 w-48 h-48 bg-green-100 rounded-full opacity-20 blur-3xl -z-10"></div>
        <div class="absolute right-0 bottom-1/4 w-64 h-64 bg-blue-100 rounded-full opacity-30 blur-3xl -z-10"></div>
        
        <div class="max-w-screen-xl px-4 mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center justify-center mb-4">
                    <span class="px-3 py-1 text-xs font-medium text-green-600 rounded-full bg-green-50 border border-green-100">FITUR</span>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Utama</h2>
                <p class="text-gray-600">Nikmati kemudahan dalam peminjaman sarana dan prasarana</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group p-6 bg-white rounded-xl border border-gray-100 hover:border-green-100 transition-all duration-300 hover:shadow-xl hover:shadow-green-100/20 relative overflow-hidden">
                    <div class="absolute -right-12 -top-12 w-24 h-24 bg-green-100 rounded-full opacity-0 group-hover:opacity-40 transition-all duration-300"></div>
                    <div class="mb-4 inline-flex items-center justify-center w-12 h-12 rounded-lg bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900">Cek Ketersediaan</h3>
                    <p class="text-gray-600 leading-relaxed">Lihat jadwal dan ketersediaan sarana secara langsung melalui kalender interaktif.</p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-6 bg-white rounded-xl border border-gray-100 hover:border-green-100 transition-all duration-300 hover:shadow-xl hover:shadow-green-100/20 relative overflow-hidden">
                    <div class="absolute -right-12 -top-12 w-24 h-24 bg-green-100 rounded-full opacity-0 group-hover:opacity-40 transition-all duration-300"></div>
                    <div class="mb-4 inline-flex items-center justify-center w-12 h-12 rounded-lg bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900">Peminjaman Mudah</h3>
                    <p class="text-gray-600 leading-relaxed">Ajukan peminjaman kapan saja dan di mana saja dengan proses yang sederhana.</p>
                </div>

                <!-- Feature 3 -->
                <div class="group p-6 bg-white rounded-xl border border-gray-100 hover:border-green-100 transition-all duration-300 hover:shadow-xl hover:shadow-green-100/20 relative overflow-hidden">
                    <div class="absolute -right-12 -top-12 w-24 h-24 bg-green-100 rounded-full opacity-0 group-hover:opacity-40 transition-all duration-300"></div>
                    <div class="mb-4 inline-flex items-center justify-center w-12 h-12 rounded-lg bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors duration-300">
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
    <section id="how-it-works" class="py-20 bg-gradient-to-br from-gray-50 to-gray-100 relative overflow-hidden">
        <!-- Wave Top -->
        <div class="wave-top">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#ffffff"></path>
            </svg>
        </div>
        
        <div class="max-w-screen-xl px-4 mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center justify-center mb-4">
                    <span class="px-3 py-1 text-xs font-medium text-green-600 rounded-full bg-green-50 border border-green-100">LANGKAH</span>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
                <p class="text-gray-600">Proses peminjaman yang sederhana dalam tiga langkah mudah</p>
            </div>
            <div class="relative">
                <!-- Connection Line -->
                <div class="hidden lg:block absolute top-1/2 left-0 right-0 h-1 bg-gradient-to-r from-green-100 via-green-300 to-green-100 transform -translate-y-1/2 rounded-full"></div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="relative bg-white p-8 rounded-xl shadow-lg transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-green-600 to-green-500 text-white font-semibold shadow-lg">1</span>
                        </div>
                        <div class="pt-6 text-center">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Login</h3>
                            <p class="text-gray-600">Masuk menggunakan akun email institusi Anda</p>
                            <div class="mt-6 flex justify-center">
                                <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative bg-white p-8 rounded-xl shadow-lg transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-green-600 to-green-500 text-white font-semibold shadow-lg">2</span>
                        </div>
                        <div class="pt-6 text-center">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Pilih Ruangan</h3>
                            <p class="text-gray-600">Pilih ruangan yang tersedia sesuai kebutuhan</p>
                            <div class="mt-6 flex justify-center">
                                <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative bg-white p-8 rounded-xl shadow-lg transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-green-600 to-green-500 text-white font-semibold shadow-lg">3</span>
                        </div>
                        <div class="pt-6 text-center">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">Konfirmasi</h3>
                            <p class="text-gray-600">Terima konfirmasi dan gunakan fasilitas</p>
                            <div class="mt-6 flex justify-center">
                                <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Wave Bottom -->
        <div class="wave-bottom">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="#ffffff" opacity=".25"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="#ffffff" opacity=".5"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#ffffff"></path>
            </svg>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-white relative">
        <div class="absolute left-1/4 top-1/3 w-72 h-72 bg-blue-50 rounded-full opacity-30 blur-3xl -z-10"></div>
        
        <div class="max-w-3xl mx-auto px-4">
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center mb-4">
                    <span class="px-3 py-1 text-xs font-medium text-green-600 rounded-full bg-green-50 border border-green-100">BANTUAN</span>
                </div>
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
                    <div class="border border-gray-200 hover:border-green-100 rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 bg-white overflow-hidden group">
                        <div class="flex items-center justify-between w-full px-6 py-5 text-left cursor-pointer"
                                x-data="{ open: false }"
                                @click="open = !open">
                            <span class="text-lg font-semibold text-gray-900 group-hover:text-green-600 transition-colors">{{ $faq['question'] }}</span>
                            <svg class="w-6 h-6 text-gray-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div class="px-6 pb-5">
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
        <!-- Decorative Elements -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-black opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'white\' fill-opacity=\'0.4\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
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
                        class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-green-600 bg-white rounded-lg shadow-lg hover:shadow-white/30 transform hover:-translate-y-1 transition-all duration-300">
                        Daftar Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="#features" 
                        class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white border border-white/20 rounded-lg hover:bg-white/10 transition-all duration-300">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endcan

<style>
.wave-top {
    display: block;
    position: relative;
    top: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
}

.wave-top svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 40px;
    transform: rotateY(180deg);
}

.wave-bottom {
    display: block;
    position: relative;
    bottom: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg);
}

.wave-bottom svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 80px;
}

/* Animasi untuk hover cards */
@keyframes float {
    0% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
    100% {
        transform: translateY(0px);
    }
}

.animate-float:hover {
    animation: float 3s ease-in-out infinite;
}   
</style>

@endsection