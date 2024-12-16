@extends('layouts.main')
@section('content')
<div class="p-4 sm:p-6">
   <!-- Card Container -->
   <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
      <!-- Card Header -->
      <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
         <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Data Sarana</h5>
         <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
         + Tambah Sarana
         </button>
      </div>
      <!-- Card Body -->
      <div class="p-5">
         @if(session('success'))
         <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
         </div>
         @endif
         <!-- Table -->
         <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col" class="px-6 py-3">No</th>
                     <th scope="col" class="px-6 py-3">Kategori</th>
                     <th scope="col" class="px-6 py-3">Nama</th>
                     <th scope="col" class="px-6 py-3">Deskripsi</th>
                     <th scope="col" class="px-6 py-3">Fasilitas</th>
                     <th scope="col" class="px-6 py-3">Gambar</th>
                     <th scope="col" class="px-6 py-3">Kelola Ruangan</th>
                     <th scope="col" class="px-6 py-3">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($sarana as $index => $item)
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                     <td class="px-6 py-4">{{ $index + 1 }}</td>
                     <td class="px-6 py-4 text-red">{{ $item->kategoriSarana->jenis ?? '-' }}</td>
                     <td class="px-6 py-4">{{ $item->nama }}</td>
                     <td class="px-6 py-4">{{ $item->deskripsi }}</td>
                     <td class="px-6 py-4">{{ $item->fasilitas }}</td>
                     <td class="px-6 py-4">
                        @if($item->gambar)
                        <img src="{{ Storage::url($item->gambar) }}" alt="Gambar" class="w-24 h-24 object-cover rounded">
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                     </td>
                     <td class="px-6 py-4">
                        <div class="flex space-x-2">
                           <a href="" 
                              class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200">
                              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                              </svg>
                              Ruangan
                           </a>
                        </div>
                     </td>
                     <td class="px-6 py-4">
                        <div class="flex space-x-2">
                           <button data-modal-target="editModal{{ $item->id }}" 
                              data-modal-toggle="editModal{{ $item->id }}" 
                              class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-300 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-200">
                              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                              </svg>
                              Edit
                           </button>
                           <button data-modal-target="deleteModal{{ $item->id }}" 
                              data-modal-toggle="deleteModal{{ $item->id }}"
                              class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200">
                              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                              </svg>
                              Hapus
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
         <!-- Modal header -->
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Tambah Sarana
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createModal">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <!-- Modal body -->
         <form action="{{ route('sarana.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-6">
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                  <select name="IdKategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('IdKategori') border-red-500 @enderror" required>
                     <option value="">Pilih Kategori</option>
                     @foreach($kategori as $kat)
                     <option value="{{ $kat->id }}">{{ $kat->jenis }}</option>
                     @endforeach
                  </select>
                  @error('IdKategori')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                  @enderror
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                  <input type="text" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('nama') border-red-500 @enderror" required>
                  @error('nama')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                  @enderror
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                  <textarea name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror" required></textarea>
                  @error('deskripsi')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                  @enderror
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fasilitas</label>
                  <textarea name="fasilitas" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error('fasilitas') border-red-500 @enderror" required></textarea>
                  @error('fasilitas')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                  @enderror
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar</label>
                  <input type="file" name="gambar" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('gambar') border-red-500 @enderror" required>
                  @error('gambar')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                  @enderror
               </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
               <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
               <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="createModal">Batal</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Edit Modals -->
@foreach($sarana as $item)
<div id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
   <div class="relative w-full max-w-2xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <!-- Modal header -->
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Edit Sarana
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editModal{{ $item->id }}">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <!-- Modal body -->
         <form action="{{ route('sarana.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                  <select name="IdKategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('IdKategori') border-red-500 @enderror" required>
                     <option value="">Pilih Kategori</option>
                     @foreach($kategori as $kat)
                     <option value="{{ $kat->id }}" {{ $item->IdKategori == $kat->id ? 'selected' : '' }}>
                     {{ $kat->nama }}
                     </option>
                     @endforeach
                  </select>
                  @error('IdKategori')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                  @enderror
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                  <input type="text" name="nama" value="{{ $item->nama }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('nama') border-red-500 @enderror" required>
                  @error('nama')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                  @enderror
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                  <textarea name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror" required>{{ $item->deskripsi }}</textarea>
                  @error('deskripsi')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                  @enderror
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fasilitas</label>
                  <textarea name="fasilitas" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error('fasilitas') border-red-500 @enderror" required>{{ $item->fasilitas }}</textarea>
                  @error('fasilitas')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                  @enderror
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar</label>
                  @if($item->gambar)
                  <div class="mb-3">
                     <img src="{{ Storage::url($item->gambar) }}" alt="Current Image" class="w-32 h-32 object-cover rounded">
                  </div>
                  @endif
                  <input type="file" name="gambar" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('gambar') border-red-500 @enderror">
                  <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Biarkan kosong jika tidak ingin mengubah gambar</p>
                  @error('gambar')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                  @enderror
               </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
               <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
               Simpan Perubahan
               </button>
               <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="editModal{{ $item->id }}">
               Batal
               </button>
            </div>
         </form>
      </div>
   </div>
</div>
@endforeach
<!-- Tambahkan Modal Konfirmasi Delete untuk setiap item -->
@foreach($sarana as $item)
<!-- Delete Confirmation Modal -->
<div id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
   <div class="relative w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="deleteModal{{ $item->id }}">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
         </button>
         <div class="p-6 text-center">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
               Apakah Anda yakin ingin menghapus sarana ini?
            </h3>
            <form action="{{ route('sarana.destroy', $item->id) }}" method="POST" class="inline">
               @csrf
               @method('DELETE')
               <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
               Ya, saya yakin
               </button>
               <button type="button" data-modal-hide="deleteModal{{ $item->id }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
               Tidak, batal
               </button>
            </form>
         </div>
      </div>
   </div>
</div>
@endforeach
<!-- Tambahkan di bagian script -->
<script>
   // Fungsi untuk menutup modal
   function closeModal(modalId) {
       const modalElement = document.getElementById(modalId);
       if (modalElement) {
           modalElement.classList.add('hidden');
       }
   }
   
   // Inisialisasi komponen modal
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
   
   // Inisialisasi tombol close modal
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