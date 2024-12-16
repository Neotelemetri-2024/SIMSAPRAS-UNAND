<nav class="bg-white dark:bg-gray-900 fixed w-full z-50 border-b border-gray-200 h-20">
   <div class="max-w-screen-xl h-full flex flex-wrap items-center justify-between mx-auto px-4">
      <!-- Logo Section remains the same -->
      <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
         <div class="bg-green-600 text-white p-2 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
         </div>
         <div class="flex flex-col">
            <span class="text-xl font-semibold text-gray-900">SIPENJARU</span>
            <span class="text-sm text-gray-500">Universitas Andalas</span>
         </div>
      </a>
      <!-- Hamburger Button remains the same -->
      <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-dropdown" aria-expanded="false">
         <span class="sr-only">Open main menu</span>
         <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
         </svg>
      </button>
      <!-- Navigation Menu -->
      <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
         <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:items-center md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white h-full">
            <!-- Home -->
            <li class="flex items-center h-full">
               <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-600 md:p-0"aria-current="page">Beranda</a>
            </li>
            <!-- Features Dropdown -->
            <li class="relative w-full md:w-auto">
               <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-600 md:p-0 md:w-auto">
                  Fitur 
                  <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                  </svg>
               </button>
               <!-- Dropdown menu -->
               <div id="dropdownNavbar" class="z-10 hidden w-full md:w-44 font-normal bg-white divide-y divide-gray-100 md:rounded-lg shadow md:absolute md:left-0">
                  <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownLargeButton">
                     <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Peminjaman Ruang</a>
                     </li>
                     <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Jadwal Ruangan</a>
                     </li>
                     <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Statistik Penggunaan</a>
                     </li>
                  </ul>
               </div>
            </li>
            <!-- Resources Dropdown -->
            <li class="relative w-full md:w-auto">
               <button id="dropdownNavbarLink2" data-dropdown-toggle="dropdownNavbar2" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-600 md:p-0 md:w-auto">
                  Sumber Daya 
                  <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                  </svg>
               </button>
               <!-- Dropdown menu -->
               <div id="dropdownNavbar2" class="z-10 hidden w-full md:w-44 font-normal bg-white divide-y divide-gray-100 md:rounded-lg shadow md:absolute md:left-0">
                  <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownLargeButton">
                     <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Panduan Pengguna</a>
                     </li>
                     <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">FAQ</a>
                     </li>
                     <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Download</a>
                     </li>
                  </ul>
               </div>
            </li>
            <!-- Contact -->
            <li class="flex items-center h-full">
               <a href="#contact" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-600 md:p-0">Kontak</a>
            </li>
            <!-- Auth Section -->
            @can('not-user')
            <!-- Login Button for non-authenticated users -->
            <li class="flex items-center h-full md:ml-8">
               <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                  </svg>
                  Login
               </a>
            </li>
            @endcan
            @can('is-user')
            <!-- Profile Dropdown for authenticated users -->
            <li class="relative flex items-center h-full md:ml-8">
               <div class="flex items-center">
                  <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                  <span class="sr-only">Open user menu</span>
                  <img class="w-8 h-8 rounded-full" src="https://flowbite.com/application-ui/demo/images/users/neil-sims.png" alt="user photo">
                  </button>
                  <!-- User Dropdown Menu -->
                  <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                     <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">Asep</span>
                        <span class="block text-sm text-gray-500 truncate dark:text-gray-400">Asep@gmail.com</span>
                     </div>
                     <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                           <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                        </li>
                        <li>
                           <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                        </li>
                        <li>
                           <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Earnings</a>
                        </li>
                        <li>
                           <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                        </li>
                     </ul>
                  </div>
               </div>
            </li>
            @endcan
         </ul>
      </div>
   </div>
</nav>