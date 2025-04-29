@extends('layouts.user')

@section('content')
    <div class="pt-24 px-4 max-w-screen-xl mx-auto min-h-screen">
        <div class="mb-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-gray-700 hover:text-green-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Panduan Pengguna</span>
                        </div>
                    </li>
                </ol>
            </nav>
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
                                <li>Peminjaman dilakukan setelah pukul 16:00 WIB (4 sore)</li>
                                <li>Peminjam berstatus Umum akan selalu dikenakan tarif sesuai SK yang berlaku</li>
                            </ul>
                            
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
            </div>
        </div>
    </div>
@endsection
