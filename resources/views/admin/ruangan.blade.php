@extends('layouts.main')
@section('content')
<div class="p-4 sm:p-6">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <!-- Header dengan Back Button -->
        <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('sarana.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Data Ruangan - {{ $sarana->nama }}</h5>
            </div>
            @if($sarana->status == "aktif")
            <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                + Tambah Ruangan
            </button>
            @endif
        </div>

        <!-- Search Bar -->
        <div class="p-5 border-b border-gray-200 dark:border-gray-700">
            <form method="GET" action="{{ route('ruangan.index', $sarana->id) }}" class="flex gap-3">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text"
                               name="search"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                               placeholder="Cari ruangan..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="w-48">
                    <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                       <option value="">Semua Ruangan</option>
                       <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                       <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                 </div>
                <button type="submit"
                        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                    Cari
                </button>
            </form>
        </div>

        <div class="p-5">
        
            <!-- Table -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Kapasitas</th>
                            <th scope="col" class="px-6 py-3">Deskripsi</th>
                            <th scope="col" class="px-6 py-3">Fasilitas</th>
                            <th scope="col" class="px-6 py-3">Gambar</th>
                            <th scope="col" class="px-6 py-3">Gambar Tambahan</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruangan as $index => $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">{{ $loop->iteration + ($ruangan->currentPage() - 1) * $ruangan->perPage() }}</td>
                            <td class="px-6 py-4">{{ $item->nama }}</td>
                            <td class="px-6 py-4">{{ $item->kapasitas }}</td>
                            <td class="px-6 py-4">{{ $item->deskripsi }}</td>
                            <td class="px-6 py-4">{{ $item->fasilitas }}</td>
                            <td class="px-6 py-4">
                                @if($item->gambar)
                                <div class="relative group">
                                    <img src="{{ Storage::url($item->gambar) }}" 
                                         alt="Gambar" 
                                         class="w-24 h-24 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                                         onclick="showImagePreview('{{ Storage::url($item->gambar) }}')">
                                </div>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($item->gambarRuangan as $gambar)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($gambar->gambar) }}"
                                             alt="Gambar Tambahan"
                                             class="w-24 h-24 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                                             onclick="showImagePreview('{{ Storage::url($gambar->gambar) }}')"
                                             data-image-id="{{ $gambar->id }}">
                                    </div>
                                    @endforeach
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
                            
                                    <!-- Tombol Sampah (Hanya jika status Nonaktif) -->
                                    @if($item->status == "aktif")
                                    <!-- Tombol Edit -->
                                    <button data-modal-target="editModal{{ $item->id }}"
                                        data-modal-toggle="editModal{{ $item->id }}"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-300 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                    <button onclick="confirmDelete('{{ route('ruangan.destroy', ['idSarana' => $sarana->id, 'ruangan' => $item->id]) }}')"
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
                <!-- Pagination -->
                <div class="px-6 py-4">
                    @if ($ruangan->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                            <div class="flex justify-between flex-1 sm:hidden">
                                @if ($ruangan->onFirstPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-lg">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $ruangan->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-700">
                                        Previous
                                    </a>
                                @endif

                                @if ($ruangan->hasMorePages())
                                    <a href="{{ $ruangan->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-700">
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
                                        <span class="font-medium">{{ $ruangan->firstItem() }}</span>
                                        to
                                        <span class="font-medium">{{ $ruangan->lastItem() }}</span>
                                        of
                                        <span class="font-medium">{{ $ruangan->total() }}</span>
                                        results
                                    </p>
                                </div>

                                <div>
                                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                        {{-- Previous Page Link --}}
                                        @if ($ruangan->onFirstPage())
                                            <span aria-disabled="true">
                                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-lg leading-5">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </span>
                                        @else
                                            <a href="{{ $ruangan->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($ruangan->getUrlRange(1, $ruangan->lastPage()) as $page => $url)
                                            @if ($page == $ruangan->currentPage())
                                                <span aria-current="page">
                                                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-green-600 bg-green-50 border border-gray-300 cursor-default leading-5">{{ $page }}</span>
                                                </span>
                                            @else
                                                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                                    {{ $page }}
                                                </a>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($ruangan->hasMorePages())
                                            <a href="{{ $ruangan->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
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
    <div class="relative w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Tambah Ruangan</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="createModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <form id="ruanganForm" action="{{ route('ruangan.store', $sarana->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Kolom Kiri -->
                        <div class="space-y-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Nama Ruangan</label>
                                <input type="text" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Kapasitas</label>
                                <input type="number" name="kapasitas" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                <textarea name="deskripsi" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required></textarea>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Fasilitas</label>
                                <textarea name="fasilitas" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required></textarea>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Tarif Mahasiswa UNAND</label>
                                <input type="number" name="tarifunand" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Tarif Non-Mahasiswa UNAND</label>
                                <input type="number" name="tarifumum" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Apakah ini ruang kelas?</label>
                                <select name="kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Gambar Utama</label>
                                <input type="file" name="gambar" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Gambar Tambahan</label>
                                <input type="file" name="additional_images[]" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                                <p class="mt-1 text-xs text-gray-500">Bisa pilih lebih dari satu gambar (opsional)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200">
                    <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-green-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5" data-modal-hide="createModal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
@foreach($ruangan as $item)
<div id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Ruangan</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="editModal{{ $item->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <form id="editRuanganForm" action="{{ route('ruangan.update', ['idSarana' => $sarana->id, 'ruangan' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="X-Requested-With" value="XMLHttpRequest">
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Kolom Kiri -->
                        <div class="space-y-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Nama Ruangan</label>
                                <input type="text" name="nama" value="{{ $item->nama }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Kapasitas</label>
                                <input type="number" name="kapasitas" value="{{ $item->kapasitas }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                <textarea name="deskripsi" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>{{ $item->deskripsi }}</textarea>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Fasilitas</label>
                                <textarea name="fasilitas" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>{{ $item->fasilitas }}</textarea>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Tarif Mahasiswa UNAND</label>
                                <input type="number" name="tarifunand" min="0" value="{{ $item->tarifunand }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Tarif Non-Mahasiswa UNAND</label>
                                <input type="number" name="tarifumum" min="0" value="{{ $item->tarifumum }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Apakah ini ruang kelas?</label>
                                <select name="kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                                    <option value="1" {{ $item->kelas == 1 ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ $item->kelas == 0 ? 'selected' : '' }}>Tidak</option>
                                </select>
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
                            <!-- Gambar Tambahan -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Gambar Tambahan</label>
                                @if($item->gambarRuangan->count() > 0)
                                <div class="grid grid-cols-3 gap-2 mb-2">
                                    @foreach($item->gambarRuangan as $gambar)
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
                                <input type="file" name="additional_images[]" multiple
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                                <p class="mt-1 text-xs text-gray-500">Tambah gambar baru (opsional)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200">
                    <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Perubahan</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-green-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5" data-modal-hide="editModal{{ $item->id }}">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Preview Gambar -->
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 // Initialize all necessary functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeModals();
    initializeImagePreviews();
    initializeDeleteButtons();
    initializeForms();
});

// Modal handling functions
function initializeModals() {
    // Toggle modal buttons
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.remove('hidden');
        });
    });

    // Close modal buttons
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-hide');
            closeModal(modalId);
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', (event) => {
        if (event.target.matches('[id^="createModal"], [id^="editModal"], [id^="deleteModal"]')) {
            closeModal(event.target.id);
        }
    });
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.add('hidden');
}

