      <footer class="bg-gray-900 mt-32">
         <div class="max-w-screen-2xl p-4 py-6 mx-auto lg:py-16 md:p-8 lg:p-10">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
               <div>
                  <h3 class="mb-6 text-sm font-semibold text-white uppercase">Tentang SIMSAPRAS</h3>
                  <p class="text-gray-400">Sistem Informasi Peminjaman Sarana Prasarana Universitas Andalas adalah platform digital yang memudahkan proses peminjaman dan pengelolaan fasilitas di lingkungan kampus.</p>
               </div>
               <div>
                  <h3 class="mb-6 text-sm font-semibold text-white uppercase">Link Cepat</h3>
                  <ul class="text-gray-400">
                     <li class="mb-4"><a href="{{ route('home') }}" class="hover:underline">Beranda</a></li>
                     <li class="mb-4"><a href="{{ route('home') }}#features" class="hover:underline">Fitur</a></li>
                     <li class="mb-4"><a href="{{ route('home') }}#how-it-works" class="hover:underline">Cara Kerja</a></li>
                     <li class="mb-4"><a href="{{ route('home') }}#contact" class="hover:underline">Kontak</a></li>
                  </ul>
               </div>
               <div>
                  <h3 class="mb-6 text-sm font-semibold text-white uppercase">Sosial Media</h3>
                  <ul class="text-gray-400">
                     <li class="mb-4"><a href="#" class="hover:underline">Facebook</a></li>
                     <li class="mb-4"><a href="#" class="hover:underline">Twitter</a></li>
                     <li class="mb-4"><a href="#" class="hover:underline">Instagram</a></li>
                     <li class="mb-4"><a href="#" class="hover:underline">YouTube</a></li>
                  </ul>
               </div>
            </div>
            <hr class="my-6 border-gray-700 lg:my-8">
            <div class="text-center">
               <span class="block text-sm text-center text-gray-400">&copy; {{ date('Y') }} SIMSAPRAS by Neo Telemetri</span>
               <span class="block text-sm text-center text-gray-400 mt-2">Universitas Andalas</span>
            </div>
         </div>
      </footer>