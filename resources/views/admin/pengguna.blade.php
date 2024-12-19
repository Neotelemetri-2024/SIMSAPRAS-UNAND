@extends('layouts.main')
@section('content')
<div class="p-4 sm:p-6">
   <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
      <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
         <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Data Pengguna</h5>
         <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
         + Tambah Pengguna
         </button>
      </div>
      <div class="p-5">
         @if(session('success'))
         <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
         </div>
         @endif
         @if(session('error'))
         <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('error') }}
         </div>
         @endif

         <div class="mb-4">
            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px">
                    <li class="mr-2">
                        <button class="tab-button inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500" data-role="user">
                            User
                        </button>
                    </li>
                    <li class="mr-2">
                        <button class="tab-button inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" data-role="admin">
                            Admin
                        </button>
                    </li>
                    <li class="mr-2">
                        <button class="tab-button inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" data-role="superadmin">
                            Superadmin
                        </button>
                    </li>
                    <li class="mr-2">
                        <button class="tab-button inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" data-role="pimpinan">
                            Pimpinan
                        </button>
                    </li>
                </ul>
            </div>
        </div>

         <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col" class="px-6 py-3">No</th>
                     <th scope="col" class="px-6 py-3">Nama</th>
                     <th scope="col" class="px-6 py-3">Email</th>
                     <th scope="col" class="px-6 py-3">Role</th>
                     <th scope="col" class="px-6 py-3">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  @php
                     $userCount = 1;
                     $adminCount = 1;
                     $superadminCount = 1;
                     $pimpinanCount = 1;
                  @endphp
                  @foreach($pengguna as $item)
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 role-row" data-role="{{ $item->role }}">
                     <td class="px-6 py-4">
                        @if($item->role == 'user')
                            {{ $userCount++ }}
                        @elseif($item->role == 'admin')
                            {{ $adminCount++ }}
                        @elseif($item->role == 'superadmin')
                            {{ $superadminCount++ }}
                        @elseif($item->role == 'pimpinan')
                            {{ $pimpinanCount++ }}
                        @endif
                    </td>
                     <td class="px-6 py-4">{{ $item->name }}</td>
                     <td class="px-6 py-4">{{ $item->email }}</td>
                     <td class="px-6 py-4">{{ $item->role }}</td>
                     <td class="px-6 py-4">
                        <div class="flex space-x-2">
                           <button data-modal-target="deleteModal{{ $item->id }}"
                                   data-modal-toggle="deleteModal{{ $item->id }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                              </svg>
                           </button>
                        </div>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<div id="createModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
   <div class="relative w-full max-w-2xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Tambah Pengguna
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createModal">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <form action="{{ route('pengguna.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                  <input type="text" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                  <input type="text" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                  <select name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                     <option value="" selected disabled>Pilih Role</option>
                     <option value="user">User</option>
                     <option value="admin">Admin</option>
                     <option value="superadmin">Superadmin</option>
                     <option value="pimpinan">Pimpinan</option>
                  </select>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                  <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
               </div>
            </div>
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
               <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
               <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" data-modal-hide="createModal">Batal</button>
            </div>
         </form>
      </div>
   </div>
</div>

@foreach($pengguna as $item)
<div id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
   <div class="relative w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="deleteModal{{ $item->id }}">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
         </button>
         <div class="p-6 text-center">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah Anda yakin ingin menghapus pengguna ini?</h3>
            <form action="{{ route('pengguna.destroy', $item->id) }}" method="POST" class="inline">
               @csrf
               @method('DELETE')
               <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                  Ya, saya yakin
               </button>
               <button type="button" data-modal-hide="deleteModal{{ $item->id }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                  Tidak, batal
               </button>
            </form>
         </div>
      </div>
   </div>
</div>
@endforeach

<script>
   function closeModal(modalId) {
       const modalElement = document.getElementById(modalId);
       if (modalElement) {
           modalElement.classList.add('hidden');
       }
   }

   const modals = document.querySelectorAll('[data-modal-toggle]');
   modals.forEach(modal => {
       modal.addEventListener('click', function() {
           const target = this.getAttribute('data-modal-target');
           const modalElement = document.getElementById(target);

           if (modalElement) {
               modalElement.classList.remove('hidden');
           }
       });
   });

   const closeButtons = document.querySelectorAll('[data-modal-hide]');
   closeButtons.forEach(button => {
       button.addEventListener('click', function() {
           const target = this.getAttribute('data-modal-hide');
           closeModal(target);
       });
   });

   window.addEventListener('click', function(event) {
       const modals = document.querySelectorAll('[id^="createModal"], [id^="deleteModal"]');
       modals.forEach(modal => {
           if (event.target === modal) {
               closeModal(modal.id);
           }
       });
   });

   // Fungsi untuk menangani perpindahan tab
   document.addEventListener('DOMContentLoaded', function() {
      // Fungsi untuk menampilkan data berdasarkan role
      function showRoleData(role) {
         // Sembunyikan semua baris
         document.querySelectorAll('.role-row').forEach(row => {
               row.style.display = 'none';
         });

         // Tampilkan baris yang sesuai dengan role
         document.querySelectorAll(`.role-row[data-role="${role}"]`).forEach(row => {
               row.style.display = 'table-row';
         });

         // Update tampilan tab aktif
         document.querySelectorAll('.tab-button').forEach(tab => {
               tab.classList.remove('text-blue-600', 'border-blue-600', 'active', 'dark:text-blue-500', 'dark:border-blue-500');
               tab.classList.add('border-transparent');
         });

         const activeTab = document.querySelector(`.tab-button[data-role="${role}"]`);
         activeTab.classList.add('text-blue-600', 'border-blue-600', 'active', 'dark:text-blue-500', 'dark:border-blue-500');
         activeTab.classList.remove('border-transparent');
      }

      // Event listener untuk tab buttons
      document.querySelectorAll('.tab-button').forEach(button => {
         button.addEventListener('click', function() {
               const role = this.getAttribute('data-role');
               showRoleData(role);
         });
      });

      // Tampilkan data user saat halaman pertama kali dimuat
      showRoleData('user');
   });
</script>
@endsection
