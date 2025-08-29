@extends('layouts.user')

@section('content')
<section class="bg-white pt-24 min-h-screen">
    <div class="max-w-screen-xl px-4 mx-auto lg:px-8">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-3">
                Riwayat Peminjaman
            </h2>
            <p class="text-gray-600 text-lg">
                Kelola dan pantau status peminjaman fasilitas Anda di Universitas Andalas
            </p>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Integrated Filter & Table Header -->
            <div class="border-b border-gray-200">
                <form method="GET" action="{{ url()->current() }}" class="p-6">
                    <div class="flex flex-col sm:flex-row gap-4 items-end">
                        <div class="flex-1">
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Status Peminjaman</label>
                            <select name="status" 
                                    class="w-full py-2.5 px-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                                <option value="">Semua Status</option>
                                <option value="diajukan" {{ $status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="diproses" {{ $status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="disetujui" {{ $status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ $status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="dibatalkan" {{ $status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                <option value="diajukanbatal" {{ $status == 'diajukanbatal' ? 'selected' : '' }}>Diajukan Batal</option>
                            </select>
                        </div>
                        <div class="sm:w-48">
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Urutkan</label>
                            <select name="sort" 
                                    class="w-full py-2.5 px-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                                <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            </select>
                        </div>
                        <div class="sm:w-32">
                            <button type="submit" 
                                    class="w-full h-11 text-white bg-green-500 hover:bg-green-600 font-medium rounded-xl text-sm px-4 transition-all duration-200 shadow-sm hover:shadow-md">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-gray-600">Sarana/Ruangan</th>
                            <th scope="col" class="px-6 py-4 text-gray-600">Jadwal</th>
                            <th scope="col" class="px-6 py-4 text-gray-600">Kegiatan</th>
                            <th scope="col" class="px-6 py-4 text-gray-600">Instansi</th>
                            <th scope="col" class="px-6 py-4 text-gray-600">Tarif</th>
                            <th scope="col" class="px-6 py-4 text-gray-600">Status</th>
                            <th scope="col" class="px-6 py-4 text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($peminjaman as $pinjam)
                        <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900">
                                    {{ $pinjam->ruangan ? $pinjam->ruangan->nama : $pinjam->sarana->nama }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @foreach ($pinjam->tanggalPeminjaman as $tanggal)
                                        <div class="text-green-600">
                                            {{ \Carbon\Carbon::parse($tanggal->tanggal)->locale('id')->isoFormat('DD-MM-Y') }}
                                            <div class="text-xs text-gray-500">
                                                {{ $tanggal->jadwal->mulai }} - {{ $tanggal->jadwal->selesai }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $pinjam->kegiatan }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $pinjam->instansi }}</td>
                            <td class="px-6 py-4 text-gray-600">Rp{{ number_format($pinjam->totalTarif, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if ($pinjam->status == 'diproses')
                                    @if ($pinjam->buktiPembayaran)
                                        <span class="bg-indigo-50 text-indigo-700 text-xs font-medium px-3 py-1.5 rounded-full border border-indigo-200 flex items-center w-fit gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                                            </svg>
                                            Menunggu Verifikasi
                                        </span>
                                    @else
                                        <span class="bg-yellow-50 text-yellow-700 text-xs font-medium px-3 py-1.5 rounded-full border border-yellow-200 flex items-center w-fit gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd"/>
                                            </svg>
                                            Menunggu Pembayaran
                                        </span>
                                    @endif
                                @elseif($pinjam->status == 'diajukan')
                                    <span class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-1.5 rounded-full border border-blue-200 flex items-center w-fit gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                                        </svg>
                                        Diajukan
                                    </span>
                                @elseif($pinjam->status == 'ditolak')
                                    <span class="bg-red-50 text-red-700 text-xs font-medium px-3 py-1.5 rounded-full border border-red-200 flex items-center w-fit gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                                        </svg>
                                        Ditolak
                                    </span>
                                @elseif($pinjam->status == 'disetujui')
                                    <span class="bg-emerald-50 text-emerald-700 text-xs font-medium px-3 py-1.5 rounded-full border border-emerald-200 flex items-center w-fit gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                                        </svg>
                                        Disetujui
                                    </span>
                                @elseif($pinjam->status == 'diajukanbatal')
                                <span class="bg-purple-50 text-purple-700 text-xs font-medium px-3 py-1.5 rounded-full border border-purple-200 flex items-center w-fit gap-1">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/>
                                        <path d="M8.5 8.5L15.5 15.5M15.5 8.5L8.5 15.5" 
                                              stroke="currentColor" 
                                              stroke-width="2" 
                                              stroke-linecap="round"/>
                                    </svg>
                                    Pengajuan Pembatalan
                                </span>
                                @elseif($pinjam->status == 'dibatalkan')
                                    <span class="bg-gray-50 text-gray-700 text-xs font-medium px-3 py-1.5 rounded-full border border-gray-200 flex items-center w-fit gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                                        </svg>
                                        Dibatalkan
                                    </span>
                                @elseif($pinjam->status == 'selesai')
                                <span class="bg-emerald-50 text-emerald-700 text-xs font-medium px-3 py-1.5 rounded-full border border-emerald-200 flex items-center w-fit gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                                        </svg>
                                        selesai
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" onclick="showDetailModal('{{ $pinjam->id }}')"
                                    class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all duration-200 border border-blue-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">Tidak ada riwayat peminjaman</p>
                                    <p class="text-gray-400 mt-1">Anda belum memiliki riwayat peminjaman sarana</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200">
                {{ $peminjaman->appends(['sort' => $sort, 'status' => $status])->links() }}
            </div>
        </div>
    </div>
    <!-- Modal Section -->
    @foreach ($peminjaman as $pinjam)
    <div id="detailModal{{ $pinjam->id }}" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-[60] hidden overflow-hidden flex items-center justify-center">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity" data-modal-hide="detailModal{{ $pinjam->id }}"></div>
        
        <!-- Modal Container - centered and fixed size -->
        <div class="relative z-[70] w-full max-w-2xl mx-auto px-4">
            <!-- Modal Content -->
            <div class="relative bg-white rounded-lg shadow max-h-[90vh] flex flex-col">
                <!-- Fixed Header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t sticky top-0 bg-white z-10">
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
    
                <!-- Scrollable Content -->
                <div class="flex-1 overflow-y-auto p-4 md:p-5 space-y-4">
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
                                            Rp{{ number_format($pinjam->totalTarif, 0, ',', '.') }}</span>
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
                                        <span class="font-medium text-gray-600">{{ \Carbon\Carbon::parse($tanggal->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</span>
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
                        @if ($pinjam->status == 'disetujui')
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                Surat Disposisi
                            </h4>
                            <div class="space-y-3">
                                @php
                                    $fileExtension = pathinfo($pinjam->suratDisposisi, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png']);
                                @endphp
                                
                                @if($isImage)
                                    <a href="javascript:void(0)" onclick="showImageModal('{{ asset('storage/' . $pinjam->suratDisposisi) }}')"
                                        class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 transition-colors group">
                                        <svg class="w-6 h-6 text-blue-500 group-hover:text-blue-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="ml-3 text-sm font-medium text-gray-600 group-hover:text-gray-900">Surat
                                            Disposisi (Gambar)</span>
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $pinjam->suratDisposisi) }}" target="_blank"
                                        class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 transition-colors group">
                                        <svg class="w-6 h-6 text-blue-500 group-hover:text-blue-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="ml-3 text-sm font-medium text-gray-600 group-hover:text-gray-900">Surat
                                            Disposisi (Dokumen)</span>
                                    </a>
                                @endif
                            </div>
                            <div id="imageModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
                                <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" onclick="closeImageModal()"></div>
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div class="relative bg-white rounded-lg shadow-xl max-w-3xl mx-auto">
                                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                Surat Disposisi
                                            </h3>
                                            <button type="button" onclick="closeImageModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-6 space-y-6 flex justify-center">
                                            <img id="modalImage" src="" alt="Surat Disposisi" class="max-w-full max-h-[70vh] object-contain">
                                        </div>
                                        <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b">
                                            <a id="downloadLink" href="" download class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                Download Gambar
                                            </a>
                                            <button type="button" onclick="closeImageModal()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                            
                        @endif
                        @if ($pinjam->status == 'diproses')
                            <!-- Pembayaran Section -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Detail Pembayaran
                                </h4>

                                <!-- Informasi Deadline Pembayaran -->
                                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="text-yellow-800 text-sm">
                                        <span class="font-semibold">Perhatian:</span> Pembayaran harus dilakukan maksimal 3 hari setelah pemesanan
                                        (sebelum {{ \Carbon\Carbon::parse($pinjam->diproses_at)->addDays(3)->locale('id')->IsoFormat('D MMMM Y HH:mm') }} WIB)
                                    </p>
                                </div>

                                <!-- Total yang harus dibayar -->
                                <div class="mb-6 p-4 bg-white rounded-lg border border-yellow-200">
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-sm text-gray-600">Total Pembayaran:</span>
                                        <span class="text-2xl font-bold text-gray-900">Rp{{ number_format($pinjam->totalTarif, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <div class="flex justify-between">
                                            <span>Tarif per jadwal:</span>
                                            <span>
                                                @if($pinjam->ruangan)
                                                    @if($pinjam->statusPeminjam == 'ormawa')
                                                        Rp{{ number_format($pinjam->ruangan->tariformawa, 0, ',', '.') }}
                                                    @elseif($pinjam->statusPeminjam == 'unit')
                                                        Rp{{ number_format($pinjam->ruangan->tarifunit, 0, ',', '.') }}
                                                    @else
                                                        Rp{{ number_format($pinjam->ruangan->tarifumum, 0, ',', '.') }}
                                                    @endif
                                                @else
                                                    @if($pinjam->statusPeminjam == 'ormawa')
                                                        Rp{{ number_format($pinjam->sarana->tariformawa, 0, ',', '.') }}
                                                    @elseif($pinjam->statusPeminjam == 'unit')
                                                        Rp{{ number_format($pinjam->sarana->tarifunit, 0, ',', '.') }}
                                                    @else
                                                        Rp{{ number_format($pinjam->sarana->tarifumum, 0, ',', '.') }}
                                                    @endif
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Jumlah jadwal terpakai:</span>
                                            <span>{{ count($pinjam->tanggalPeminjaman) }} jadwal</span>
                                        </div>
                                        <div class="flex justify-between text-xs italic">
                                            <span>Status pengguna:</span>
                                            <span>{{ $pinjam->statusPeminjam == 'ormawa' ? 'Ormawa' : ($pinjam->statusPeminjam == 'unit' ? 'Fakultas/Unit' : 'Umum') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Rekening -->
                                @if($rekeningAktif)
                                <div class="mb-6 p-4 bg-white rounded-lg border border-blue-200">
                                    <h5 class="font-semibold text-gray-900 mb-3">Informasi Rekening Pembayaran</h5>
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Bank</span>
                                            <span class="font-medium">{{ $rekeningAktif->nama_bank }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Nomor Rekening</span>
                                            <span class="font-medium">{{ $rekeningAktif->nomor_rekening }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Atas Nama</span>
                                            <span class="font-medium">{{ $rekeningAktif->nama_pemilik }}</span>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="mb-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                    <h5 class="font-semibold text-gray-900 mb-3">Informasi Rekening Pembayaran</h5>
                                    <p class="text-sm text-yellow-800">Informasi rekening pembayaran sedang tidak tersedia. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                </div>
                                @endif

                                <!-- Status Pembayaran dan Upload -->
                                <div class="mb-6">
                                    @if($pinjam->buktiPembayaran)
                                        <!-- Jika sudah upload bukti -->
                                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center text-green-800">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="font-medium">Bukti pembayaran telah diupload</span>
                                            </div>
                                            <div class="mt-3">
                                                <img src="{{ Storage::url($pinjam->buktiPembayaran) }}" 
                                                    alt="Bukti Pembayaran" 
                                                    class="max-w-xs rounded-lg border border-green-200">
                                            </div>
                                        </div>
                                    @else
                                        <!-- Form Upload jika belum upload -->
                                        <form action="{{ route('riwayat.upload-bukti', $pinjam->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                            @csrf
                                            <div class="flex flex-col space-y-2">
                                                <label for="buktiPembayaran" class="text-sm font-medium text-gray-700">Upload Bukti Pembayaran</label>
                                                <input type="file" 
                                                    name="buktiPembayaran" 
                                                    id="buktiPembayaran" 
                                                    accept="image/*"
                                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                                    required>
                                                <p class="text-xs text-gray-500">Format: JPG, JPEG, PNG (Max. 2MB)</p>
                                            </div>
                                            <button type="submit"
                                                class="w-full px-6 py-3 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                Upload Bukti Pembayaran
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endif

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
                                        <p class="text-sm font-medium text-gray-600">{{ $pinjam->feedbackPembatalan }}</p>
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
                                <p class="text-sm text-gray-600">Anda dapat membatalkan peminjaman ini apabila:</p>
                                <ul class="list-disc list-inside text-sm text-gray-600 ml-2">
                                    <li>Status peminjaman masih dalam tahap diajukan/diproses/disetujui</li>
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
                                    
                                    <!-- Error messages area -->
                                    @if ($errors->any())
                                    <div class="p-3 bg-red-50 text-red-800 border border-red-200 rounded mb-3">
                                        <ul class="list-disc list-inside text-sm">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    
                                    <form id="cancellationForm{{ $pinjam->id }}" action="{{ route('peminjaman.cancel', $pinjam->id) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label for="alasan_pembatalan{{ $pinjam->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                                Alasan Pembatalan <span class="text-red-500">*</span>
                                            </label>
                                            <textarea name="alasan_pembatalan" id="alasan_pembatalan{{ $pinjam->id }}" rows="4" 
                                                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 @error('alasan_pembatalan') border-red-500 @enderror"
                                                    placeholder="Mohon berikan alasan pembatalan peminjaman minimal 10 karakter" required>{{ old('alasan_pembatalan') }}</textarea>
                                            
                                            <div id="form-error-{{ $pinjam->id }}" class="hidden mt-1 text-sm text-red-600"></div>
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
        </div>
    @endforeach
 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
    function showImageModal(imageUrl) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const downloadLink = document.getElementById('downloadLink');
        
        modalImage.src = imageUrl;
        downloadLink.href = imageUrl;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function showDetailModal(id) {
        const modal = document.getElementById('detailModal' + id);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }
    
    function closeDetailModal(id) {
        const modal = document.getElementById('detailModal' + id);
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Handle ESC key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const visibleModals = document.querySelectorAll('[id^="detailModal"]:not(.hidden)');
            visibleModals.forEach(modal => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });
        }
    });

    // Handle clicking outside the modal
    document.addEventListener('click', function(event) {
        const modals = document.querySelectorAll('[id^="detailModal"]');
        modals.forEach(modal => {
            // Check if click is on backdrop (modal itself) and not on modal content
            if (event.target === modal) {
                const modalContent = modal.querySelector('.modal-content');
                if (!modalContent || !modalContent.contains(event.target)) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            }
        });
    });

    // Rest of your existing functions remain the same
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
        document.body.style.overflow = 'hidden';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah ada flash message sukses pembatalan
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        @endif

        // Cek apakah ada flash message error untuk alert
        @if(session('error') && !session('modal_open'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        @endif
        
        // Cek apakah ada flash message untuk membuka modal
        @if(session('modal_open'))
            showCancellationForm('{{ session('modal_open') }}');
        @endif
        
        // Initialize error validation untuk form-form pembatalan
        document.querySelectorAll('[id^="cancellationForm"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Dapatkan ID peminjaman dari ID form
                const peminjamanId = this.id.replace('cancellationForm', '');
                
                // Ambil input alasan
                const alasanInput = document.getElementById(`alasan_pembatalan${peminjamanId}`);
                const errorDiv = document.getElementById(`form-error-${peminjamanId}`);
                
                // Reset error
                errorDiv.classList.add('hidden');
                errorDiv.textContent = '';
                
                // Validasi panjang alasan
                if (alasanInput.value.trim().length < 10) {
                    e.preventDefault(); // Hentikan pengiriman form
                    
                    // Tampilkan pesan error
                    errorDiv.textContent = 'Alasan pembatalan minimal 10 karakter';
                    errorDiv.classList.remove('hidden');
                    
                    // Fokus ke input
                    alasanInput.focus();
                }
            });
        });
    });

    function hideCancellationForm(id) {
        document.getElementById('cancellationModal' + id).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Initialize modals when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeModals();
    });

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
                closeDetailModal(modalId.replace('detailModal', ''));
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form input[type="file"][name="buktiPembayaran"]').forEach(function(input) {
            input.form.addEventListener('submit', function(e) {
                const file = input.files[0];
                if (file && file.size > 2 * 1024 * 1024) { // 2MB
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran file terlalu besar!',
                        text: 'Ukuran maksimal file adalah 2MB.',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
@endsection