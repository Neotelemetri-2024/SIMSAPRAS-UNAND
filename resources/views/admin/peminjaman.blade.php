@extends('layouts.main')

@section('content')

    <div class="p-4 sm:p-6">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{ $title }}</h5>
            </div>
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Form Pencarian -->
                    <form method="GET" action="{{ url()->current() }}" class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <div class="flex gap-2">
                                <input type="text" name="search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Cari data peminjaman..." value="{{ $search }}">
                                <button type="submit"
                                    class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Form Filter/Sort -->
                    <form method="GET" action="{{ url()->current() }}" class="flex gap-3">
                        <!-- Pertahankan parameter search jika ada -->
                        @if ($search)
                            <input type="hidden" name="search" value="{{ $search }}">
                        @endif

                        <div class="w-48">
                            <select name="sort"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="" {{ !request('sort') ? 'selected' : '' }}>Urutkan Tanggal</option>
                                <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Terlama</option>
                                <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Terbaru</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                            Terapkan
                        </button>
                    </form>
                </div>
            </div>
            <!-- Card Body -->
            <div class="p-5">
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Table -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Nama Peminjam</th>
                                <th scope="col" class="px-6 py-3">Instansi</th>
                                <th scope="col" class="px-6 py-3">Tanggal Peminjaman</th>
                                <th scope="col" class="px-6 py-3">Jadwal Peminjaman</th>
                                <th scope="col" class="px-6 py-3">Sarana yang Dipinjam</th>
                                <th scope="col" class="px-6 py-3">Kegiatan</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamanMasuk as $index => $item)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        {{ $loop->iteration + ($peminjamanMasuk->currentPage() - 1) * $peminjamanMasuk->perPage() }}
                                    </td>
                                    <td class="px-6 py-4">{{ $item->user->name }}</td>
                                    <td class="px-6 py-4">{{ $item->instansi }}</td>
                                    <td class="px-6 py-4">
                                        <!-- Tampilkan semua tanggal -->
                                        @foreach ($item->tanggalPeminjaman as $tanggal)
                                            <span class="block">{{ $tanggal->tanggal }}</span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">{{ $item->jadwal->shift }}</td>
                                    <td class="px-6 py-4">{{ $item->sarana->nama }}</td>
                                    <td class="px-6 py-4">{{ $item->kegiatan }}</td>
                                    <td class="px-6 py-4">
                                        @switch($item->status)
                                            @case('diajukan')
                                                <span
                                                    class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                                    <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 0C4.477 0 0 4.477 0 10c0 5.523 4.477 10 10 10s10-4.477 10-10C20 4.477 15.523 0 10 0zm1 15H9v-2h2v2zm0-4H9V5h2v6z" />
                                                    </svg>
                                                    Diajukan
                                                </span>
                                            @break

                                            @case('diproses')
                                                <span
                                                    class="inline-flex items-center bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                                    <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 0C4.477 0 0 4.477 0 10c0 5.523 4.477 10 10 10s10-4.477 10-10C20 4.477 15.523 0 10 0zm4.95 6.95-1.414-1.414L8 11.172 6.414 9.586 5 11l3 3 6.95-7.05z" />
                                                    </svg>
                                                    Diproses
                                                </span>
                                            @break

                                            @case('disetujui')
                                                <span
                                                    class="inline-flex items-center bg-green-100 text-green-800 text-sm font-medium px-3 py-1.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                    <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                    </svg>
                                                    Disetujui
                                                </span>
                                            @break

                                            @case('ditolak')
                                                <span
                                                    class="inline-flex items-center bg-red-100 text-red-800 text-sm font-medium px-3 py-1.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                    <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                                    </svg>
                                                    Ditolak
                                                </span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($item->status === 'diajukan' || $item->status === 'diproses' || auth()->user()->role === 'pimpinan')
                                            <button data-modal-target="editModal{{ $item->id }}"
                                                data-modal-toggle="editModal{{ $item->id }}"
                                                class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-yellow-300 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Improved Pagination -->
            <div class="px-6 py-4">
                @if ($peminjamanMasuk->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                        <div class="flex justify-between flex-1 sm:hidden">
                            @if ($peminjamanMasuk->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-lg">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $peminjamanMasuk->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                                    Previous
                                </a>
                            @endif

                            @if ($peminjamanMasuk->hasMorePages())
                                <a href="{{ $peminjamanMasuk->nextPageUrl() }}"
                                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                                    Next
                                </a>
                            @else
                                <span
                                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-lg">
                                    Next
                                </span>
                            @endif
                        </div>

                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 leading-5">
                                    Showing
                                    <span class="font-medium">{{ $peminjamanMasuk->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $peminjamanMasuk->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $peminjamanMasuk->total() }}</span>
                                    results
                                </p>
                            </div>

                            <div>
                                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                    {{-- Previous Page Link --}}
                                    @if ($peminjamanMasuk->onFirstPage())
                                        <span aria-disabled="true">
                                            <span
                                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-lg leading-5">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </span>
                                    @else
                                        <a href="{{ $peminjamanMasuk->previousPageUrl() }}" rel="prev"
                                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($peminjamanMasuk->getUrlRange(1, $peminjamanMasuk->lastPage()) as $page => $url)
                                        @if ($page == $peminjamanMasuk->currentPage())
                                            <span aria-current="page">
                                                <span
                                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-blue-600 bg-blue-50 border border-gray-300 cursor-default leading-5">{{ $page }}</span>
                                            </span>
                                        @else
                                            <a href="{{ $url }}"
                                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($peminjamanMasuk->hasMorePages())
                                        <a href="{{ $peminjamanMasuk->nextPageUrl() }}" rel="next"
                                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <span aria-disabled="true">
                                            <span
                                                class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-lg leading-5">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd" />
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
    <div id="createModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tambah Penjaga
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="createModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('penjaga.store') }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="nama"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kontak</label>
                            <input type="text" name="kontak"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Gedung</label>
                            <select name="idSarana"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option value="">Pilih Gedung</option>
                                @foreach ($peminjamanMasuk as $sar)
                                    <option value="{{ $sar->id }}">{{ $sar->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                        <button type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10"
                            data-modal-hide="createModal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($peminjamanMasuk as $item)
        <div id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal Header -->
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600 bg-gray-50">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Detail & Edit Peminjaman
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="editModal{{ $item->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('peminjaman.updateStatus', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="p-6 space-y-6">
                            <!-- Detail Data Section -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Detail Peminjaman
                                </h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="space-y-2">
                                        <p class="flex items-center">
                                            <span class="font-medium w-32">Nama</span>
                                            <span class="text-gray-600">: {{ $item->user->name }}</span>
                                        </p>
                                        <p class="flex items-center">
                                            <span class="font-medium w-32">Kontak</span>
                                            <span class="text-gray-600">: {{ $item->user->kontak }}</span>
                                        </p>
                                        <p class="flex items-center">
                                            <span class="font-medium w-32">Instansi</span>
                                            <span class="text-gray-600">: {{ $item->instansi }}</span>
                                        </p>

                                    </div>
                                    <div class="space-y-2">
                                        <p class="flex items-center">
                                            <span class="font-medium w-32">Gedung</span>
                                            <span class="text-gray-600">: {{ $item->sarana->nama }}</span>
                                        </p>
                                        <p class="flex items-center">
                                            <span class="font-medium w-32">Tarif</span>
                                            <span class="text-gray-600">:
                                                Rp{{ number_format($item->tarif, 0, ',', '.') }}</span>
                                        </p>
                                        <p class="flex items-center">
                                            <span class="font-medium w-32">Estimasi Peserta</span>
                                            <span class="text-gray-600">: {{ $item->estimasiPeserta }} orang</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Lampiran Section -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    Lampiran
                                </h4>
                                <div class="space-y-3">
                                    <a href="{{ asset('storage/' . $item->suratPeminjaman) }}"
                                        class="flex items-center text-blue-600 hover:text-blue-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Surat Peminjaman (PDF)
                                    </a>
                                    <a href="{{ asset('storage/' . $item->rundown) }}"
                                        class="flex items-center text-blue-600 hover:text-blue-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Rundown (PDF)
                                    </a>
                                </div>
                            </div>

                            <!-- Status Section -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Status Peminjaman
                                </h4>
                                <div class="space-y-4">
                                    <select id="statusSelect{{ $item->id }}" name="status"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        required onchange="toggleFeedbackForm({{ $item->id }})">
                                        @if ($item->tarif == 0)
                                            <option value="disetujui" @if ($item->status == 'disetujui') selected @endif>
                                                Disetujui</option>
                                        @endif
                                        <option value="ditolak" @if ($item->status == 'ditolak') selected @endif>Ditolak
                                        </option>
                                        @if ($item->tarif != 0)
                                            <option value="diproses" @if ($item->status == 'diproses') selected @endif>
                                                Diproses</option>
                                        @endif
                                    </select>

                                    <div id="feedbackForm{{ $item->id }}" class="hidden">
                                        <label class="block mb-2 text-sm font-medium text-gray-900">Feedback
                                            Penolakan</label>
                                        <textarea name="feedbackPenolakan" rows="4"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            placeholder="Masukkan alasan penolakan..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div
                            class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 bg-gray-50 rounded-b">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                            <button type="button"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 flex items-center"
                                data-modal-hide="editModal{{ $item->id }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


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

        function toggleFeedbackForm(id) {
            const status = document.getElementById(`statusSelect${id}`).value;
            const feedbackForm = document.getElementById(`feedbackForm${id}`);
            if (status === 'ditolak') {
                feedbackForm.classList.remove('hidden');
            } else {
                feedbackForm.classList.add('hidden');
            }
        }
    </script>
@endsection
