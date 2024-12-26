@extends('layouts.user')

@section('content')
    <div class="py-24 px-4 mx-auto max-w-screen-xl">
        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg">
            <div class="flex items-center justify-between p-4 bg-white">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Riwayat Peminjaman</h2>
                    <p class="mt-1 text-sm text-gray-500">Daftar riwayat peminjaman sarana dan prasarana</p>
                </div>

                <!-- Sort Dropdown -->
                <div class="relative">
                    <form method="GET" action="{{ url()->current() }}" class="flex items-center space-x-3">
                        <label for="sort" class="text-sm font-medium text-gray-600">Urutkan:</label>
                        <div class="relative inline-block">
                            <select name="sort" id="sort" onchange="this.form.submit()"
                                class="appearance-none bg-gradient-to-r from-white to-gray-50 border border-gray-300 text-gray-700 py-2.5 px-4 pr-8 rounded-lg hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent shadow-sm">
                                <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>
                                    Terbaru ↓
                                </option>
                                <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>
                                    Terlama ↑
                                </option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Sarana</th>
                        <th scope="col" class="px-6 py-3">Jadwal</th>
                        <th scope="col" class="px-6 py-3">Kegiatan</th>
                        <th scope="col" class="px-6 py-3">Instansi</th>
                        <th scope="col" class="px-6 py-3">Tarif</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $pinjam)
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $pinjam->sarana->nama }}
                            </td>
                            <td class="px-6 py-4 text-green-500">
    @foreach ($pinjam->tanggalPeminjaman as $tanggal)
        {{ $tanggal->tanggal }}<br>
        <span class="text-xs text-gray-500">
            {{ $tanggal->jadwal->mulai }} - {{ $tanggal->jadwal->selesai }}
        </span><br>
    @endforeach
