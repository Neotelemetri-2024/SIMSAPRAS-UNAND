@extends('layouts.user')

@section('content')
      <section class="bg-white pt-24">
         <div class="grid max-w-screen-2xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
               <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl">
                  Sistem Informasi Peminjaman <span class="text-green-600 block">Sarana & Prasarana</span>
               </h1>
               <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl">
                  Kelola peminjaman Sarana & Prasarana Universitas Andalas dengan mudah dan efisien. Sistem modern untuk manajemen fasilitas kampus yang lebih baik.
               </p>
               <a href="#" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300">
                  Mulai Sekarang
                  <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                  </svg>
               </a>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
               <img src="/assets/images/unandnosky.png" alt="mockup" >
            </div>
         </div>
      </section>
      <!-- Features Section -->
      <section id="features" class="bg-gray-50 py-24">
         <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">
            <h2 class="mb-8 text-3xl font-extrabold tracking-tight leading-tight text-center text-gray-900 lg:mb-16">
               Fitur Utama
            </h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
               <!-- Feature 1 -->
               <div class="p-6 bg-white rounded-lg shadow-md">
                  <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12">
                     <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zM8 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1H9a1 1 0 01-1-1V4zM15 3a1 1 0 00-1 1v12a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-2z"></path>
                     </svg>
                  </div>
                  <h3 class="mb-2 text-xl font-bold">Transparansi Peminjaman</h3>
                  <p class="text-gray-500">Lihat status ketersediaan secara real-time.</p>
               </div>
               <!-- Feature 2 -->
               <div class="p-6 bg-white rounded-lg shadow-md">
                  <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12">
                     <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"></path>
                     </svg>
                  </div>
                  <h3 class="mb-2 text-xl font-bold">Peminjaman Online</h3>
                  <p class="text-gray-500">Ajukan peminjaman ruangan secara online dengan proses yang cepat dan mudah.</p>
               </div>
               <!-- Feature 3 -->
               <div class="p-6 bg-white rounded-lg shadow-md">
                  <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-green-100 lg:h-12 lg:w-12">
                     <svg class="w-5 h-5 text-green-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                     </svg>
                  </div>
                  <h3 class="mb-2 text-xl font-bold">Laporan & Statistik</h3>
                  <p class="text-gray-500">Dapatkan laporan penggunaan ruangan dan statistik peminjaman secara detail.</p>
               </div>
            </div>
         </div>
      </section>
      <!-- How It Works Section -->
      <section id="how-it-works" class="bg-white py-24">
         <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">
            <h2 class="mb-8 text-3xl font-extrabold tracking-tight leading-tight text-center text-gray-900">
               Cara Kerja
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
               <div class="text-center">
                  <div class="flex justify-center mb-4">
                     <span class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600 text-xl font-bold">1</span>
                  </div>
                  <h3 class="mb-2 text-xl font-bold">Login</h3>
                  <p class="text-gray-500">Masuk menggunakan akun Universitas Andalas Anda</p>
               </div>
               <div class="text-center">
                  <div class="flex justify-center mb-4">
                     <span class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600 text-xl font-bold">2</span>
                  </div>
                  <h3 class="mb-2 text-xl font-bold">Pilih Ruangan</h3>
                  <p class="text-gray-500">Cari dan pilih ruangan yang tersedia sesuai kebutuhan</p>
               </div>
               <div class="text-center">
                  <div class="flex justify-center mb-4">
                     <span class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600 text-xl font-bold">3</span>
                  </div>
                  <h3 class="mb-2 text-xl font-bold">Konfirmasi</h3>
                  <p class="text-gray-500">Terima konfirmasi dan gunakan ruangan sesuai jadwal</p>
               </div>
            </div>
         </div>
      </section>
      <!-- CTA Section -->
      <section class="bg-green-600">
         <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16 lg:px-6">
            <div class="max-w-screen-sm mx-auto text-center">
               <h2 class="mb-4 text-3xl font-extrabold leading-tight text-white">
                  Mulai Gunakan SIMSAPRAS
               </h2>
               <p class="mb-6 font-light text-green-100">
                  Pinjam sarana dan prasarana dengan lebih efisien
               </p>
               <a href="#" class="text-green-600 bg-white hover:bg-green-50 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">
               Daftar Sekarang
               </a>
            </div>
         </div>
      </section>
      <!-- Stats Section -->
      <section class="bg-white py-24">
         <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">
            <div class="grid grid-cols-2 gap-8 text-gray-500 sm:gap-12 md:grid-cols-3 lg:grid-cols-4">
               <div class="flex flex-col items-center justify-center">
                  <dt class="mb-2 text-3xl font-extrabold text-green-600">100+</dt>
                  <dd class="text-gray-500 text-center">Ruangan Tersedia</dd>
               </div>
               <div class="flex flex-col items-center justify-center">
                  <dt class="mb-2 text-3xl font-extrabold text-green-600">1000+</dt>
                  <dd class="text-gray-500 text-center">Peminjaman/Bulan</dd>
               </div>
               <div class="flex flex-col items-center justify-center">
                  <dt class="mb-2 text-3xl font-extrabold text-green-600">24/7</dt>
                  <dd class="text-gray-500 text-center">Layanan Online</dd>
               </div>
               <div class="flex flex-col items-center justify-center">
                  <dt class="mb-2 text-3xl font-extrabold text-green-600">99%</dt>
                  <dd class="text-gray-500 text-center">Tingkat Kepuasan</dd>
               </div>
            </div>
         </div>
      </section>
      <!-- FAQ Section -->
      <section class="bg-gray-50 py-24">
         <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">
            <h2 class="mb-8 text-3xl font-extrabold tracking-tight leading-tight text-center text-gray-900">
               Pertanyaan yang Sering Diajukan
            </h2>
            <div class="max-w-screen-md mx-auto">
               <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white text-gray-900" data-inactive-classes="text-gray-500">
                  <!-- FAQ Item 1 -->
                  <h2 id="accordion-flush-heading-1">
                     <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200" data-accordion-target="#accordion-flush-body-1" aria-expanded="true" aria-controls="accordion-flush-body-1">
                        <span>Bagaimana cara mendaftar di SIMSAPRAS?</span>
                        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                           <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                     </button>
                  </h2>
                  <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                     <div class="py-5 border-b border-gray-200">
                        <p class="mb-2 text-gray-500">Pendaftaran SIMSAPRAS menggunakan akun Single Sign On (SSO) Universitas Andalas. Anda cukup login menggunakan akun yang sama dengan yang digunakan untuk sistem akademik.</p>
                     </div>
                  </div>
                  <!-- FAQ Item 2 -->
                  <h2 id="accordion-flush-heading-2">
                     <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                        <span>Berapa lama proses persetujuan peminjaman ruangan?</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                           <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                     </button>
                  </h2>
                  <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                     <div class="py-5 border-b border-gray-200">
                        <p class="mb-2 text-gray-500">Proses persetujuan peminjaman ruangan biasanya membutuhkan waktu maksimal 1x24 jam kerja. Untuk peminjaman mendesak, silakan hubungi admin melalui kontak yang tersedia.</p>
                     </div>
                  </div>
                  <!-- FAQ Item 3 -->
                  <h2 id="accordion-flush-heading-3">
                     <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200" data-accordion-target="#accordion-flush-body-3" aria-expanded="false" aria-controls="accordion-flush-body-3">
                        <span>Apa saja persyaratan peminjaman ruangan?</span>
                        <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                           <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                     </button>
                  </h2>
                  <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                     <div class="py-5 border-b border-gray-200">
                        <p class="mb-2 text-gray-500">Persyaratan utama meliputi: status aktif sebagai mahasiswa/staff Unand, surat pengantar dari fakultas/jurusan, dan proposal kegiatan untuk penggunaan ruangan lebih dari 3 jam.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Contact Section -->
      <section id="contact" class="bg-white py-24">
         <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-16">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
               <div>
                  <h2 class="mb-4 text-3xl font-extrabold text-gray-900">Hubungi Kami</h2>
                  <p class="mb-6 text-gray-500">Ada pertanyaan atau kendala? Jangan ragu untuk menghubungi tim support kami.</p>
                  <div class="flex flex-col gap-4">
                     <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                           <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                           <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        <span class="text-gray-500">support@unand.ac.id</span>
                     </div>
                     <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                           <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                        <span class="text-gray-500">(0751) 123456</span>
                     </div>
                     <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                           <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-500">Gedung PKM, Universitas Andalas, Padang</span>
                     </div>
                  </div>
               </div>
               <div>
                  <form class="space-y-4">
                     <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                     </div>
                     <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                     </div>
                     <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Pesan</label>
                        <textarea id="message" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required></textarea>
                     </div>
                     <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Kirim Pesan</button>
                  </form>
               </div>
            </div>
         </div>
      </section>
@endsection
