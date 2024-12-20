@extends('layouts.main')
@section('content')
<div class="p-4 sm:p-6">
   <!-- Card Container -->
   <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
      <!-- Card Header -->
      <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
         <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Daftar Sarana</h5>
         <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
         + Tambah Sarana
         </button>
      </div>
      {{-- Search and Filter Bar --}}
<div class="p-5 border-b border-gray-200 dark:border-gray-700">
    <form method="GET" action="{{ route('sarana.index') }}" class="flex gap-3">
        {{-- Search Input --}}
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text"
                       name="search"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                       placeholder="Cari sarana..."
                       value="{{ request('search') }}">
            </div>
        </div>

        {{-- Category Filter Dropdown --}}
        <div class="w-48">
            <select name="kategori"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->jenis }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Search Button --}}
        <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Cari
        </button>
    </form>
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
                     <th scope="col" class="px-6 py-3">Nama Sarana</th>
                     <th scope="col" class="px-6 py-3">Kategori</th>
                     <th scope="col" class="px-6 py-3">Fasilitas</th>
                     <th scope="col" class="px-6 py-3">Gambar</th>
                     <th scope="col" class="px-6 py-3">Kelola Ruangan</th>
                     <th scope="col" class="px-6 py-3">Status</th>
                     <th scope="col" class="px-6 py-3">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($sarana as $index => $item)
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                     <td class="px-6 py-4">{{ $loop->iteration + ($sarana->currentPage() - 1) * $sarana->perPage() }}</td>
                      <td class="px-6 py-4">{{ $item->nama }}</td>
                     <td class="px-6 py-4 text-red">{{ $item->kategoriSarana->jenis ?? '-' }}</td>
                     <td class="px-6 py-4">{{ $item->fasilitas }}</td>
               <td class="px-6 py-4">
                        @if($item->gambar)
                        <div class="relative group">
                            <img src="{{ Storage::url($item->gambar) }}" 
                                 alt="Gambar" 
                                 class="w-24 h-24 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                                 onclick="showImagePreview('{{ Storage::url($item->gambar) }}')"
                            >
                        </div>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                     </td>
                      <td class="px-6 py-4">
                        <div class="flex space-x-2">
                              @if($item->kategoriSarana->jenis == 'Gedung Beruangan')
                           <a href="{{ route('ruangan.index', ['idSarana' => $item->id]) }}"
                              class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200">
                              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                              </svg>
                              Ruangan
                           </a>
                              @else
                                 <span class="text-gray-400">Tidak Tersedia</span>
                              @endif
                        </div>
                     </td>
                     <td class="px-6 py-4">
                        @if($item->status == "aktif")
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                            Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">
                            Nonaktif
                        </span>
                        @endif
                     </td>
                     <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <!-- Tombol Edit -->
                            <button data-modal-target="editModal{{ $item->id }}"
                                    data-modal-toggle="editModal{{ $item->id }}"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-300 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                    
                            <!-- Tombol Sampah (Hanya jika status Nonaktif) -->
                            @if($item->status == "nonaktif")
                            <button data-modal-target="deleteModal{{ $item->id }}"
                                    data-modal-toggle="deleteModal{{ $item->id }}"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                     </td>  
                  </tr>
                  @endforeach
               </tbody>
            </table>
            <!-- Improved Pagination -->
