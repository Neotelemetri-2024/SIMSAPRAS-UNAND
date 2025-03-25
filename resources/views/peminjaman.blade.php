@extends('layouts.user')

@section('content')
<div class="pt-24 pb-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <!-- Header Section -->
            <div class="p-8 border-b border-gray-100">
                <h1 class="text-3xl font-bold text-gray-900 ">Form Pengajuan Peminjaman</h1>
                <p class="mt-2 text-gray-600">Silakan lengkapi form berikut untuk mengajukan peminjaman fasilitas.</p>
            </div>

            <form id="peminjamanForm" action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idSarana" value="{{ $sarana->id }}">
                <input type="hidden" name="selected_dates" value="{{ $selectedDates }}">

                <div class="p-8 space-y-8">
                    <!-- Informasi Fasilitas -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Informasi Fasilitas
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white p-6 rounded-xl border border-gray-200 hover:border-green-200 transition-all duration-200">
                                <p class="mb-3 flex items-center text-gray-700">
                                    <span class="font-medium w-24">Sarana:</span> 
                                    <span class="text-gray-900">{{ $sarana->nama }}</span>
                                </p>
                                @if(isset($ruangan))
                                    <input type="hidden" name="idRuangan" value="{{ $ruangan->id }}">
                                    <p class="mb-3 flex items-center text-gray-700">
                                        <span class="font-medium w-24">Ruangan:</span>
                                        <span class="text-gray-900">{{ $ruangan->nama }}</span>
                                    </p>
                                    <p class="flex items-center text-gray-700">
                                        <span class="font-medium w-24">Kapasitas:</span>
                                        <span class="text-gray-900">{{ $ruangan->kapasitas }} orang</span>
                                    </p>
                                @endif
                            </div>
                            <div class="bg-white p-6 rounded-xl border border-gray-200 hover:border-green-200 transition-all duration-200">
                                <h3 class="font-medium text-gray-900 mb-4">Tanggal Peminjaman:</h3>
                                <div class="space-y-3">
                                    @foreach(json_decode($selectedDates) as $date)
                                        <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-100 text-gray-700">
                                            {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal per Tanggal -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Jadwal per Tanggal
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach(json_decode($selectedDates) as $date)
                                <div class="bg-white p-6 rounded-xl border border-gray-200 hover:border-green-200 transition-all duration-200">
                                    <p class="font-medium text-gray-900 mb-4">
                                        {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                    </p>
                                    <select name="jadwal_dates[{{ $loop->index }}][jadwal_id]"
                                            class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 py-3"
                                            required>
                                        <option value="">Pilih Jadwal</option>
                                        @foreach($jadwals as $jadwal)
                                            @if(!in_array($jadwal->id, $bookedJadwals[$date] ?? []))
                                                <option value="{{ $jadwal->id }}">
                                                    {{ $jadwal->mulai }} - {{ $jadwal->selesai }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if(count($bookedJadwals[$date] ?? []) == $jadwals->count())
                                        <p class="mt-3 text-red-500 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Semua jadwal telah dibooking untuk tanggal ini
                                        </p>
                                    @endif
                                    <input type="hidden" name="jadwal_dates[{{ $loop->index }}][date]" value="{{ $date }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Form Details -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Informasi Kegiatan
                            </h2>
                            <div class="space-y-6">
                                <!-- Kegiatan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kegiatan</label>
                                    <input type="text" name="kegiatan"
                                           class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                           placeholder="Masukkan nama kegiatan"
                                           value="{{ old('kegiatan') }}" required>
                                    @error('kegiatan')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Instansi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Instansi</label>
                                    <input type="text" name="instansi"
                                           class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                           placeholder="Masukkan nama instansi"
                                           value="{{ old('instansi') }}" required>
                                    @error('instansi')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estimasi Peserta -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Estimasi Jumlah Peserta
                                        @if(isset($ruangan))
                                            <span class="text-gray-500">(Maks. {{ $ruangan->kapasitas }} orang)</span>
                                        @endif
                                    </label>
                                    <input type="number" name="estimasiPeserta"
                                           class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                           placeholder="Masukkan jumlah peserta"
                                           value="{{ old('estimasiPeserta') }}"
                                           required
                                           @if(isset($ruangan)) max="{{ $ruangan->kapasitas }}" @endif>
                                    @error('estimasiPeserta')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Dokumen Pendukung
                            </h2>
                            <div class="space-y-6">
                                <!-- Surat Peminjaman -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Surat Peminjaman</label>
                                    <div class="mt-2">
                                        <div class="relative border-2 border-gray-200 border-dashed rounded-xl p-6 hover:border-green-200 transition-all duration-200">
                                            <input type="file" 
                                                   id="suratPeminjaman" 
                                                   name="suratPeminjaman" 
                                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                   required 
                                                   accept=".pdf,.doc,.docx"
                                                   onchange="updateFileInfo(this, 'suratFileInfo')">
                                            <div class="text-center" id="suratFileInfo">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    Klik untuk upload atau drag and drop
                                                </p>
                                                <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX (Maks. 2MB)</p>
                                            </div>
                                            <div id="suratFilePreview" class="hidden mt-3">
                                                <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200">
                                                    <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate" id="suratFileName"></p>
                                                        <p class="text-sm text-gray-500" id="suratFileSize"></p>
                                                        </div>
                                                    <button type="button" onclick="removeFile('suratPeminjaman', 'suratFileInfo', 'suratFilePreview')"
                                                            class="ml-3 text-sm font-medium text-red-500 hover:text-red-600 p-1">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @error('suratPeminjaman')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Rundown -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rundown Acara</label>
                                    <div class="mt-2">
                                        <div class="relative border-2 border-gray-200 border-dashed rounded-xl p-6 hover:border-green-200 transition-all duration-200">
                                            <input type="file" 
                                                   id="rundown" 
                                                   name="rundown" 
                                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                   required 
                                                   accept=".pdf,.doc,.docx"
                                                   onchange="updateFileInfo(this, 'rundownFileInfo')">
                                            <div class="text-center" id="rundownFileInfo">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <p class="mt-2 text-sm text-gray-600">
                                                    Klik untuk upload atau drag and drop
                                                </p>
                                                <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX (Maks. 2MB)</p>
                                            </div>
                                            <div id="rundownFilePreview" class="hidden mt-3">
                                                <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200">
                                                    <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate" id="rundownFileName"></p>
                                                        <p class="text-sm text-gray-500" id="rundownFileSize"></p>
                                                    </div>
                                                    <button type="button" onclick="removeFile('rundown', 'rundownFileInfo', 'rundownFilePreview')"
                                                            class="ml-3 text-sm font-medium text-red-500 hover:text-red-600 p-1">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @error('rundown')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Informasi Tarif
                        </h2>
                        <div class="space-y-6">
                            <!-- Status Peminjam -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status Peminjam</label>
                                <select name="statusPeminjam" id="statusPeminjam" 
                                        class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                        required>
                                    <option value="" disabled selected hidden>Pilih Status</option>
                                    <option value="unit">Fakultas/Unit</option>
                                    <option value="ormawa">Ormawa</option>
                                    <option value="umum">Umum</option>
                                </select>
                            </div>

                            <!-- Tariff Information -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h3 class="font-medium text-gray-900 mb-2">Informasi Tarif:</h3>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Tarif Fakultas/Unit: Rp{{ number_format(isset($ruangan) ? $ruangan->tarifunit : $sarana->tarifunit, 0, ',', '.') }}
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Tarif Ormawa: Rp{{ number_format(isset($ruangan) ? $ruangan->tariformawa : $sarana->tariformawa, 0, ',', '.') }}
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Tarif Umum: Rp{{ number_format(isset($ruangan) ? $ruangan->tarifumum : $sarana->tarifumum, 0, ',', '.') }}
                                    </li>
                                </ul>
                                <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                                    <p class="text-sm text-yellow-800">
                                        <span class="font-medium">Catatan:</span> Tarif akan dikenakan untuk:
                                    </p>
                                    <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside">
                                        <li>Peminjaman di hari Sabtu atau Minggu</li>
                                        <li>Peminjaman pada atau melewati pukul 16:00 (4 sore)</li>
                                        @if(isset($ruangan) ? $ruangan->is_hourly_rate : $sarana->is_hourly_rate)
                                        <li>Tarif dihitung per {{ isset($ruangan) ? $ruangan->hours_per_unit : $sarana->hours_per_unit }} jam untuk durasi peminjaman</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <!-- Estimated Total -->
                            <div id="estimatedTotal" class="hidden mt-4 p-4 bg-green-50 rounded-lg">
                                <p class="text-sm font-medium text-green-800">
                                    Estimasi Total Tarif: <span id="totalTarif" class="text-lg">Rp0</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <button type="button" onclick="confirmCancel()"
                                class="px-6 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </span>
                        </button>
                        <button type="submit"
                                class="px-6 py-3 bg-green-500 text-white rounded-xl text-sm font-medium hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Ajukan Peminjaman
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// File Upload Handler
function updateFileInfo(input, infoId) {
    const file = input.files[0];
    const fileInfo = document.getElementById(infoId);
    const filePreview = document.getElementById(infoId.replace('FileInfo', 'FilePreview'));
    const fileName = document.getElementById(infoId.replace('FileInfo', 'FileName'));
    const fileSize = document.getElementById(infoId.replace('FileInfo', 'FileSize'));

    if (file) {
        // Format file size
        const size = (file.size / 1024).toFixed(2);
        const formattedSize = size > 1024 ? (size / 1024).toFixed(2) + ' MB' : size + ' KB';

        // Update preview
        fileInfo.classList.add('hidden');
        filePreview.classList.remove('hidden');
        fileName.textContent = file.name;
        fileSize.textContent = formattedSize;
    } else {
        resetFileInput(input.id, infoId, filePreview.id);
    }
}

function removeFile(inputId, infoId, previewId) {
    resetFileInput(inputId, infoId, previewId);
}

function resetFileInput(inputId, infoId, previewId) {
    document.getElementById(inputId).value = '';
    document.getElementById(infoId).classList.remove('hidden');
    document.getElementById(previewId).classList.add('hidden');
}

// Form Submit Handler
document.getElementById('peminjamanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Konfirmasi Pengajuan',
        text: "Apakah Anda yakin ingin mengajukan peminjaman ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Ajukan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm(this);
        }
    });
});

