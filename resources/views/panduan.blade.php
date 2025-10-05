@extends('layouts.user')

@section('content')
    <div class="pt-24 px-4 max-w-screen-xl mx-auto min-h-screen">
        <div class="mb-8">
            <div class="flex flex-col items-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Panduan Pengguna SIMSAPRAS</h1>
                <p class="text-gray-600">Pelajari cara menggunakan sistem peminjaman sarana dan prasarana Universitas
                    Andalas
            </div>
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-semibold text-gray-900">Cara Peminjaman</h2>
                </div>
                <p class="mb-4 text-gray-600">Pelajari langkah-langkah untuk melakukan peminjaman sarana dan prasarana.</p>
                <a href="{{ Route('panduan.cara') }}" class="inline-flex items-center text-green-600 hover:text-green-700">
                    Baca selengkapnya
                    <svg class="w-3 h-3 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>

            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-semibold text-gray-900">Syarat & Ketentuan</h2>
                </div>
                <p class="mb-4 text-gray-600">Ketahui persyaratan dan ketentuan dalam peminjaman sarana.</p>
                <a href="{{ route('panduan.syarat') }}"
                    class="inline-flex items-center text-green-600 hover:text-green-700">
                    Baca selengkapnya
                    <svg class="w-3 h-3 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>

            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-semibold text-gray-900">Status Peminjaman</h2>
                </div>
                <p class="mb-4 text-gray-600">Pahami berbagai status dalam proses peminjaman sarana.</p>
                <a href="{{ route('panduan.status') }}"
                    class="inline-flex items-center text-green-600 hover:text-green-700">
                    Baca selengkapnya
                    <svg class="w-3 h-3 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>

        </div>

        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Manual Book</h2>
            <p class="text-gray-600 mb-6">Download panduan lengkap sesuai dengan role Anda</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $user = auth()->user();
                    $manualBooks = [];

                    if (!$user) {
                        $manualBooks = [
                            [
                                'title' => 'Manual Book Peminjam',
                                'file' => 'Manual-Book-Peminjam.pdf',
                                'description' => 'Panduan lengkap untuk peminjam sarana dan prasarana'
                            ],
                            [
                                'title' => 'Manual Book User Fakultas - Unit',
                                'file' => 'Manual-Book-User-Fakultas - Unit.pdf',
                                'description' => 'Panduan untuk user fakultas dan unit'
                            ]
                        ];
                    } else {
                        switch ($user->role) {
                            case 'superadmin':
                                $manualBooks = [
                                    [
                                        'title' => 'Manual Book Super Admin',
                                        'file' => 'Manual-Book-Super-Admin.pdf',
                                        'description' => 'Panduan lengkap untuk Super Admin'
                                    ],
                                    [
                                        'title' => 'Manual Book Admin',
                                        'file' => 'Manual-Book-Admin.pdf',
                                        'description' => 'Panduan untuk Admin'
                                    ],
                                    [
                                        'title' => 'Manual Book Pimpinan',
                                        'file' => 'Manual-Book-Pimpinan.pdf',
                                        'description' => 'Panduan untuk Pimpinan'
                                    ],
                                    [
                                        'title' => 'Manual Book Peminjam',
                                        'file' => 'Manual-Book-Peminjam.pdf',
                                        'description' => 'Panduan untuk Peminjam'
                                    ],
                                    [
                                        'title' => 'Manual Book User Fakultas - Unit',
                                        'file' => 'Manual-Book-User-Fakultas - Unit.pdf',
                                        'description' => 'Panduan untuk User Fakultas dan Unit'
                                    ]
                                ];
                                break;

                            case 'admin':
                                $manualBooks = [
                                    [
                                        'title' => 'Manual Book Admin',
                                        'file' => 'Manual-Book-Admin.pdf',
                                        'description' => 'Panduan lengkap untuk Admin'
                                    ],
                                    [
                                        'title' => 'Manual Book Peminjam',
                                        'file' => 'Manual-Book-Peminjam.pdf',
                                        'description' => 'Panduan untuk Peminjam'
                                    ],
                                    [
                                        'title' => 'Manual Book User Fakultas - Unit',
                                        'file' => 'Manual-Book-User-Fakultas - Unit.pdf',
                                        'description' => 'Panduan untuk User Fakultas dan Unit'
                                    ]
                                ];
                                break;

                            case 'pimpinan':
                                $manualBooks = [
                                    [
                                        'title' => 'Manual Book Pimpinan',
                                        'file' => 'Manual-Book-Pimpinan.pdf',
                                        'description' => 'Panduan lengkap untuk Pimpinan'
                                    ],
                                    [
                                        'title' => 'Manual Book Peminjam',
                                        'file' => 'Manual-Book-Peminjam.pdf',
                                        'description' => 'Panduan untuk Peminjam'
                                    ],
                                    [
                                        'title' => 'Manual Book User Fakultas - Unit',
                                        'file' => 'Manual-Book-User-Fakultas - Unit.pdf',
                                        'description' => 'Panduan untuk User Fakultas dan Unit'
                                    ]
                                ];
                                break;

                            case 'user':
                                $manualBooks = [
                                    [
                                        'title' => 'Manual Book Peminjam',
                                        'file' => 'Manual-Book-Peminjam.pdf',
                                        'description' => 'Panduan lengkap untuk Peminjam'
                                    ],
                                    [
                                        'title' => 'Manual Book User Fakultas - Unit',
                                        'file' => 'Manual-Book-User-Fakultas - Unit.pdf',
                                        'description' => 'Panduan untuk User Fakultas dan Unit'
                                    ]
                                ];
                                break;

                            default:
                                $manualBooks = [
                                    [
                                        'title' => 'Manual Book Peminjam',
                                        'file' => 'Manual-Book-Peminjam.pdf',
                                        'description' => 'Panduan untuk Peminjam'
                                    ],
                                    [
                                        'title' => 'Manual Book User Fakultas - Unit',
                                        'file' => 'Manual-Book-User-Fakultas - Unit.pdf',
                                        'description' => 'Panduan untuk User Fakultas dan Unit'
                                    ]
                                ];
                        }
                    }
                @endphp

                @foreach($manualBooks as $manual)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                PDF
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            {{ $manual['title'] }}
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-4">
                            {{ $manual['description'] }}
                        </p>
                        
                        <div class="flex gap-2">
                            <a href="/panduan/manual-book/download/{{ $manual['file'] }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download
                            </a>
                            
                            <button onclick="previewPdf('{{ $manual['file'] }}')" 
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Pertanyaan yang Sering Diajukan</h2>
            <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white text-gray-900"
                data-inactive-classes="text-gray-500">
                <h3 id="accordion-flush-heading-1">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                        data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                        aria-controls="accordion-flush-body-1">
                        <span>Bagaimana cara melakukan peminjaman?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h3>
                <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <p class="mb-2 text-gray-500">Untuk melakukan peminjaman, ikuti langkah-langkah berikut:</p>
                        <ol class="ps-5 text-gray-500 list-decimal">
                            <li>Login ke akun Anda</li>
                            <li>Klik menu "Peminjaman"</li>
                            <li>Pilih sarana yang ingin dipinjam</li>
                            <li>Isi form peminjaman</li>
                            <li>Upload dokumen yang diperlukan</li>
                            <li>Submit pengajuan peminjaman</li>
                        </ol>
                    </div>
                </div>

                <h3 id="accordion-flush-heading-2">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                        data-accordion-target="#accordion-flush-body-2" aria-expanded="true"
                        aria-controls="accordion-flush-body-2">
                        <span>Berapa tarif yang dikenakan dalam peminjaman sarana dan prasarana di Universitas
                            Andalas?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h3>
                <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <p class="mb-2 text-gray-500">Peminjaman sarana dan prasarana di Universitas Andalas hanya akan dikenakan tarif pada kondisi sebagai berikut:</p>
                            <ul class="ps-5 text-gray-500 list-disc">
                                <li>Peminjaman dilakukan di hari Sabtu atau Minggu</li>
                                <li>Peminjaman dilakukan di tanggal merah (hari libur nasional)</li>
                                <li>Peminjaman dilakukan setelah pukul 16:00 WIB (4 sore)</li>
                                <li>Peminjam berstatus Umum akan selalu dikenakan tarif sesuai SK yang berlaku</li>
                            </ul>
                            
                            <!-- Informasi Rekening Pembayaran -->
                            @if($rekeningAktif)
                            <div class="mt-4 p-4 bg-white rounded-lg border border-blue-200">
                                <h5 class="font-semibold text-gray-900 mb-3">Informasi Rekening Pembayaran</h5>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Bank</span>
                                        <span class="font-medium">{{ $rekeningAktif->nama_bank }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Nomor Rekening</span>
                                        <span class="font-medium">{{ $rekeningAktif->nomor_rekening }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Atas Nama</span>
                                        <span class="font-medium">{{ $rekeningAktif->nama_pemilik }}</span>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <h5 class="font-semibold text-gray-900 mb-3">Informasi Rekening Pembayaran</h5>
                                <p class="text-sm text-yellow-800">Informasi rekening pembayaran sedang tidak tersedia. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                            </div>
                            @endif
                            
                            <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-100 flex items-center">
                                <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <p class="text-gray-700 font-medium">Dokumen Resmi:</p>
                                    <a class="text-blue-600 hover:text-blue-800 flex items-center" 
                                       href="/assets/SK Rektor 1124 Tarif Layanan Sarpras.pdf" target="_blank">
                                        SK Rektor No. 1124 Tentang Tarif Layanan Sarana dan Prasarana Universitas Andalas
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                    </div>
                </div>

                <h3 id="accordion-flush-heading-3">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
                        data-accordion-target="#accordion-flush-body-3" aria-expanded="true"
                        aria-controls="accordion-flush-body-3">
                        <span>Bagaimana cara melakukan pembayaran dan ke rekening mana?</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h3>
                <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        <p class="mb-4 text-gray-500">Untuk melakukan pembayaran, ikuti langkah-langkah berikut:</p>
                        <ol class="ps-5 text-gray-500 list-decimal mb-4">
                            <li>Transfer ke rekening resmi Universitas Andalas</li>
                            <li>Simpan bukti pembayaran</li>
                            <li>Upload bukti pembayaran melalui sistem</li>
                            <li>Tunggu konfirmasi dari admin</li>
                        </ol>
                        
                        @if($rekeningAktif)
                        <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
                            <h5 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Informasi Rekening Pembayaran
                            </h5>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Bank:</span>
                                    <span class="font-medium text-gray-900">{{ $rekeningAktif->nama_bank }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Nomor Rekening:</span>
                                    <span class="font-medium text-gray-900">{{ $rekeningAktif->nomor_rekening }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Atas Nama:</span>
                                    <span class="font-medium text-gray-900">{{ $rekeningAktif->nama_pemilik }}</span>
                                </div>
                            </div>
                        @else
                        <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <h5 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Informasi Rekening Pembayaran
                            </h5>
                            <p class="text-sm text-yellow-800">Informasi rekening pembayaran sedang tidak tersedia. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                        @endif
                            <div class="mt-3 p-3 bg-yellow-50 rounded border border-yellow-200">
                                <p class="text-sm text-yellow-800">
                                    <strong>Catatan:</strong> Pastikan transfer dilakukan ke rekening resmi di atas. Pembayaran harus diselesaikan dalam waktu 3 hari setelah peminjaman disetujui.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview PDF -->
    <div id="pdfModal" class="fixed inset-0 z-50 hidden overflow-hidden bg-black bg-opacity-50">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-6xl bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Preview Manual Book</h3>
                    <button onclick="closePdfModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <div id="pdfLoading" class="hidden flex items-center justify-center h-96">
                        <div class="text-center">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                            <p class="text-gray-600">Memuat PDF...</p>
                        </div>
                    </div>
                    <iframe id="pdfViewer" src="" width="100%" height="600px" class="border-0 hidden" onload="hideLoading()" onerror="showError()"></iframe>
                    <div id="pdfError" class="hidden flex items-center justify-center h-96">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <p class="text-gray-600 mb-4">Gagal memuat PDF. Browser Anda mungkin tidak mendukung preview PDF inline.</p>
                            <div class="space-y-2">
                                <button onclick="downloadCurrentPdf()" class="block w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                    Download PDF
                                </button>
                                <button onclick="closePdfModal()" class="block w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let currentPdfFilename = '';

    function previewPdf(filename) {
        currentPdfFilename = filename;
        const pdfUrl = `/panduan/manual-book/download/${filename}?preview=1`;
        const pdfJsUrl = `https://mozilla.github.io/pdf.js/web/viewer.html?file=${encodeURIComponent(window.location.origin + pdfUrl)}`;
        
        // Show loading
        document.getElementById('pdfLoading').classList.remove('hidden');
        document.getElementById('pdfViewer').classList.add('hidden');
        document.getElementById('pdfError').classList.add('hidden');
        
        document.getElementById('pdfModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Set timeout for error handling
        setTimeout(() => {
            if (document.getElementById('pdfViewer').classList.contains('hidden')) {
                showError();
            }
        }, 10000);
        
        // Try PDF.js first, fallback to direct PDF
        document.getElementById('pdfViewer').src = pdfJsUrl;
    }

    function downloadCurrentPdf() {
        if (currentPdfFilename) {
            window.open(`/panduan/manual-book/download/${currentPdfFilename}`, '_blank');
        }
    }

    function hideLoading() {
        document.getElementById('pdfLoading').classList.add('hidden');
        document.getElementById('pdfViewer').classList.remove('hidden');
    }

    function showError() {
        document.getElementById('pdfLoading').classList.add('hidden');
        document.getElementById('pdfViewer').classList.add('hidden');
        document.getElementById('pdfError').classList.remove('hidden');
    }

    function closePdfModal() {
        document.getElementById('pdfModal').classList.add('hidden');
        document.getElementById('pdfViewer').src = '';
        document.getElementById('pdfLoading').classList.add('hidden');
        document.getElementById('pdfViewer').classList.add('hidden');
        document.getElementById('pdfError').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close modal when clicking outside
    document.getElementById('pdfModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePdfModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePdfModal();
        }
    });
    </script>
@endsection

