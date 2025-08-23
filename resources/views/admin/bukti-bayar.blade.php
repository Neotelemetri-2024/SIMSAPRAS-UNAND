@extends('layouts.main')

@section('content')
<div class="p-4 sm:p-6">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Data Bukti Pembayaran</h5>
        </div>
        
        <div class="p-5">
            @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <!-- Filter dan Search Section -->
            <div class="mb-4 flex flex-col sm:flex-row gap-4 items-center justify-between">
                <form method="GET" action="{{ route('bukti.index') }}" class="flex flex-col sm:flex-row gap-3 w-full">
                    <!-- Filter Status Pembayaran -->
                    <div class="flex-1 min-w-0">
                        <select name="status_pembayaran" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" onchange="this.form.submit()">
                            <option value="">Semua Status Pembayaran</option>
                            <option value="lunas" {{ request('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="belum_lunas" {{ request('status_pembayaran') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        </select>
                    </div>
                    
                    <!-- Filter Status Peminjam -->
                    <div class="flex-1 min-w-0">
                        <select name="status_peminjam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" onchange="this.form.submit()">
                            <option value="">Semua Peminjam</option>
                            <option value="unit" {{ request('status_peminjam') == 'unit' ? 'selected' : '' }}>Unit</option>
                            <option value="ormawa" {{ request('status_peminjam') == 'ormawa' ? 'selected' : '' }}>Ormawa</option>
                            <option value="umum" {{ request('status_peminjam') == 'umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                    </div>

                    <!-- Search Box -->
                    <div class="flex-1 min-w-0">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari peminjam atau kegiatan..." 
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Button -->
                    <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 whitespace-nowrap">
                        Cari
                    </button>
                    
                    <!-- Reset Button -->
                    @if(request('status_pembayaran') || request('status_peminjam') || request('search'))
                    <a href="{{ route('bukti.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 whitespace-nowrap">
                        Reset
                    </a>
                    @endif
                </form>
            </div>

            <!-- Info Total Data -->
            <div class="mb-4 text-sm text-gray-600">
                Menampilkan {{ $buktiPembayaran->firstItem() ?? 0 }} - {{ $buktiPembayaran->lastItem() ?? 0 }} dari {{ $buktiPembayaran->total() }} data bukti pembayaran
                @if(request('status_pembayaran'))
                    dengan status: <span class="font-semibold">{{ request('status_pembayaran') == 'lunas' ? 'Lunas' : 'Belum Lunas' }}</span>
                @endif
                @if(request('status_peminjam'))
                    peminjam: <span class="font-semibold">{{ ucfirst(request('status_peminjam')) }}</span>
                @endif
                @if(request('search'))
                    pencarian: <span class="font-semibold">"{{ request('search') }}"</span>
                @endif
            </div>

            <!-- Table -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Peminjam</th>
                            <th scope="col" class="px-6 py-3">Sarana/Ruangan</th>
                            <th scope="col" class="px-6 py-3">Total Tarif</th>
                            <th scope="col" class="px-6 py-3">Status Peminjam</th>
                            <th scope="col" class="px-6 py-3">Status Pembayaran</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($buktiPembayaran as $index => $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                {{ $buktiPembayaran->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $item->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->ruangan)
                                    <div class="font-medium">{{ $item->ruangan->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->sarana->nama }}</div>
                                @else
                                    <div class="font-medium">{{ $item->sarana->nama }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900 dark:text-white">
                                    Rp {{ number_format($item->totalTarif, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($item->statusPeminjam == 'unit') bg-blue-100 text-blue-800
                                    @elseif($item->statusPeminjam == 'ormawa') bg-purple-100 text-purple-800
                                    @else bg-orange-100 text-orange-800
                                    @endif">
                                    {{ ucfirst($item->statusPeminjam) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($item->statusPembayaran == 'lunas') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $item->statusPembayaran == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <button data-modal-target="buktiModal{{ $item->hashed_id }}"
                                        data-modal-toggle="buktiModal{{ $item->id }}"
                                        class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200"
                                        title="Lihat Bukti Pembayaran">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                @if(request('status_pembayaran') || request('status_peminjam') || request('search'))
                                    Tidak ada data bukti pembayaran yang sesuai dengan filter/pencarian
                                @else
                                    Belum ada data bukti pembayaran
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            @if($buktiPembayaran->hasPages())
            <div class="mt-4">
                {{ $buktiPembayaran->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Bukti Pembayaran -->
@foreach($buktiPembayaran as $item)
<div id="buktiModal{{ $item->hashed_id }}" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="buktiModal{{ $item->hashed_id }}"></div>
    <div class="relative w-full max-w-5xl max-h-full mx-auto my-4 p-4">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Bukti Pembayaran - {{ $item->user->name }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="buktiModal{{ $item->hashed_id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Detail Peminjaman -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2">Detail Peminjaman</h4>
                        
                        <div class="space-y-3">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Peminjam</label>
                                <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $item->user->name }}</p>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $item->user->email }}</p>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Instansi</label>
                                <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $item->instansi }}</p>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Kegiatan</label>
                                <p class="text-sm text-gray-900 dark:text-white text-right">{{ $item->kegiatan }}</p>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Sarana/Ruangan</label>
                                @if($item->ruangan)
                                    <p class="text-sm text-gray-900 dark:text-white text-right">{{ $item->ruangan->nama }} - {{ $item->sarana->nama }}</p>
                                @else
                                    <p class="text-sm text-gray-900 dark:text-white text-right">{{ $item->sarana->nama }}</p>
                                @endif
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Tarif</label>
                                <p class="text-sm text-gray-900 dark:text-white font-bold text-green-600">Rp {{ number_format($item->totalTarif, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Status Peminjam</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium w-fit
                                    @if($item->statusPeminjam == 'unit') bg-blue-100 text-blue-800
                                    @elseif($item->statusPeminjam == 'ormawa') bg-purple-100 text-purple-800
                                    @else bg-orange-100 text-orange-800
                                    @endif">
                                    {{ ucfirst($item->statusPeminjam) }}
                                </span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Status Pembayaran</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium w-fit
                                    @if($item->statusPembayaran == 'lunas') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $item->statusPembayaran == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Upload</label>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $item->updated_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bukti Pembayaran -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2">Bukti Pembayaran</h4>
                        
                        <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-600">
                            @if($item->buktiPembayaran)
                                @php
                                    $extension = pathinfo($item->buktiPembayaran, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                
                                @if($isImage)
                                    <div class="text-center">
                                        <img src="{{ asset('storage/' . $item->buktiPembayaran) }}" 
                                             alt="Bukti Pembayaran" 
                                             class="w-full h-auto max-h-96 object-contain rounded-lg border shadow-sm cursor-pointer hover:shadow-md transition-shadow"
                                             onclick="openImageFullscreen('{{ asset('storage/' . $item->buktiPembayaran) }}')">
                                        <p class="text-xs text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">File: {{ basename($item->buktiPembayaran) }}</p>
                                        <p class="text-xs text-gray-400">Format: {{ strtoupper($extension) }}</p>
                                    </div>
                                @endif
                                
                                <div class="mt-4 text-center">
                                    <a href="{{ asset('storage/' . $item->buktiPembayaran) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Download File
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <p class="mt-2 text-gray-500">Bukti pembayaran tidak tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Fullscreen Image -->
<div id="fullscreenModal" class="fixed inset-0 z-[70] hidden bg-black bg-opacity-90 flex items-center justify-center p-4">
    <div class="relative max-w-full max-h-full">
        <img id="fullscreenImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-full object-contain">
        <button onclick="closeFullscreen()" class="absolute top-4 right-4 text-white hover:text-gray-300 bg-black bg-opacity-50 rounded-full p-2 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize modals
    const initializeModals = () => {
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.getElementById(button.dataset.modalTarget);
                if (target) target.classList.toggle('hidden');
            });
        });

        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.getElementById(button.dataset.modalHide);
                if (target) target.classList.add('hidden');
            });
        });

        // Close on outside click
        window.addEventListener('click', function(event) {
            document.querySelectorAll('[id^="buktiModal"]').forEach(modal => {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    };

    initializeModals();
});

// Function to open fullscreen image
function openImageFullscreen(imageSrc) {
    const modal = document.getElementById('fullscreenModal');
    const img = document.getElementById('fullscreenImage');
    img.src = imageSrc;
    modal.classList.remove('hidden');
}

// Function to close fullscreen
function closeFullscreen() {
    const modal = document.getElementById('fullscreenModal');
    modal.classList.add('hidden');
}

// Close fullscreen with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeFullscreen();
    }
});

// Function to update payment status
async function updateStatusPembayaran(peminjamanId, status) {
    const result = await Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin mengubah status pembayaran menjadi lunas?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#15803d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch(`/admin/peminjaman/${peminjamanId}/update-payment-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    statusPembayaran: status
                })
            });

            const data = await response.json();

            await Swal.fire({
                icon: data.success ? 'success' : 'error',
                title: data.success ? 'Berhasil!' : 'Gagal!',
                text: data.message,
                confirmButtonColor: data.success ? '#15803d' : '#dc2626'
            });

            if (data.success) {
                location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
            await Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan pada server',
                confirmButtonColor: '#dc2626'
            });
        }
    }
}
</script>
@endsection