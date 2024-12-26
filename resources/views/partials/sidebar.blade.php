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
                   <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <span class="ml-3">Pengguna</span>
             </a>
          </li>
          @endif
       </ul>
    </div>
 </aside>
