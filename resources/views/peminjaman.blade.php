@extends('layouts.user')

@section('content')
<div class="py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="border-b pb-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Form Pengajuan Peminjaman</h1>
                <p class="mt-2 text-sm text-gray-600">Silakan lengkapi form berikut untuk mengajukan peminjaman fasilitas.</p>
            </div>

            <form id="peminjamanForm" action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idSarana" value="{{ $sarana->id }}">
                <input type="hidden" name="selected_dates" value="{{ $selectedDates }}">

                <!-- Informasi Fasilitas -->
                <div class="bg-gray-50 p-6 rounded-lg mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        <svg class="w-5 h-5 inline-block mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Fasilitas
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <p class="mb-2"><span class="font-medium">Sarana:</span> {{ $sarana->nama }}</p>
                            @if(isset($ruangan))
                                <input type="hidden" name="idRuangan" value="{{ $ruangan->id }}">
                                <p class="mb-2"><span class="font-medium">Ruangan:</span> {{ $ruangan->nama }}</p>
                                <p><span class="font-medium">Kapasitas:</span> {{ $ruangan->kapasitas }} orang</p>
                            @endif
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h3 class="font-medium mb-3">Tanggal Peminjaman:</h3>
                            <div class="space-y-2">
                                @foreach(json_decode($selectedDates) as $date)
                                    <div class="bg-gray-50 p-2 rounded text-sm border border-gray-100">
                                        {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jadwal per Tanggal -->
                <div class="bg-gray-50 p-6 rounded-lg mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        <svg class="w-5 h-5 inline-block mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Jadwal per Tanggal
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(json_decode($selectedDates) as $date)
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <p class="font-medium text-gray-900 mb-3">
                                    {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                </p>
                                <select name="jadwal_dates[{{ $loop->index }}][jadwal_id]"
                                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                                    @foreach($jadwals as $jadwal)
                                        <option value="{{ $jadwal->id }}">
                                            {{ $jadwal->mulai }} - {{ $jadwal->selesai }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="jadwal_dates[{{ $loop->index }}][date]" value="{{ $date }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Form Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div>
                        <div class="space-y-6">
                            <!-- Kegiatan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kegiatan</label>
                                <input type="text" name="kegiatan"
                                       class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                       placeholder="Masukkan nama kegiatan"
                                       value="{{ old('kegiatan') }}" required>
                                @error('kegiatan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Instansi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Instansi</label>
                                <input type="text" name="instansi"
                                       class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                       placeholder="Masukkan nama instansi"
                                       value="{{ old('instansi') }}" required>
                                @error('instansi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
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
                                       class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                                       placeholder="Masukkan jumlah peserta"
                                       value="{{ old('estimasiPeserta') }}"
                                       required
                                       @if(isset($ruangan)) max="{{ $ruangan->kapasitas }}" @endif>
                                @error('estimasiPeserta')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Surat Peminjaman -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Surat Peminjaman</label>
                            <div class="mt-2">
                                <div class="relative border-2 border-gray-300 border-dashed rounded-lg p-4">
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
                                        <p class="mt-1 text-sm text-gray-600">
                                            Klik untuk upload atau drag and drop
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX (Maks. 2MB)</p>
                                    </div>
                                    <div id="suratFilePreview" class="hidden mt-2">
                                        <div class="flex items-center p-2 bg-gray-50 rounded">
                                            <svg class="w-8 h-8 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate" id="suratFileName"></p>
                                                <p class="text-sm text-gray-500" id="suratFileSize"></p>
                                            </div>
                                            <button type="button" onclick="removeFile('suratPeminjaman', 'suratFileInfo', 'suratFilePreview')"
                                                    class="ml-2 text-sm font-medium text-red-600 hover:text-red-500">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @error('suratPeminjaman')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Rundown -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rundown Acara</label>
                            <div class="mt-2">
                                <div class="relative border-2 border-gray-300 border-dashed rounded-lg p-4">
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
                                        <p class="mt-1 text-sm text-gray-600">
                                            Klik untuk upload atau drag and drop
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX (Maks. 2MB)</p>
                                    </div>
                                    <div id="rundownFilePreview" class="hidden mt-2">
                                        <div class="flex items-center p-2 bg-gray-50 rounded">
                                            <svg class="w-8 h-8 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate" id="rundownFileName"></p>
                                                <p class="text-sm text-gray-500" id="rundownFileSize"></p>
                                            </div>
                                            <button type="button" onclick="removeFile('rundown', 'rundownFileInfo', 'rundownFilePreview')"
                                                    class="ml-2 text-sm font-medium text-red-600 hover:text-red-500">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @error('rundown')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

<!-- Form Actions -->
<div class="mt-8 flex justify-end space-x-4 border-t pt-6">
    <button type="button" onclick="confirmCancel()"
            class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Batal
        </span>
    </button>
    <button type="submit"
            class="px-6 py-2.5 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Ajukan Peminjaman
        </span>
    </button>
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
@endpush
@endsection