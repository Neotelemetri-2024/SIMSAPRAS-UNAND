<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      @vite(['resources/css/app.css','resources/js/app.js'])
      <title>Document</title>
   </head>
   <body class="bg-gray-50">
      <div class="flex h-screen">
         <!-- Sidebar -->
          @include('admin.partials.sidebar')
         <!-- Konten Utama -->
         <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
                @include('admin.partials.navbar')
            <!-- Konten -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4">
               <div class="container mx-auto  py-2">
                 @yield('content')
               </div>
            </main>
            <!-- Footer -->
            <footer class="bg-white p-4 border-t">
               <div class="text-center text-sm text-gray-500">
                  © 2024 Dashboard Admin. All rights reserved.
               </div>
            </footer>
         </div>
      </div>
      <script>
         // Toggle sidebar
         const sidebar = document.getElementById('sidebar');
         const toggleButtons = document.querySelectorAll('#toggleSidebar, #toggleSidebarMobile');

         toggleButtons.forEach(button => {
             button.addEventListener('click', () => {
                 sidebar.classList.toggle('w-64');
                 sidebar.classList.toggle('w-16');

                 // Sembunyikan/tampilkan teks sidebar
                 const sidebarTexts = sidebar.querySelectorAll('span');
                 sidebarTexts.forEach(text => {
                     text.classList.toggle('hidden');
                 });
             });
         });
      </script>
   </body>
</html>
