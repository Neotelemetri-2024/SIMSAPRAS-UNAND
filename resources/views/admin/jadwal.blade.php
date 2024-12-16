@extends('layouts.main')
@section('content')
<div class="p-4 sm:p-6">
   <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
      <!-- Card Header -->
      <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
         <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Data Jadwal</h5>
         <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
         + Tambah Jadwal
         </button>
      </div>
      <!-- Card Body -->
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
         <!-- Table -->
         <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col" class="px-6 py-3">No</th>
                     <th scope="col" class="px-6 py-3">Shift</th>
                     <th scope="col" class="px-6 py-3">Jam Mulai</th>
                     <th scope="col" class="px-6 py-3">Jam Selesai</th>
                     <th scope="col" class="px-6 py-3">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($jadwal as $index => $item)
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                     <td class="px-6 py-4">{{ $index + 1 }}</td>
                     <td class="px-6 py-4">{{ $item->shift }}</td>
                     <td class="px-6 py-4">{{ $item->mulai }}</td>
                     <td class="px-6 py-4">{{ $item->selesai }}</td>
                     <td class="px-6 py-4">
                        <div class="flex space-x-2">
                           <button data-modal-target="editModal{{ $item->id }}" 
                                   data-modal-toggle="editModal{{ $item->id }}" 
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-300 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-200">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                              </svg>
                           </button>
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

<!-- Create Modal -->
<div id="createModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
   <div class="relative w-full max-w-2xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Tambah Jadwal
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createModal">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <form action="{{ route('jadwal.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shift</label>
                  <input type="text" name="shift" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Mulai</label>
                  <input type="time" name="mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Selesai</label>
                  <input type="time" name="selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
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

<!-- Edit Modals -->
@foreach($jadwal as $item)
<div id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
   <div class="relative w-full max-w-2xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Edit Jadwal
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editModal{{ $item->id }}">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <form action="{{ route('jadwal.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shift</label>
                  <input type="text" name="shift" value="{{ $item->shift }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Mulai</label>
                  <input type="time" name="mulai" value="{{ $item->mulai }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Selesai</label>
                  <input type="time" name="selesai" value="{{ $item->selesai }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
               </div>
            </div>
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
               <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan</button>
               <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" data-modal-hide="editModal{{ $item->id }}">Batal</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endforeach

<!-- Delete Confirmation Modals -->
@foreach($jadwal as $item)
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
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah Anda yakin ingin menghapus jadwal ini?</h3>
            <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST" class="inline">
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

<!-- Modal functionality script -->
<script>
   // Function to close modal
   function closeModal(modalId) {
       const modalElement = document.getElementById(modalId);
       if (modalElement) {
           modalElement.classList.add('hidden');
       }
   }
   
   // Initialize modal components
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
   
   // Initialize modal close buttons
   const closeButtons = document.querySelectorAll('[data-modal-hide]');
   closeButtons.forEach(button => {
       button.addEventListener('click', function() {
           const target = this.getAttribute('data-modal-hide');
           closeModal(target);
       });
   });
   
   // Click outside modal to close
   window.addEventListener('click', function(event) {
       const modals = document.querySelectorAll('[id^="createModal"], [id^="editModal"], [id^="deleteModal"]');
       modals.forEach(modal => {
           if (event.target === modal) {
               closeModal(modal.id);
           }
       });
   });
</script>
@endsection