// Image preview handling
function initializeImagePreviews() {
    // Image preview modal
    const previewModal = document.getElementById('previewModal');
    const previewImage = document.getElementById('previewImage');

    // Close preview on modal background click
    previewModal?.addEventListener('click', (e) => {
        if (e.target === previewModal) closeImagePreview();
    });

    // Close preview on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !previewModal?.classList.contains('hidden')) {
            closeImagePreview();
        }
    });
}

function showImagePreview(imageSrc) {
    const previewModal = document.getElementById('previewModal');
    const previewImage = document.getElementById('previewImage');
    
    if (previewModal && previewImage) {
        previewImage.src = imageSrc;
        previewModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeImagePreview() {
    const previewModal = document.getElementById('previewModal');
    if (previewModal) {
        previewModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Form handling
function initializeForms() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', handleFormSubmit);
    });
}

async function handleFormSubmit(e) {
    e.preventDefault();
    const form = e.target;

    // Validate required fields
    const emptyFields = validateRequiredFields(form);
    if (emptyFields.length > 0) {
        showWarning(emptyFields);
        return;
    }

    // Confirm submission
    const confirmed = await confirmSubmission();
    if (!confirmed) return;

    // Submit form
    await submitFormData(form);
}

function validateRequiredFields(form) {
    const emptyFields = [];
    form.querySelectorAll('[required]').forEach(field => {
        const label = field.previousElementSibling?.textContent?.trim() || 'Field';
        if (!field.value.trim()) {
            emptyFields.push(label);
        }
    });
    return emptyFields;
}

function showWarning(emptyFields) {
    Swal.fire({
        title: 'Peringatan!',
        html: `Data berikut tidak boleh kosong:<br><strong>${emptyFields.join(', ')}</strong>`,
        icon: 'warning',
        confirmButtonColor: '#059669'
    });
}

async function confirmSubmission() {
    const result = await Swal.fire({
        title: 'Konfirmasi Data',
        text: 'Apakah Anda yakin data yang diisi sudah benar?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
    });
    return result.isConfirmed;
}

async function submitFormData(form) {
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner">Menyimpan...</span>';
    }

    try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
            method: form.method || 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            credentials: 'same-origin'
        });

        const data = await response.json();

        if (!response.ok) throw new Error(data.message || 'Network response was not ok');

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });

            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Error:', error);
        await Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: error.message || 'Terjadi kesalahan saat menyimpan data',
            timer: 2000,
            showConfirmButton: false
        });
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan';
        }
    }
}

