@extends('layouts.user')

@section('content')
<div class="py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-2xl font-bold mb-6">Form Pengajuan Peminjaman</h1>

            <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idSarana" value="{{ $sarana->id }}">
                <input type="hidden" name="selected_dates" value="{{ $selectedDates }}">

                <!-- Informasi Sarana & Ruangan -->
                <div class="bg-gray-50 p-4 rounded-lg mb-8">
                    <h2 class="font-semibold text-lg mb-4">Informasi Fasilitas</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="mb-2"><span class="font-medium">Sarana:</span> {{ $sarana->nama }}</p>
                            @if(isset($ruangan))
                                <input type="hidden" name="idRuangan" value="{{ $ruangan->id }}">
                                <p class="mb-2"><span class="font-medium">Ruangan:</span> {{ $ruangan->nama }}</p>
                                <p><span class="font-medium">Kapasitas:</span> {{ $ruangan->kapasitas }} orang</p>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-medium mb-2">Tanggal Peminjaman:</h3>
                            <div class="space-y-1">
                                @foreach(json_decode($selectedDates) as $date)
                                    <div class="bg-white p-2 rounded text-sm">
                                        {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Fields in Two Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Kegiatan -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kegiatan</label>
                            <input type="text" name="kegiatan" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                   value="{{ old('kegiatan') }}" required>
                            @error('kegiatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Instansi -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Instansi</label>
                            <input type="text" name="instansi" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                   value="{{ old('instansi') }}" required>
                            @error('instansi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jadwal -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Penggunaan</label>
                            <select name="idJadwal" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                @foreach($jadwals as $jadwal)
                                    <option value="{{ $jadwal->id }}">{{ $jadwal->mulai }} - {{ $jadwal->selesai }}</option>
                                @endforeach
                            </select>
                            @error('idJadwal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estimasi Peserta -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Estimasi Jumlah Peserta
                                @if(isset($ruangan))
                                    <span class="text-gray-500">(Maks. {{ $ruangan->kapasitas }} orang)</span>
                                @endif
                            </label>
                            <input type="number" name="estimasiPeserta" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                                   value="{{ old('estimasiPeserta') }}" 
                                   required
                                   @if(isset($ruangan)) max="{{ $ruangan->kapasitas }}" @endif>
                            @error('estimasiPeserta')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Surat Peminjaman -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Surat Peminjaman</label>
                            <div class="mt-2">
                                <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-4h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                <span>Upload file</span>
                                                <input type="file" name="suratPeminjaman" class="sr-only" required accept=".pdf,.doc,.docx">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 2MB</p>
                                    </div>
                                </div>
                            </div>
                            @error('suratPeminjaman')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rundown -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rundown Acara</label>
                            <div class="mt-2">
                                <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-4h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                <span>Upload file</span>
                                                <input type="file" name="rundown" class="sr-only" required accept=".pdf,.doc,.docx">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 2MB</p>
                                    </div>
                                </div>
                            </div>
                            @error('rundown')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" onclick="history.back()" 
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection