@extends('layouts.user')
@section('content')
<div class="pt-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-8 border-b border-gray-100">
                <h1 class="text-3xl font-bold text-gray-900">Form Pengaduan</h1>
                <p class="mt-2 text-gray-600">Silakan lengkapi form berikut untuk mengajukan pengaduan</p>
            </div>
            <form id="pengaduanForm" action="{{ route('user.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Informasi Pengaduan
                            </h2>
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Pengaduan</label>
                                    <input type="text" name="judul"
                                           class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                           placeholder="Masukkan judul pengaduan"
                                           required>
                                    @error('judul')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Sarana</label>
                                    <select name="id_sarana"
                                            class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                            required>
                                        <option value="" disabled selected hidden>Pilih Sarana</option>
                                        @foreach($sarana as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_sarana')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Pengaduan</label>
                                    <textarea name="deskripsi" rows="4"
                                              class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                              placeholder="Jelaskan detail pengaduan Anda"
                                              required></textarea>
                                    @error('deskripsi')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Foto
                            </h2>
                            <div class="mt-2">
                                <div class="relative border-2 border-gray-200 border-dashed rounded-xl p-6 hover:border-green-200 transition-all duration-200">
                                    <input type="file" 
                                           id="foto" 
                                           name="foto" 
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                           accept="image/*"
                                           onchange="updateFileInfo(this, 'fotoFileInfo')">
                                    <div class="text-center" id="fotoFileInfo">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-600">
                                            Klik untuk upload atau drag and drop foto
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">JPG, JPEG, PNG (Maks. 2MB)</p>
                                    </div>
                                    <div id="fotoFilePreview" class="hidden mt-3">
                                        <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200">
                                            <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate" id="fotoFileName"></p>
                                                <p class="text-sm text-gray-500" id="fotoFileSize"></p>
                                            </div>
                                            <button type="button" onclick="removeFile('foto', 'fotoFileInfo', 'fotoFilePreview')"
                                                    class="ml-3 text-sm font-medium text-red-500 hover:text-red-600 p-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @error('foto')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                                    <p class="text-sm text-yellow-800">
                                        <span class="font-medium">Catatan:</span> Unggah foto untuk memperjelas pengaduan Anda (opsional)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-4 pt-6">
                        <button type="button" onclick="window.history.back()"
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
                                Kirim Pengaduan
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function updateFileInfo(input, infoId) {
        const fileInfo = document.getElementById(infoId);
        const filePreview = document.getElementById(input.id + 'FilePreview');
        const fileName = document.getElementById(input.id + 'FileName');
        const fileSize = document.getElementById(input.id + 'FileSize');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileInfo.classList.add('hidden');
            filePreview.classList.remove('hidden');
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
        }
    }

    function removeFile(inputId, infoId, previewId) {
        const input = document.getElementById(inputId);
        const fileInfo = document.getElementById(infoId);
        const filePreview = document.getElementById(previewId);

        input.value = '';
        fileInfo.classList.remove('hidden');
        filePreview.classList.add('hidden');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    document.getElementById('pengaduanForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        Swal.fire({
            title: 'Mohon Tunggu!',
            text: 'Sedang memproses pengaduan...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    this.reset();
                    document.getElementById('fotoFileInfo').classList.remove('hidden');
                    document.getElementById('fotoFilePreview').classList.add('hidden');
                    window.location.href = "{{ route('user.pengaduan.show') }}";
                });
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                text: error.message || 'Terjadi kesalahan! Silakan coba lagi.',
            });
        });
    });
</script>
@endsection