function submitForm(form) {
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner">Mengirim...</span>';

    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = data.redirect;
            });
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: error.message || 'Terjadi kesalahan',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = 'Ajukan Peminjaman';
    });
}

function confirmCancel() {
    Swal.fire({
        title: 'Konfirmasi Pembatalan',
        text: "Apakah Anda yakin ingin membatalkan pengajuan ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Batalkan!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            history.back();
        }
    });
}

// Initialize error alerts if any
@if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        html: '{!! implode("<br>", $errors->all()) !!}',
        confirmButtonColor: '#DC2626'
    });
@endif
</script>
<script>
    // Add this to your existing JavaScript
    function calculateEstimatedTarif() {
        const statusPeminjam = document.getElementById('statusPeminjam').value;
        if (!statusPeminjam) return;
    
        const jadwalSelects = document.querySelectorAll('select[name^="jadwal_dates"][name$="[jadwal_id]"]');
        const dates = Array.from(document.querySelectorAll('input[name^="jadwal_dates"][name$="[date]"]')).map(input => input.value);
        
        const tarif = statusPeminjam === 'unit' ? 
            {{ isset($ruangan) ? $ruangan->tarifunit : $sarana->tarifunit }} :
            statusPeminjam === 'ormawa' ? 
            {{ isset($ruangan) ? $ruangan->tariformawa : $sarana->tariformawa }} :
            {{ isset($ruangan) ? $ruangan->tarifumum : $sarana->tarifumum }};
    
        // Check if hourly rate is enabled
        const isHourlyRate = {{ isset($ruangan) ? ($ruangan->is_hourly_rate ? 'true' : 'false') : ($sarana->is_hourly_rate ? 'true' : 'false') }};
        const hoursPerUnit = {{ isset($ruangan) ? ($ruangan->hours_per_unit ?? 0) : ($sarana->hours_per_unit ?? 0) }};
    
        let totalTarif = 0;
    
        dates.forEach((date, index) => {
            const jadwalId = jadwalSelects[index].value;
            if (!jadwalId) return;
    
            // Check if weekend
            const dayOfWeek = new Date(date).getDay();
            const isWeekend = dayOfWeek === 0 || dayOfWeek === 6; // 0 is Sunday, 6 is Saturday
    
            // Check if after hours
            const selectedOption = jadwalSelects[index].options[jadwalSelects[index].selectedIndex];
            const timeText = selectedOption.text;
            const timeRange = timeText.split(' - ');
            const startTime = timeRange[0];
            const endTime = timeRange[1];
            
            const startHour = parseInt(startTime.split(':')[0]);
            const endHour = parseInt(endTime.split(':')[0]);
            
            // Updated condition: Now considers 16:00 as chargeable time
            const isAfterHours = startHour >= 16 || endHour >= 16;
    
            // Apply tariff if weekend OR after hours
            if (isWeekend || isAfterHours) {
                // If hourly rate is enabled, calculate based on duration
                if (isHourlyRate && hoursPerUnit > 0) {
                    // Calculate duration in hours
                    const startMinutes = parseInt(startTime.split(':')[1]) || 0;
                    const endMinutes = parseInt(endTime.split(':')[1]) || 0;
                    
                    const startTimeInMinutes = startHour * 60 + startMinutes;
                    const endTimeInMinutes = endHour * 60 + endMinutes;
                    
                    const durationHours = Math.ceil((endTimeInMinutes - startTimeInMinutes) / 60);
                    
                    // Calculate multiplier based on hours_per_unit
                    const multiplier = Math.max(1, Math.ceil(durationHours / hoursPerUnit));
                    
                    // Apply tariff with multiplier
                    totalTarif += tarif * multiplier;
                } else {
                    // Standard tariff (not hourly)
                    totalTarif += tarif;
                }
            }
            // If weekday before 16:00, tariff is 0 (free)
        });
    
        document.getElementById('estimatedTotal').classList.remove('hidden');
        document.getElementById('totalTarif').textContent = `Rp${totalTarif.toLocaleString('id-ID')}`;
    }
    
    // Add event listeners
    document.getElementById('statusPeminjam').addEventListener('change', calculateEstimatedTarif);
    document.querySelectorAll('select[name^="jadwal_dates"][name$="[jadwal_id]"]').forEach(select => {
        select.addEventListener('change', calculateEstimatedTarif);
    });
</script>
@endpush
@endsection 
