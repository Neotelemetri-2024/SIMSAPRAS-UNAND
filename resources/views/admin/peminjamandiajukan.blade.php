@extends('layouts.main')

@section('content')

    <div class="p-4 sm:p-6">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{ $title }}</h5>
            </div>
            <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row gap-4">
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

                    <form method="GET" action="{{ url()->current() }}" class="flex gap-3">
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
            <div class="p-5">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Nama Peminjam</th>
                                <th scope="col" class="px-6 py-3">Instansi</th>
                                <th scope="col" class="px-6 py-3">Tanggal & Jadwal Peminjaman</th>
                                <th scope="col" class="px-6 py-3">Sarana yang Dipinjam</th>
                                <th scope="col" class="px-6 py-3">Kegiatan</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamanDiajukan as $index => $item)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        {{ $loop->iteration + ($peminjamanDiajukan->currentPage() - 1) * $peminjamanDiajukan->perPage() }}
                                    </td>
                                    <td class="px-6 py-4">{{ $item->user->name }}</td>
                                    <td class="px-6 py-4">{{ $item->instansi }}</td>
                                    <td class="px-6 py-4">
                                        @foreach ($item->tanggalPeminjaman as $tanggal)
                                            <div class="mb-2">
                                                <div class="font-medium">{{ \Carbon\Carbon::parse($tanggal->tanggal)->format('d/m/Y') }}</div>
                                                <div class="text-sm text-gray-600">{{ $tanggal->jadwal->mulai }} - {{ $tanggal->jadwal->selesai }}</div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">{{ $item->ruangan ? $item->ruangan->nama : $item->sarana->nama }}</td>
                                    <td class="px-6 py-4">{{ $item->kegiatan }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                            <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 0C4.477 0 0 4.477 0 10c0 5.523 4.477 10 10 10s10-4.477 10-10C20 4.477 15.523 0 10 0zm1 15H9v-2h2v2zm0-4H9V5h2v6z" />
                                            </svg>
                                            Diajukan
                                        </span>
                                    </td>             
                                   <td class="px-6 py-4">
                                    <button data-modal-target="editModalDiajukan{{ $item->id }}"
                                        data-modal-toggle="editModalDiajukan{{ $item->id }}"
                                        class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                  </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="px-6 py-4">
                @if ($peminjamanDiajukan->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                        <div class="flex justify-between flex-1 sm:hidden">
                            @if ($peminjamanDiajukan->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-lg">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $peminjamanDiajukan->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                                    Previous
                                </a>
                            @endif

                            @if ($peminjamanDiajukan->hasMorePages())
                                <a href="{{ $peminjamanDiajukan->nextPageUrl() }}"
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
                                    <span class="font-medium">{{ $peminjamanDiajukan->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $peminjamanDiajukan->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $peminjamanDiajukan->total() }}</span>
                                    results
                                </p>
                            </div>

                            <div>
                                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                    @if ($peminjamanDiajukan->onFirstPage())
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
                                        <a href="{{ $peminjamanDiajukan->previousPageUrl() }}" rel="prev"
                                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif

                                    @foreach ($peminjamanDiajukan->getUrlRange(1, $peminjamanDiajukan->lastPage()) as $page => $url)
                                        @if ($page == $peminjamanDiajukan->currentPage())
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

                                    @if ($peminjamanDiajukan->hasMorePages())
                                        <a href="{{ $peminjamanDiajukan->nextPageUrl() }}" rel="next"
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

@foreach ($peminjamanDiajukan as $item)
<div id="editModalDiajukan{{ $item->id }}" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-[60] hidden overflow-hidden" data-modal-backdrop="static">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="editModalDiajukan{{ $item->id }}"></div>
        
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-2xl">
                <div class="relative flex flex-col max-h-[90vh] bg-white rounded-lg shadow">
                    <div class="sticky top-0 z-10 flex items-start justify-between p-5 border-b rounded-t bg-gray-50">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Detail Peminjaman
                        </h3>
                        <button class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="editModalDiajukan{{ $item->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto">
                        <div class="p-6 space-y-6">
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Informasi Peminjam
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
                                            <span class="font-medium w-32">Status</span>
                                            <span class="text-gray-600">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Diajukan
                                                </span>
                                            </span>
                                        </p>
                                        <p class="flex items-center">
                                            <span class="font-medium w-32">Tanggal Pengajuan</span>
                                            <span class="text-gray-600">: {{ $item->created_at->format('d/m/Y H:i') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Detail Peminjaman
                                </h4>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div class="space-y-2">
                                            <p class="flex items-center">
                                                <span class="font-medium w-32">Gedung/Sarana</span>
                                                <span class="text-gray-600">: {{ $item->sarana->nama }}</span>
                                            </p>
                                            <p class="flex items-center">
                                                <span class="font-medium w-32">Kegiatan</span>
                                                <span class="text-gray-600">: {{ $item->kegiatan }}</span>
                                            </p>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="flex items-center">
                                                <span class="font-medium w-32">Total Tarif</span>
                                                <span class="text-gray-600">: Rp{{ number_format($item->totalTarif, 0, ',', '.') }}</span>
                                            </p>
                                            <p class="flex items-center">
                                                <span class="font-medium w-32">Estimasi Peserta</span>
                                                <span class="text-gray-600">: {{ $item->estimasiPeserta }} orang</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <h5 class="font-medium mb-2">Jadwal Peminjaman:</h5>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            @foreach ($item->tanggalPeminjaman as $tanggal)
                                                <div class="mb-2 last:mb-0">
                                                    <div class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($tanggal->tanggal)->format('d/m/Y') }}</div>
                                                    <div class="text-sm text-gray-600">{{ $tanggal->jadwal->mulai }} - {{ $tanggal->jadwal->selesai }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($item->diajukan_at)
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Riwayat Status
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex items-center text-blue-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <span class="font-medium">Diajukan</span>
                                            <div class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($item->diajukan_at)->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    Lampiran
                                </h4>
                                <div class="space-y-3">
                                    @if($item->suratPeminjaman)
                                        <a href="{{ asset('storage/' . $item->suratPeminjaman) }}"
                                            class="flex items-center text-blue-600 hover:text-blue-700 transition-colors" target="_blank">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Surat Peminjaman
                                        </a>
                                    @endif

                                    @if($item->rundown)
                                        <a href="{{ asset('storage/' . $item->rundown) }}"
                                            class="flex items-center text-blue-600 hover:text-blue-700 transition-colors" target="_blank">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Rundown Kegiatan
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <form id="updateForm{{ $item->id }}" 
                                  action="{{ route('peminjaman.updateStatusDiajukan', $item->id) }}" 
                                  method="POST">
                                @csrf
                                @method('PUT')
                                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Aksi
                                    </h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                                            <select id="statusSelect{{ $item->id }}" name="status"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                                required onchange="handleStatusChange({{ $item->id }})">
                                                <option value="">Pilih Status</option>
                                                @if($item->totalTarif == 0)
                                                    <option value="disetujui">Setujui</option>
                                                @endif
                                                <option value="ditolak">Tolak</option>
                                                @if($item->totalTarif > 0)
                                                    <option value="diproses">Proses</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div id="fileUploadForm{{ $item->id }}" class="hidden">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Upload Surat Disposisi
                                            </label>
                                            <div class="mt-2">
                                                <div class="relative border-2 border-gray-300 border-dashed rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition-all duration-200">
                                                    <input type="file" 
                                                           id="dropzone-file{{ $item->id }}" 
                                                           name="suratDisposisi" 
                                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                           required 
                                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                           onchange="updateFileInfo(this, 'fileInfo{{ $item->id }}')">
                                                    <div class="text-center" id="fileInfo{{ $item->id }}">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                        </svg>
                                                        <p class="mt-2 text-sm text-gray-600">
                                                            <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                                        </p>
                                                        <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX, JPG, JPEG, atau PNG (Maks. 2MB)</p>
                                                    </div>
                                                    <div id="filePreview{{ $item->id }}" class="hidden mt-3">
                                                        <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200">
                                                            <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                            </svg>
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-sm font-medium text-gray-900 truncate" id="fileName{{ $item->id }}"></p>
                                                                <p class="text-sm text-gray-500" id="fileSize{{ $item->id }}"></p>
                                                            </div>
                                                            <button type="button" onclick="removeFile('dropzone-file{{ $item->id }}', 'fileInfo{{ $item->id }}', 'filePreview{{ $item->id }}')"
                                                                    class="ml-3 text-sm font-medium text-red-500 hover:text-red-600 p-1">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('suratDisposisi')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>                      

                                        <div id="feedbackForm{{ $item->id }}" class="hidden">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Alasan Penolakan
                                            </label>
                                            <textarea name="feedbackPenolakan" rows="3"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                                                placeholder="Masukkan alasan penolakan..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 bg-gray-50 rounded-b">
                        <button type="button" onclick="handleSubmit({{ $item->id }})"
                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Simpan Perubahan
                        </button>
                        
                        @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'pimpinan')
                        <button data-modal-toggle="batalModalDiajukan{{ $item->id }}"
                            data-modal-target="batalModalDiajukan{{ $item->id }}"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Batalkan Peminjaman
                        </button>
                        @endif

                        <button 
                            data-modal-hide="editModalDiajukan{{ $item->id }}"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

@endforeach
@foreach ($peminjamanDiajukan as $item)
<div id="batalModalDiajukan{{ $item->id }}" tabindex="-1" aria-hidden="true" 
    class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden" data-modal-backdrop="static">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="batalModalDiajukan{{ $item->id }}"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative w-full max-w-md">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Pembatalan Peminjaman
                    </h3>
                    <button type="button" 
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="batalModalDiajukan{{ $item->id }}"
                        onclick="closeModal('batalModalDiajukan{{ $item->id }}')">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Apakah Anda yakin ingin membatalkan peminjaman ini? Harap berikan alasan pembatalan:
                    </p>
                    <div class="mt-4">
                        <textarea id="feedbackPembatalan{{ $item->id }}" 
                            rows="4" 
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" 
                            placeholder="Masukkan alasan pembatalan..."></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" 
                        onclick="konfirmasiBatalkan({{ $item->id }})"
                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batalkan Peminjaman
                    </button>
                    <button data-modal-hide="batalModalDiajukan{{ $item->id }}"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

    function updateFileInfo(input, infoId) {
        const file = input.files[0];
        if (!file) {
            resetFileInput(input.id, infoId, infoId.replace('fileInfo', 'filePreview'));
            return;
        }

        // Validasi ukuran file (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Ukuran file tidak boleh lebih dari 2MB!',
                confirmButtonColor: '#3085d6'
            });
            resetFileInput(input.id, infoId, infoId.replace('fileInfo', 'filePreview'));
            return;
        }

        const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'File harus berupa PDF, DOC/DOCX, atau gambar (JPG, JPEG, PNG)!',
                confirmButtonColor: '#3085d6'
            });
            resetFileInput(input.id, infoId, infoId.replace('fileInfo', 'filePreview'));
            return;
        }

        // Format ukuran file
        const size = (file.size / 1024).toFixed(2);
        const formattedSize = size > 1024 ? (size / 1024).toFixed(2) + ' MB' : size + ' KB';

        // Update tampilan
        const fileInfo = document.getElementById(infoId);
        const filePreview = document.getElementById(infoId.replace('fileInfo', 'filePreview'));
        const fileName = document.getElementById(infoId.replace('fileInfo', 'fileName'));
        const fileSize = document.getElementById(infoId.replace('fileInfo', 'fileSize'));

        fileInfo.classList.add('hidden');
        filePreview.classList.remove('hidden');
        fileName.textContent = file.name;
        fileSize.textContent = formattedSize;
    }

    function removeFile(inputId, infoId, previewId) {
        resetFileInput(inputId, infoId, previewId);
    }

    function resetFileInput(inputId, infoId, previewId) {
        const input = document.getElementById(inputId);
        const info = document.getElementById(infoId);
        const preview = document.getElementById(previewId);
        
        if (input) input.value = '';
        if (info) info.classList.remove('hidden');
        if (preview) preview.classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        initializeModals();
        initializeFileUploads();
    });

    function initializeModals() {
        document.querySelectorAll('[data-modal-target]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = button.getAttribute('data-modal-target');
                openModal(modalId);
            });
        });

        document.querySelectorAll('[data-modal-hide]').forEach(element => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = element.getAttribute('data-modal-hide');
                closeModal(modalId);
            });
        });

        window.addEventListener('click', (event) => {
            const modals = document.querySelectorAll('[id^="editModalDiajukan"]');
            modals.forEach(modal => {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        });
    }

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            
            const id = modalId.replace('editModalDiajukan', '');
            const form = document.getElementById(`updateForm${id}`);
            if (form) {
                form.reset();
                toggleFeedbackForm(id);
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form[id^="updateForm"]');
        forms.forEach(form => {
            const itemId = form.id.replace('updateForm', '');
            const fileInput = document.getElementById(`dropzone-file${itemId}`);
            const fileNameDisplay = document.getElementById(`file-name${itemId}`);
            
            if (fileInput && fileNameDisplay) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        const fileName = this.files[0].name;
                        fileNameDisplay.textContent = `File terpilih: ${fileName}`;
                    } else {
                        fileNameDisplay.textContent = '';
                    }
                });
            }
        });
    });

    function initializeFileUploads() {
        const forms = document.querySelectorAll('form[id^="updateForm"]');
        forms.forEach(form => {
            const id = form.id.replace('updateForm', '');
            const fileInput = document.getElementById(`dropzone-file${id}`);
            const fileNameDisplay = document.getElementById(`file-name${id}`);
            
            if (fileInput && fileNameDisplay) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        const file = this.files[0];
                        if (file.size > 2 * 1024 * 1024) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Ukuran file tidak boleh lebih dari 2MB!',
                                confirmButtonColor: '#3085d6'
                            });
                            this.value = '';
                            fileNameDisplay.textContent = '';
                            return;
                        }
                        
                        const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg'];
                        if (!validTypes.includes(file.type)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'File harus berupa PDF, DOC/DOCX, atau gambar (JPG, JPEG, PNG)!',
                                confirmButtonColor: '#3085d6'
                            });
                            this.value = '';
                            fileNameDisplay.textContent = '';
                            return;
                        }
                        
                        fileNameDisplay.textContent = `File terpilih: ${file.name}`;
                    } else {
                        fileNameDisplay.textContent = '';
                    }
                });
            }
        });
    }

    function handleStatusChange(id) {
        const statusSelect = document.getElementById(`statusSelect${id}`);
        const feedbackForm = document.getElementById(`feedbackForm${id}`);
        const fileUploadForm = document.getElementById(`fileUploadForm${id}`);
        const fileInput = document.getElementById(`dropzone-file${id}`);
        
        feedbackForm.classList.add('hidden');
        fileUploadForm.classList.add('hidden');
        
        const textarea = feedbackForm.querySelector('textarea');
        if (textarea) textarea.removeAttribute('required');
        if (fileInput) {
            fileInput.removeAttribute('required');
            resetFileInput(
                `dropzone-file${id}`, 
                `fileInfo${id}`, 
                `filePreview${id}`
            );
        }
        
        if (statusSelect.value === 'ditolak') {
            feedbackForm.classList.remove('hidden');
            textarea.setAttribute('required', 'required');
        } else if (statusSelect.value === 'disetujui') {
            fileUploadForm.classList.remove('hidden');
            fileInput.setAttribute('required', 'required');
        }
    }

    function handleSubmit(id) {
        const form = document.getElementById(`updateForm${id}`);
        const statusSelect = document.getElementById(`statusSelect${id}`);
        const status = statusSelect.value;

        if (!status) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Silakan pilih status terlebih dahulu!',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        if (status === 'ditolak') {
            const feedback = form.querySelector('textarea[name="feedbackPenolakan"]').value;
            if (!feedback.trim()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Mohon isi alasan penolakan!',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
        } else if (status === 'disetujui') {
            const fileInput = document.getElementById(`dropzone-file${id}`);
            if (!fileInput.files.length) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Mohon upload dokumen persetujuan!',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
        }

        const confirmConfig = getConfirmationConfig(status);
        Swal.fire({
            title: confirmConfig.title,
            text: confirmConfig.text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm(id);
            }
        });
    }


    function getConfirmationConfig(status) {
        const configs = {
            'disetujui': {
                title: 'Konfirmasi Persetujuan',
                text: 'Apakah Anda yakin ingin menyetujui peminjaman ini?'
            },
            'ditolak': {
                title: 'Konfirmasi Penolakan',
                text: 'Apakah Anda yakin ingin menolak peminjaman ini?'
            },
            'diproses': {
                title: 'Konfirmasi Pemrosesan',
                text: 'Apakah Anda yakin ingin memproses peminjaman ini?'
            }
        };

        return configs[status] || {
            title: 'Konfirmasi Perubahan',
            text: 'Apakah Anda yakin ingin mengubah status peminjaman ini?'
        };
    }

    function submitForm(id) {
        const form = document.getElementById(`updateForm${id}`);
        const formData = new FormData(form);
        const status = document.getElementById(`statusSelect${id}`).value;

        Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const successMessage = getSuccessMessage(status);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: successMessage,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            } else {
                throw new Error(data.message || 'Terjadi kesalahan saat memperbarui status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: error.message || 'Terjadi kesalahan saat memproses permintaan',
                confirmButtonColor: '#3085d6'
            });
        });
    }

    function getSuccessMessage(status) {
        const messages = {
            'disetujui': 'Peminjaman berhasil disetujui',
            'ditolak': 'Peminjaman berhasil ditolak',
            'diproses': 'Peminjaman berhasil diproses'
        };

        return messages[status] || 'Status peminjaman berhasil diperbarui';
    }

    function konfirmasiBatalkan(id) {
        const feedbackPembatalan = document.getElementById(`feedbackPembatalan${id}`).value;
            
        if (!feedbackPembatalan.trim()) {
            Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Harap isi alasan pembatalan!',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Pembatalan',
                text: "Apakah Anda yakin ingin membatalkan peminjaman ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Siapkan data untuk dikirim
                    const formData = new FormData();
                    formData.append('status', 'dibatalkan');
                    formData.append('feedbackPembatalan', feedbackPembatalan);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    formData.append('_method', 'PUT');

                    // Kirim request dengan FormData
                    fetch(`/admin/peminjaman/${id}/update-status-diajukan`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Tutup modal pembatalan
                            const modal = document.getElementById(`batalModalDiajukan${id}`);
                            if (modal) {
                                modal.classList.add('hidden');
                                document.body.classList.remove('overflow-hidden');
                            }

                            // Tampilkan pesan sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Peminjaman berhasil dibatalkan',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan saat membatalkan peminjaman');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: error.message || 'Terjadi kesalahan saat memproses pembatalan',
                            confirmButtonColor: '#3085d6'
                        });
                    });
                }
            });
        }
    </script>
@endsection
