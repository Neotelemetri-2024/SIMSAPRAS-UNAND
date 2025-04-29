@extends('layouts.user')

@section('content')
    <div class="pt-24 px-4 max-w-screen-xl mx-auto min-h-screen">
        <!-- Header Section -->
        <div class="mb-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-gray-700 hover:text-green-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('panduan.index') }}"
                                class="ml-1 text-gray-700 hover:text-green-600 md:ml-2">Panduan Pengguna</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Cara Peminjaman</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-col items-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-">Cara Peminjaman</h1>
                <p class="text-gray-600">Panduan langkah demi langkah untuk melakukan peminjaman sarana dan prasarana</p>
            </div>
        </div>

        <!-- Steps -->
        <div class="space-y-6">
            <!-- Step 1 -->
            <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">1. Persiapan Dokumen</h3>
                        <p class="text-gray-600">Siapkan dokumen yang diperlukan sebelum melakukan peminjaman</p>
                    </div>
                </div>
                <div class="ml-12">
                    <ul class="list-disc space-y-2 text-gray-600">
                        <li>Surat permohonan resmi</li>
                        <li>Rundown acara</li>
                        <li>Surat rekomendasi (jika diperlukan)</li>
                    </ul>
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Contoh Dokumen:</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Contoh Rundown -->
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Contoh Rundown Acara</span>
                                    <a href="/assets/images/panduan/rundown.png" target="_blank"
                                        class="text-blue-600
                                        hover:text-blue-700 text-sm">Lihat
                                        Full</a>
                                </div>
                                <img src="/assets/images/panduan/rundown.png" alt="Contoh Rundown Acara"
                                    class="w-full h-48 object-cover rounded-lg shadow-sm" onclick="window.open(this.src)">
                            </div>

                            <!-- Contoh Surat -->
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Contoh Surat Peminjaman</span>
                                    <a href="/assets/images/panduan/surat-peminjaman.png" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm">Lihat Full</a>
                                </div>
                                <img src="/assets/images/panduan/surat-peminjaman.png" alt="Contoh Surat Peminjaman"
                                    class="w-full h-48 object-cover rounded-lg shadow-sm" onclick="window.open(this.src)">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-blue-800 mb-1">Format Dokumen yang Diterima:</p>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>• Format file: PDF, DOC, atau DOCX</li>
                                    <li>• Ukuran maksimal file: 2MB per dokumen</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">2. Login ke Sistem</h3>
                        <p class="text-gray-600">Masuk ke SIMSAPRAS menggunakan akun Anda</p>
                    </div>
                </div>
                <div class="ml-12">
                    <!-- Point 1 -->
                    <div class="mb-8">
                        <div class="list-disc text-gray-600 mb-3">
                            <p>• Buka website SIMSAPRAS, atau klik <a href="{{ Route('login') }}"
                                    class="text-blue-600 hover:text-blue-700">disini</a></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <span class="block text-sm font-medium text-gray-700 mb-3">Halaman Utama SIMSAPRAS</span>
                            <img src="/assets/images/panduan/homepage.png" alt="Halaman Utama SIMSAPRAS"
                                class="w-full rounded-lg shadow-sm">
                        </div>
                    </div>

                    <!-- Point 2 -->
                    <div class="mb-8">
                        <div class="list-disc text-gray-600 mb-3">
                            <p>• Klik tombol "Login" di pojok kanan atas, maka akan dipindahkan ke halaman login</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <span class="block text-sm font-medium text-gray-700 mb-3">Halaman Login</span>
                            <img src="/assets/images/panduan/loginpage.png" alt="Lokasi Tombol Login"
                                class="w-full rounded-lg shadow-sm">
                        </div>
                    </div>

                    <!-- Point 3 -->
                    <div class="mb-8">
                        <div class="list-disc text-gray-600 mb-3">
                            <p>• Jika belum punya akun, silahkan mendaftarkan akun terlebih dahulu dengan mengklik
                                "Daftar Sekarang", kemudian isikan data-data yang diperlukan</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <span class="block text-sm font-medium text-gray-700 mb-3">Halaman Register</span>
                            <img src="/assets/images/panduan/registerpage.png" alt="Halaman Register"
                                class="w-full rounded-lg shadow-sm">
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="list-disc text-gray-600 mb-3">
                            <p>• Setelah menekan tombol daftar, maka akan diminta untuk melakukan verifikasi email, silahkan
                                buka email anda dan periksa email masuk. Jika tidak ada email masuk, pastikan untuk
                                memeriksa folder <span class="font-semibold">Spam/Junk</span></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <span class="block text-sm font-medium text-gray-700 mb-3">Tampilan Verifikasi</span>
                            <img src="/assets/images/panduan/verifikasi.png" alt="Verifikasi"
                                class="w-full rounded-lg shadow-sm">
                        </div>
                    </div>


                    <!-- Point 4 & 5 -->
                    <div class="mb-8">
                        <div class="list-disc text-gray-600 mb-3">
                            <p>• Login dengan menggunakan email dan password</p>
                            <p>• Klik tombol "Log In", jika data login benar, maka akan diarahkan kembali ke halaman home
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <span class="block text-sm font-medium text-gray-700 mb-3">Halaman Login</span>
                            <img src="/assets/images/panduan/loginhomepage.png" alt="Halaman awal"
                                class="w-full rounded-lg shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">3. Pilih Sarana</h3>
                        <p class="text-gray-600">Pilih sarana yang ingin dipinjam dan cek ketersediaan</p>
                    </div>
                </div>
                <div class="ml-12">
                    <ul class="list-disc space-y-2 text-gray-600">
                        <li>Klik menu "Peminjaman"</li>
                        <li>Pilih kategori sarana</li>
                        <li>Cek ketersediaan pada tanggal yang diinginkan</li>
                        <li>Klik "Ajukan Peminjaman"</li>
                    </ul>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">4. Isi Form Peminjaman</h3>
                        <p class="text-gray-600">Lengkapi formulir peminjaman dengan data yang benar</p>
                    </div>
                </div>
                <div class="ml-12">
                    <ul class="list-disc space-y-2 text-gray-600">
                        <li>Isi tanggal peminjaman</li>
                        <li>Isi detail kegiatan</li>
                        <li>Upload dokumen yang diperlukan</li>
                        <li>Periksa kembali semua data</li>
                    </ul>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">5. Submit & Tracking</h3>
                        <p class="text-gray-600">Kirim pengajuan dan pantau status peminjaman</p>
                    </div>
                </div>
                <div class="ml-12">
                    <ul class="list-disc space-y-2 text-gray-600">
                        <li>Klik tombol "Submit"</li>
                        <li>Catat nomor peminjaman</li>
                        <li>Pantau status di menu "Riwayat"</li>
                        <li>Tunggu persetujuan admin</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="mt-8 p-6 bg-green-50 rounded-lg border border-green-200">
            <h3 class="text-lg font-semibold text-green-800 mb-4">Tips Peminjaman</h3>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <svg class="w-4 h-4 mt-1 mr-3 flex-shrink-0 text-green-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-green-700">Ajukan peminjaman maksimal 5 hari sebelum penggunaan untuk memastikan
                        proses berjalan lancar.</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 mt-1 mr-3 flex-shrink-0 text-green-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-green-700">Pastikan semua dokumen yang diperlukan sudah lengkap sebelum mengajukan
                        peminjaman.</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 mt-1 mr-3 flex-shrink-0 text-green-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-green-700">Periksa kembali semua informasi sebelum submit untuk menghindari
                        penolakan.</span>
                </li>
            </ul>
        </div>
    </div>
@endsection
