<aside id="sidebar" class="fixed top-0 left-0 z-30 h-screen pt-14 transition-all duration-300 ease-in-out bg-white border-r border-gray-200 w-64" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
       <ul class="space-y-2 font-medium mt-8">
          <!-- Dashboard -->
          <li>
             <a href="{{ route('dashboard.index') }}" class="flex items-center p-2 rounded-lg group transition-colors duration-200 {{ request()->routeIs('dashboard.index') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('dashboard.index') ? 'text-green-600' : 'text-gray-500 group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                <span class="ml-3">Dashboard</span>
             </a>
          </li>

          <!-- Peminjaman -->
          @php
             $peminjamanRoutes = [
                 'admin.overview',
                 'peminjaman.admin.masuk',
                 'peminjaman.admin.diproses',
                 'peminjaman.admin.disetujui',
                 'peminjaman.admin.ditolak',
                 'peminjaman.admin.dibatalkan',
                 'peminjaman.admin.diajukanbatal',
             ];
          @endphp
          <li class="relative">
             <button type="button"
                     class="flex items-center w-full p-2 text-base rounded-lg group transition duration-200 {{ request()->routeIs($peminjamanRoutes) ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}"
                     data-collapse-toggle="dropdown-example"
                     aria-expanded="{{ request()->routeIs($peminjamanRoutes) ? 'true' : 'false' }}">
                <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs($peminjamanRoutes) ? 'text-green-600' : 'text-gray-500 group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9" />
                </svg>
                <span class="flex-1 ml-3 text-left whitespace-nowrap">Peminjaman</span>
                <svg class="w-3 h-3 transition-transform duration-200 {{ request()->routeIs($peminjamanRoutes) ? 'rotate-180' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                   <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
             </button>
             <ul id="dropdown-example" class="{{ request()->routeIs($peminjamanRoutes) ? 'block' : 'hidden' }} py-2 space-y-1">
             <li>
                   <a href="{{ route('admin.overview') }}"
                      class="flex items-center w-full p-2 rounded-lg pl-11 transition duration-75 {{ request()->routeIs('admin.overview') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                      Overview
                   </a>
                </li>
                <li>
                   <a href="{{ route('peminjaman.admin.masuk') }}"
                      class="flex items-center w-full p-2 rounded-lg pl-11 transition duration-75 {{ request()->routeIs('peminjaman.admin.masuk') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                      Peminjaman Masuk
                   </a>
                </li>
                <li>
                   <a href="{{ route('peminjaman.admin.diproses') }}"
                      class="flex items-center w-full p-2 rounded-lg pl-11 transition duration-75 {{ request()->routeIs('peminjaman.admin.diproses') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                      Peminjaman Diproses
                   </a>
                </li>
                <li>
                   <a href="{{ route('peminjaman.admin.disetujui') }}"
                      class="flex items-center w-full p-2 rounded-lg pl-11 transition duration-75 {{ request()->routeIs('peminjaman.admin.disetujui') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                      Peminjaman Disetujui
                   </a>
                </li>
                <li>
                   <a href="{{ route('peminjaman.admin.ditolak') }}"
                      class="flex items-center w-full p-2 rounded-lg pl-11 transition duration-75 {{ request()->routeIs('peminjaman.admin.ditolak') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                      Peminjaman Ditolak 
                   </a>
                </li>
                <li>
                  <a href="{{ route('peminjaman.admin.diajukanbatal') }}"
                     class="flex items-center w-full p-2 rounded-lg pl-11 transition duration-75 {{ request()->routeIs('peminjaman.admin.diajukanbatal') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                     Pengajuan Pembatalan
                  </a>
               </li>
                <li>
                   <a href="{{ route('peminjaman.admin.dibatalkan') }}"
                      class="flex items-center w-full p-2 rounded-lg pl-11 transition duration-75 {{ request()->routeIs('peminjaman.admin.dibatalkan') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                      Peminjaman Dibatalkan
                   </a>
                </li>
             </ul>
          </li>

          <!-- Sarana & Prasarana -->
          @php
             $saranaRoutes = ['kategori.index', 'sarana.index', 'penjaga.index'];
          @endphp
          <li class="relative">
             <button type="button"
                     class="flex items-center w-full p-2 text-base rounded-lg group transition duration-200 {{ request()->routeIs($saranaRoutes) ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}"
                     data-collapse-toggle="sarana"
                     aria-expanded="{{ request()->routeIs($saranaRoutes) ? 'true' : 'false' }}">
                <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs($saranaRoutes) ? 'text-green-600' : 'text-gray-500 group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
                <span class="flex-1 ml-3 text-left whitespace-nowrap">Sarana & Prasarana</span>
                <svg class="w-3 h-3 transition-transform duration-200 {{ request()->routeIs($saranaRoutes) ? 'rotate-180' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                   <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
             </button>
             <ul id="sarana" class="{{ request()->routeIs($saranaRoutes) ? 'block' : 'hidden' }} py-2 space-y-1">
                <li>
                   <a href="{{ route('kategori.index') }}"
                      class="flex items-center w-full p-2 rounded-lg pl-11 transition duration-75 {{ request()->routeIs('kategori.index') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                      Kategori Sarana
                   </a>
                </li>
                <li>
                   <a href="{{ route('sarana.index') }}"
                      class="flex items-center w-full p-2 rounded-lg pl-11 transition duration-75 {{ request()->routeIs('sarana.index') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                      Daftar Sarana
                   </a>
                </li>
                <li>
                   <a href="{{ route('penjaga.index') }}"
                      class="flex items-center w-full p-2 rounded-lg pl-11 transition duration-75 {{ request()->routeIs('penjaga.index') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                      Daftar Penjaga
                   </a>
                </li>
             </ul>
          </li>

          <!-- Jadwal -->
          <li>
             <a href="{{ route('jadwal.index') }}"
                class="flex items-center p-2 rounded-lg group transition-colors duration-200 {{ request()->routeIs('jadwal.index') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('jadwal.index') ? 'text-green-600' : 'text-gray-500 group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <span class="ml-3">Jadwal Peminjaman</span>
             </a>
          </li>

          <!-- Pengguna -->
          @if (Gate::any(['is-superadmin', 'is-pimpinan']))
          <li>
             <a href="{{ route('pengguna.index') }}"
                class="flex items-center p-2 rounded-lg group transition-colors duration-200 {{ request()->routeIs('pengguna.index') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('pengguna.index') ? 'text-green-600' : 'text-gray-500 group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
      </svg>
                <span class="ml-3">Pengguna</span>
             </a>
          </li>
          @endif
          <li>
             <a href="{{ route('pengumuman.index') }}"
                class="flex items-center p-2 rounded-lg group transition-colors duration-200 {{ request()->routeIs('pengumuman.index') ? 'text-green-600' : 'text-gray-900 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('pengumuman.index') ? 'text-green-600' : 'text-gray-500 group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
      </svg>
                <span class="ml-3">Pengumuman</span>
             </a>
          </li>
       </ul>
    </div>
 </aside>