// Delete operation handling
function initializeDeleteButtons() {
    document.querySelectorAll('.deleteImageBtn').forEach(btn => {
        btn.addEventListener('click', handleDeleteButtonClick);
    });
}

function handleDeleteButtonClick(e) {
    e.preventDefault();
    const checkbox = this.parentElement.querySelector('input[type="checkbox"]');
    const imageContainer = this.closest('.relative');
    const deleteIndicator = imageContainer.querySelector('.deleteIndicator');

    if (checkbox && deleteIndicator) {
        checkbox.checked = !checkbox.checked;
        deleteIndicator.classList.toggle('hidden', !checkbox.checked);
    }
}

async function confirmDelete(url) {
    const result = await Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data akan dinonaktifkan dan tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, nonaktifkan!',
        cancelButtonText: 'Batal'
    });

    if (!result.isConfirmed) return;

    try {
        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });

            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Error:', error);
        await Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: error.message || 'Terjadi kesalahan saat menghapus data',
            showConfirmButton: true
        });
    }
}

async function deleteImage(idSarana, idGambar) {
    const result = await Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus gambar ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    });

    if (!result.isConfirmed) return;

    await Swal.fire({
        title: 'Menghapus...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        const response = await fetch(`/admin/sarana/${idSarana}/ruangan/delete-image/${idGambar}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        });

        const data = await response.json();

        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        if (data.success) {
            const imageContainer = document.querySelector(`[data-image-id="${idGambar}"]`);
            if (imageContainer) {
                imageContainer.style.transition = 'opacity 0.3s';
                imageContainer.style.opacity = '0';
                setTimeout(() => {
                    imageContainer.remove();
                }, 300);
            }

            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            throw new Error(data.message || 'Gagal menghapus gambar');
        }
    } catch (error) {
        console.error('Error:', error);
        await Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: error.message || 'Terjadi kesalahan saat menghapus gambar',
            showConfirmButton: true
        });
    }
}
</script>
@endsection