</td>
                            <td class="px-6 py-4">
                                {{ $pinjam->kegiatan }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $pinjam->instansi }}
                            </td>
                            <td class="px-6 py-4">
                                Rp{{ number_format($pinjam->tarif, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $displayStatus = ucfirst($pinjam->status);
                                @endphp

                                @if ($pinjam->status == 'diproses')
                                    @if ($pinjam->buktiPembayaran)
                                        <span
                                            class="bg-indigo-100 text-indigo-800 text-xs font-medium px-3 py-1.5 rounded-full border border-indigo-400 flex items-center w-fit gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                class="w-4 h-4">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Menunggu Verifikasi
                                        </span>
                                    @else
                                        <span
                                            class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1.5 rounded-full border border-yellow-400 flex items-center w-fit gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                class="w-4 h-4">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Menunggu Pembayaran
                                        </span>
                                    @endif
                                @elseif($pinjam->status == 'diajukan')
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1.5 rounded-full border border-blue-400 flex items-center w-fit gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-4 h-4">
                                            <path
                                                d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                        </svg>
                                        {{ $displayStatus }}
                                    </span>
                                @elseif($pinjam->status == 'ditolak')
                                    <span
                                        class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1.5 rounded-full border border-red-400 flex items-center w-fit gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $displayStatus }}
                                    </span>
                                @elseif($pinjam->status == 'disetujui')
                                    <span
                                        class="bg-emerald-100 text-emerald-800 text-xs font-medium px-3 py-1.5 rounded-full border border-emerald-400 flex items-center w-fit gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $displayStatus }}
                                    </span>
                                @elseif($pinjam->status == "diajukanbatal")
                                    <span
                                        class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                        <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 0C4.477 0 0 4.477 0 10c0 5.523 4.477 10 10 10s10-4.477 10-10C20 4.477 15.523 0 10 0zm1 15H9v-2h2v2zm0-4H9V5h2v6z" />
                                        </svg>
                                        Pembatalan Diajukan
                                    </span>
                                @elseif($pinjam->status == "dibatalkan")
                                    <span
                                        class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1.5 rounded-full border border-red-400 flex items-center w-fit gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $displayStatus }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" onclick="showDetailModal('{{ $pinjam->id }}')"
                                    class="p-2 text-blue-700 bg-blue-100 hover:bg-blue-200 rounded-lg transition-all duration-200 border border-blue-200 hover:border-blue-300 focus:ring-2 focus:ring-blue-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data peminjaman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination section -->
            <div class="p-4">
                {{ $peminjaman->appends(['sort' => $sort])->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Section -->
    @foreach ($peminjaman as $pinjam)
        <div id="detailModal{{ $pinjam->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full bg-black bg-opacity-50 flex items-center justify-center overflow-x-hidden overflow-y-auto">
            <div class="relative w-full max-w-2xl max-h-full mx-4">
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Detail Peminjaman
                        </h3>
                        <button type="button" onclick="closeDetailModal('{{ $pinjam->id }}')"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <!-- Detail Data Section -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi Peminjam
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <p class="flex items-center text-sm">
                                        <span class="font-medium w-32">Nama</span>
                                        <span class="text-gray-600">: {{ $pinjam->user->name }}</span>
                                    </p>
                                    <p class="flex items-center text-sm">
                                        <span class="font-medium w-32">Kontak</span>
                                        <span class="text-gray-600">: {{ $pinjam->user->kontak }}</span>
                                    </p>
                                    <p class="flex items-center text-sm">
                                        <span class="font-medium w-32">Instansi</span>
                                        <span class="text-gray-600">: {{ $pinjam->instansi }}</span>
                                    </p>
                                </div>
                                <div class="space-y-2">
                                    <p class="flex items-center text-sm">
                                        <span class="font-medium w-32">Sarana</span>
                                        <span class="text-gray-600">: {{ $pinjam->sarana->nama }}</span>
                                    </p>
                                    <p class="flex items-center text-sm">
                                        <span class="font-medium w-32">Tarif</span>
                                        <span class="text-gray-600">:
                                            Rp{{ number_format($pinjam->tarif, 0, ',', '.') }}</span>
                                    </p>
                                    <p class="flex items-center text-sm">
                                        <span class="font-medium w-32">Estimasi Peserta</span>
                                        <span class="text-gray-600">: {{ $pinjam->estimasiPeserta }} orang</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                  <!-- Jadwal Section -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Jadwal Peminjaman
                            </h4>
                            <div class="space-y-2">
                                @foreach ($pinjam->tanggalPeminjaman as $tanggal)
                                    <div class="flex items-center text-sm bg-white p-2 rounded-lg border border-gray-100">
                                        <span class="font-medium text-gray-600">{{ $tanggal->tanggal }}</span>
                                        <span class="mx-2 text-gray-400">|</span>
                                        <span class="text-gray-500">{{ $tanggal->jadwal->mulai }} - {{ $tanggal->jadwal->selesai }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Lampiran Section -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                Lampiran
                            </h4>
                            <div class="space-y-3">
                                <a href="{{ asset('storage/' . $pinjam->suratPeminjaman) }}" target="_blank"
                                    class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 transition-colors group">
                                    <svg class="w-6 h-6 text-blue-500 group-hover:text-blue-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="ml-3 text-sm font-medium text-gray-600 group-hover:text-gray-900">Surat
                                        Peminjaman</span>
                                </a>
                                <a href="{{ asset('storage/' . $pinjam->rundown) }}" target="_blank"
                                    class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 transition-colors group">
                                    <svg class="w-6 h-6 text-blue-500 group-hover:text-blue-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="ml-3 text-sm font-medium text-gray-600 group-hover:text-gray-900">Rundown
                                        Acara</span>
                                </a>
                            </div>
                        </div>

                        <!-- Status Section -->
                        @if($pinjam->status == 'ditolak')
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    Feedback Penolakan
                                </h4>
                                <div class="space-y-3">
                                    <div class="p-3 bg-white rounded-lg border border-gray-200">
                                        <p class="text-sm font-medium text-gray-600">{{ $pinjam->feedbackPenolakan }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($pinjam->status == 'diproses' && empty($pinjam->buktiPembayaran))
                            <!-- Pembayaran Section -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Pembayaran
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Form Upload Bukti -->
                                    <div class="space-y-3">
                                        <p class="text-sm font-medium text-gray-700">Upload Bukti Pembayaran</p>
                                        <form action="{{ route('riwayat.upload-bukti', $pinjam->id) }}" method="POST"
                                            enctype="multipart/form-data" class="space-y-4">
                                            @csrf
                                            <div class="flex flex-col space-y-2">
                                                <div class="flex justify-center items-center w-full">
                                                    <label
                                                        class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-50 relative">
                                                        <div class="flex flex-col justify-center items-center pt-5 pb-6"
                                                            id="placeholder-{{ $pinjam->id }}">
                                                            <svg class="w-8 h-8 mb-3 text-gray-400"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                            </svg>
                                                            <p class="mb-2 text-sm text-gray-500">
                                                                <span class="font-semibold">Klik untuk upload</span>
                                                            </p>
                                                            <p class="text-xs text-gray-500">PNG, JPG atau JPEG (Max. 2MB)
                                                            </p>
                                                        </div>
                                                        <div id="preview-{{ $pinjam->id }}"
                                                            class="absolute inset-0 flex items-center justify-center hidden">
                                                            <img id="preview-image-{{ $pinjam->id }}"
                                                                class="max-h-full rounded-lg object-contain" />
                                                        </div>
                                                        <input type="file" name="buktiPembayaran" class="hidden"
                                                            accept="image/*" required
                                                            onchange="previewImage(this, {{ $pinjam->id }})" />
                                                    </label>
                                                </div>
                                                <button type="submit"
                                                    class="w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    Upload Bukti Pembayaran
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Informasi Rekening -->
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <div class="space-y-3">
                                            <h5 class="text-sm font-medium text-gray-900">Informasi Rekening</h5>
                                            <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                                <div class="flex items-center space-x-3 mb-3">
                                                    <svg class="w-5 h-5 text-yellow-700"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <p class="text-sm text-yellow-700 font-medium">Pembayaran dapat
                                                        dilakukan melalui:</p>
                                                </div>
                                                <div class="space-y-2">
                                                    <div
                                                        class="flex items-center justify-between bg-white p-3 rounded-lg border border-yellow-200">
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">Bank BRI</p>
                                                            <p class="text-sm text-gray-600">a.n. UPT Graha Universitas</p>
                                                        </div>
                                                        <p class="text-sm font-mono font-medium text-gray-900">
                                                            1234-5678-9012-3456</p>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-2">
                                                        <p>* Mohon transfer sesuai dengan nominal yang tertera</p>
                                                        <p>* Simpan bukti pembayaran dan upload pada form di samping</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (($pinjam->status == "diajukan" && $pinjam->alasanTolakBatal ) || ($pinjam->status == "disetujui" && $pinjam->alasanTolakBatal))
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Alasan Pembatalan Ditolak
                                </h4>
                                <div class="space-y-3">
                                    <div class="p-3 bg-white rounded-lg border border-gray-200">
                                        <p class="text-sm font-medium text-gray-600">{{ $pinjam->alasanTolakBatal }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($pinjam->status == "diajukanbatal")
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Alasan Pembatalan
                                </h4>
                                <div class="space-y-3">
                                    <div class="p-3 bg-white rounded-lg border border-gray-200">
                                        <p class="text-sm font-medium text-gray-600">{{ $pinjam->alasanPembatalan }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($pinjam->status == "dibatalkan")
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Alasan Pembatalan
                                </h4>
                                <div class="space-y-3">
                                    <div class="p-3 bg-white rounded-lg border border-gray-200">
                                        <p class="text-sm font-medium text-gray-600">{{ $pinjam->alasanPembatalan }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($pinjam->canBeCancelled())
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Pembatalan Peminjaman
                                </h4>
                                <div class="space-y-3">
                                    <p class="text-sm text-gray-600">Anda dapat membatalkan peminjaman ini karena:</p>
                                    <ul class="list-disc list-inside text-sm text-gray-600 ml-2">
                                        <li>Status peminjaman masih dalam tahap {{$pinjam->status}}</li>
                                        <li>Masih lebih dari 3 hari sebelum tanggal peminjaman</li>
                                    </ul>
                                    <button onclick="showCancellationForm('{{ $pinjam->id }}')"
                                            class="w-full mt-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors">
                                        Batalkan Peminjaman
                                    </button>
                                </div>
                            </div>  
                        <!-- Cancellation Form Modal -->
                        <div id="cancellationModal{{ $pinjam->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                            <div class="min-h-screen px-4 text-center flex items-center justify-center">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                                
                                <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Konfirmasi Pembatalan</h3>
                                    
                                    <form action="{{ route('peminjaman.cancel', $pinjam->id) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label for="alasan_pembatalan" class="block text-sm font-medium text-gray-700 mb-2">
                                                Alasan Pembatalan <span class="text-red-500">*</span>
                                            </label>
                                            <textarea name="alasan_pembatalan" id="alasan_pembatalan" rows="4" 
                                                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                                                    placeholder="Mohon berikan alasan pembatalan peminjaman minimal 10 karakter" required></textarea>
                                        </div>
                                        
                                        <div class="flex items-center justify-end space-x-3">
                                            <button type="button" onclick="hideCancellationForm('{{ $pinjam->id }}')"
                                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-sm font-medium">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium">
                                                Konfirmasi Pembatalan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Script untuk modal -->
    <script>
        function showDetailModal(id) {
            console.log('Showing modal for ID:', id);
            const modal = document.getElementById('detailModal' + id);
            console.log('Modal element:', modal);

            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                console.error('Modal not found for ID:', id);
            }
        }

        function closeDetailModal(id) {
            const modal = document.getElementById('detailModal' + id);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('[id^="detailModal"]');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });
        });

        function previewImage(input, id) {
            const placeholder = document.getElementById(`placeholder-${id}`);
            const preview = document.getElementById(`preview-${id}`);
            const previewImg = document.getElementById(`preview-image-${id}`);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    placeholder.classList.add('hidden');
                    preview.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        function showCancellationForm(id) {
            document.getElementById('cancellationModal' + id).classList.remove('hidden');
            // Prevent main modal from scrolling
            document.body.style.overflow = 'hidden';
        }

        function hideCancellationForm(id) {
            document.getElementById('cancellationModal' + id).classList.add('hidden');
            // Restore scrolling
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection
