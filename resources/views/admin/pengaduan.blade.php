@extends('layouts.main')
@section('content')
<div class="p-4 sm:p-6">
   <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
      <div class="p-5 border-b border-gray-200 dark:border-gray-700">
         <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Daftar Pengaduan</h5>
      </div>
      
      <div class="p-5 border-b border-gray-200 dark:border-gray-700">
         <form method="GET" action="{{ route('pengaduan.index') }}" class="flex gap-3">
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
                     placeholder="Cari pengaduan..."
                     value="{{ request('search') }}">
               </div>
            </div>

            <div class="w-48">
               <select name="filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                  <option value="">Semua Sarana</option>
                  @foreach($sarana as $item)
                  <option value="{{ $item->hashed_id }}" {{ request('filter') == $item->id ? 'selected' : '' }}>
                     {{ $item->nama }}
                  </option>
                  @endforeach
               </select>
            </div>

            <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
               Cari
            </button>
         </form>
      </div>

      <div class="p-5">
         <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col" class="px-6 py-3">No</th>
                     <th scope="col" class="px-6 py-3">Judul</th>
                     <th scope="col" class="px-6 py-3">Sarana</th>
                     <th scope="col" class="px-6 py-3">Pelapor</th>
                     <th scope="col" class="px-6 py-3">Foto</th>
                     <th scope="col" class="px-6 py-3">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($pengaduan as $index => $item)
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                     <td class="px-6 py-4">{{ $loop->iteration + ($pengaduan->currentPage() - 1) * $pengaduan->perPage() }}</td>
                     <td class="px-6 py-4">{{ $item->judul }}</td>
                     <td class="px-6 py-4">{{ $item->sarana->nama }}</td>
                     <td class="px-6 py-4">{{ $item->user->name }}</td>
                     <td class="px-6 py-4">
                        @if($item->foto)
                        <div class="relative group">
                           <img src="{{ Storage::url($item->foto) }}" 
                              alt="Foto Pengaduan"
                              class="w-24 h-24 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                              onclick="showImagePreview('{{ Storage::url($item->foto) }}')"
                           >
                        </div>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                     </td>
                     <td class="px-6 py-4">
                        <button data-modal-target="detailModal{{ $item->hashed_id }}" 
                           data-modal-toggle="detailModal{{ $item->id }}"
                           class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                           Detail
                        </button>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
            <div class="px-6 py-4">
               {{ $pengaduan->links() }}
            </div>
         </div>
      </div>
   </div>
</div>

@foreach($pengaduan as $item)
<div id="detailModal{{ $item->hashed_id }}" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] overflow-y-auto hidden" data-modal-backdrop="static">
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity" data-modal-hide="detailModal{{ $item->hashed_id }}"></div>
    <div class="flex min-h-screen items-center justify-center py-8">
        <div class="relative w-full max-w-3xl mx-auto px-4">
            <div class="relative bg-white rounded-xl shadow-2xl dark:bg-gray-800 transform transition-all">
                <div class="sticky top-0 z-30 bg-white dark:bg-gray-800 rounded-t-xl border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-start justify-between p-6">
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $item->judul }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Dilaporkan pada {{ $item->created_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg p-2 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white transition-colors" data-modal-hide="detailModal{{ $item->hashed_id }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="overflow-y-auto max-h-[calc(100vh-16rem)]">
                    <div class="p-6 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-6">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Sarana</div>
                                    <div class="text-gray-900 dark:text-white font-medium flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        {{ $item->sarana->nama }}
                                    </div>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Pelapor</div>
                                    <div class="text-gray-900 dark:text-white font-medium flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $item->user->name }}
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Deskripsi Pengaduan</div>
                                <div class="text-gray-900 dark:text-white">
                                    {{ $item->deskripsi }}
                                </div>
                            </div>
                        </div>

                        @if($item->foto)
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">Foto Pengaduan</div>
                            <div class="relative group">
                                <img src="{{ Storage::url($item->foto) }}"
                                    alt="Foto Pengaduan"
                                    class="w-full rounded-lg cursor-zoom-in hover:opacity-90 transition-opacity"
                                    onclick="showImagePreview('{{ Storage::url($item->foto) }}')"
                                >
                                <div class="absolute bottom-2 right-2 bg-black bg-opacity-50 text-white text-xs px-3 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                    Klik untuk memperbesar
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="sticky bottom-0 z-30 bg-gray-50 dark:bg-gray-700 rounded-b-xl border-t border-gray-100 dark:border-gray-600">
                    <div class="flex items-center justify-end px-6 py-4">
                        <button type="button" 
                                class="px-5 py-2.5 text-sm font-medium rounded-lg border border-gray-200 hover:bg-gray-100 text-gray-600 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors" 
                                data-modal-hide="detailModal{{ $item->hashed_id }}">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<div id="previewModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden w-full p-4 flex items-center justify-center bg-black bg-opacity-50">
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

@push('scripts')
<script>
   document.addEventListener('DOMContentLoaded', function() {
      initializeModals();
   });

   function initializeModals() {
      document.querySelectorAll('[data-modal-toggle]').forEach(button => {
         button.addEventListener('click', () => {
               const modalId = button.getAttribute('data-modal-target');
               const modal = document.getElementById(modalId);
               if (modal) modal.classList.remove('hidden');
         });
      });

      document.querySelectorAll('[data-modal-hide]').forEach(button => {
         button.addEventListener('click', () => {
               const modalId = button.getAttribute('data-modal-hide');
               closeModal(modalId);
         });
      });

      window.addEventListener('click', (event) => {
         if (event.target.matches('[id^="detailModal"]')) {
               closeModal(event.target.id);
         }
      });
   }

   function closeModal(modalId) {
      const modal = document.getElementById(modalId);
      if (modal) modal.classList.add('hidden');
   }

   function showImagePreview(imageSrc) {
      const previewModal = document.getElementById('previewModal');
      const previewImage = document.getElementById('previewImage');
      
      previewImage.src = imageSrc;
      previewModal.classList.remove('hidden');
      
      document.body.style.overflow = 'hidden';
   }

   function closeImagePreview() {
      const previewModal = document.getElementById('previewModal');
      previewModal.classList.add('hidden');
      
      document.body.style.overflow = 'auto';
   }

   document.getElementById('previewModal').addEventListener('click', function(e) {
      if (e.target === this) {
         closeImagePreview();
      }
   });

   document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && !document.getElementById('previewModal').classList.contains('hidden')) {
         closeImagePreview();
      }
   });
</script>
@endpush
@endsection