<div class="px-6 py-4">
    @if ($sarana->hasPages())
       <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
          <div class="flex justify-between flex-1 sm:hidden">
             @if ($sarana->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-lg">
                   Previous
                </span>
             @else
                <a href="{{ $sarana->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                   Previous
                </a>
             @endif

             @if ($sarana->hasMorePages())
                <a href="{{ $sarana->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                   Next
                </a>
             @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-lg">
                   Next
                </span>
             @endif
          </div>

          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
             <div>
                <p class="text-sm text-gray-700 leading-5">
                   Showing
                   <span class="font-medium">{{ $sarana->firstItem() }}</span>
                   to
                   <span class="font-medium">{{ $sarana->lastItem() }}</span>
                   of
                   <span class="font-medium">{{ $sarana->total() }}</span>
                   results
                </p>
             </div>

             <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                   {{-- Previous Page Link --}}
                   @if ($sarana->onFirstPage())
                      <span aria-disabled="true">
                         <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-lg leading-5">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                               <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                         </span>
                      </span>
                   @else
                      <a href="{{ $sarana->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                         <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                         </svg>
                      </a>
                   @endif

                   {{-- Pagination Elements --}}
                   @foreach ($sarana->getUrlRange(1, $sarana->lastPage()) as $page => $url)
                      @if ($page == $sarana->currentPage())
                         <span aria-current="page">
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-blue-600 bg-blue-50 border border-gray-300 cursor-default leading-5">{{ $page }}</span>
                         </span>
                      @else
                         <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            {{ $page }}
                         </a>
                      @endif
                   @endforeach

                   {{-- Next Page Link --}}
                   @if ($sarana->hasMorePages())
                      <a href="{{ $sarana->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                         <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                         </svg>
                      </a>
                   @else
                      <span aria-disabled="true">
                         <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-lg leading-5">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                               <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                         </span>
                      </span>
                   @endif
                </span>
             </div>
          </div>
       </nav>
    @endif
 </div>
         </div>
      </div>
   </div>
</div>
<!-- Create Modal -->
<div id="createModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
   <div class="relative w-full max-w-4xl max-h-full"> <!-- Ubah max-w-2xl menjadi max-w-4xl -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Tambah Sarana</h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="createModal">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <form action="{{ route('sarana.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6">
               <div class="grid grid-cols-2 gap-6"> <!-- Tambahkan grid layout -->
                  <!-- Kolom Kiri -->
                  <div class="space-y-6">
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                        <select name="IdKategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                           <option value="">Pilih Kategori</option>
                           @foreach($kategori as $kat)
                           <option value="{{ $kat->id }}">{{ $kat->jenis }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                     </div>
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required></textarea>
                     </div>
                  </div>

                  <!-- Kolom Kanan -->
                  <div class="space-y-6">
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Fasilitas</label>
                        <textarea name="fasilitas" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required></textarea>
                     </div>
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Gambar Utama</label>
                        <input type="file" name="gambar" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" required>
                     </div>
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Gambar Tambahan</label>
                        <input type="file" name="gambar_tambahan[]" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                        <p class="mt-1 text-xs text-gray-500">Bisa pilih lebih dari satu gambar (opsional)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200">
               <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan</button>
               <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5" data-modal-hide="createModal">Batal</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Edit Modal -->
@foreach($sarana as $item)
<div id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
   <div class="relative w-full max-w-4xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Sarana</h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="editModal{{ $item->id }}">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <form action="{{ route('sarana.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6">
               <div class="grid grid-cols-2 gap-6">
                  <!-- Kolom Kiri -->
                  <div class="space-y-6">
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                        <select name="IdKategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                           @foreach($kategori as $kat)
                           <option value="{{ $kat->id }}" {{ $item->IdKategori == $kat->id ? 'selected' : '' }}>
                              {{ $kat->jenis }}
                           </option>
                           @endforeach
                        </select>
                     </div>
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" name="nama" value="{{ $item->nama }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                     </div>
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>{{ $item->deskripsi }}</textarea>
                     </div>
                  </div>

                  <!-- Kolom Kanan -->
                  <div class="space-y-6">
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Fasilitas</label>
                        <textarea name="fasilitas" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>{{ $item->fasilitas }}</textarea>
                     </div>
                     <div>
                             <label class="block mb-2 text-sm font-medium text-gray-900">Gambar Utama</label>
                        @if($item->gambar)
                        <div class="relative group mb-2">
                            <img src="{{ Storage::url($item->gambar) }}" 
                                 class="w-32 h-32 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                                 onclick="showImagePreview('{{ Storage::url($item->gambar) }}')"
                                 alt="Gambar Utama">
                        </div>
                        @endif
                        <input type="file" name="gambar" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                     </div>
                    <!-- Di dalam edit modal, bagian gambar tambahan -->
<div>
    <label class="block mb-2 text-sm font-medium text-gray-900">Gambar Tambahan</label>
    @if($item->gambarSarana->count() > 0)
    <div class="grid grid-cols-3 gap-2 mb-2">
        @foreach($item->gambarSarana as $gambar)
        <div class="relative group">
            <img src="{{ Storage::url($gambar->gambar) }}"
                 alt="Gambar Tambahan"
                 class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                 onclick="showImagePreview('{{ Storage::url($gambar->gambar) }}')">

            <!-- Tombol Delete dengan Icon Trash -->
            <div class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <input type="checkbox" name="delete_images[]" value="{{ $gambar->id }}"
                       id="delete_image_{{ $gambar->id }}"
                       class="hidden">
                <label for="delete_image_{{ $gambar->id }}"
                       class="p-1 bg-red-500 hover:bg-red-600 rounded-lg cursor-pointer text-white flex items-center justify-center
                              transition-colors deleteImageBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </label>
            </div>

            <!-- Indicator untuk gambar yang akan dihapus -->
            <div class="absolute inset-0 bg-red-500 bg-opacity-20 hidden deleteIndicator">
                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">
                    Akan dihapus
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    <input type="file" name="gambar_tambahan[]" multiple
           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
    <p class="mt-1 text-xs text-gray-500">Tambah gambar baru (opsional)</p>
</div>
                  </div>
               </div>
            </div>
            <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200">
               <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Perubahan</button>
               <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5" data-modal-hide="editModal{{ $item->id }}">Batal</button>
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

<!-- Modal Preview Gambar untuk Edit Modal -->
<div id="previewModal" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 bottom-0 z-[60] hidden w-full p-4 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative max-w-4xl w-full">
        <div class="relative">
            <button type="button" onclick="closeImagePreview()" class="absolute top-2 right-2 text-white bg-gray-800 hover:bg-gray-700 rounded-lg p-1.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="previewImage" src="" alt="Preview" class="w-full rounded-lg">
        </div>
    </div>
</div>
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


    // Fungsi untuk menampilkan preview gambar
    function showImagePreview(imageSrc) {
        const previewModal = document.getElementById('previewModal');
        const previewImage = document.getElementById('previewImage');

        previewImage.src = imageSrc;
        previewModal.classList.remove('hidden');

        // Mencegah scroll pada body
        document.body.style.overflow = 'hidden';
    }

    // Fungsi untuk menutup preview gambar
    function closeImagePreview() {
        const previewModal = document.getElementById('previewModal');
        previewModal.classList.add('hidden');

        // Mengembalikan scroll pada body
        document.body.style.overflow = 'auto';
    }

    // Menutup preview saat mengklik area di luar gambar
    document.getElementById('previewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImagePreview();
        }
    });

    // Menutup preview dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('previewModal').classList.contains('hidden')) {
            closeImagePreview();
        }
    });
document.querySelectorAll('.deleteImageBtn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault(); // Tambahkan ini
        const checkbox = this.parentElement.querySelector('input[type="checkbox"]');
        const imageContainer = this.closest('.relative');
        const deleteIndicator = imageContainer.querySelector('.deleteIndicator');

        console.log('Checkbox value:', checkbox.value); // Debug
        console.log('Checkbox checked:', checkbox.checked); // Debug

        if (checkbox.checked) {
            checkbox.checked = false;
            deleteIndicator.classList.add('hidden');
        } else {
            checkbox.checked = true;
            deleteIndicator.classList.remove('hidden');
        }
    });
});
</script>
@endsection
