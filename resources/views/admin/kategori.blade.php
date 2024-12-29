@extends('layouts.main')
@section('content')
<div class="p-4 sm:p-6">
   <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
      <!-- Card Header -->
      <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
         <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Data Kategori Sarana</h5>
         <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
         + Tambah Kategori
         </button>

      </div>
      {{-- Search Bar --}}
      <div class="p-5 border-b border-gray-200 dark:border-gray-700">
         <form method="GET" action="{{ route('kategori.index') }}" class="flex gap-3">
            <div class="flex-1">
               <div class="relative">
                  <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                     <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                     </svg>
                  </div>
                  <input type="text" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Cari kategori..." value="{{ request('search') }}">
               </div>
            </div>
            <div class="w-48">
               <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                  <option value="">Semua Kategori</option>
                  <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                  <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
               </select>
            </div>
            <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
               Cari
            </button>
         </form>
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
         <!-- Table -->
         <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col" class="px-6 py-3">No</th>
                     <th scope="col" class="px-6 py-3">Jenis</th>
                     <th scope="col" class="px-6 py-3">Deskripsi</th>
                     <th scope="col" class="px-6 py-3">Status</th>
                     <th scope="col" class="px-6 py-3">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($kategori as $index => $item)
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                     <td class="px-6 py-4">{{ $loop->iteration + ($kategori->currentPage() - 1) * $kategori->perPage() }}</td>
                     <td class="px-6 py-4">{{ $item->jenis }}</td>
                     <td class="px-6 py-4">{{ $item->deskripsi }}</td>
                     <td class="px-6 py-4">
                        @if($item->status == "aktif")
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                            Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">
                            Nonaktif
                        </span>
                        @endif
                     </td>
                     <td class="px-6 py-4">
                        <div class="flex space-x-2">                    
                            <!-- Tombol Sampah (Hanya jika status Nonaktif) -->
                            @if($item->status == "aktif")
                            <!-- Tombol Edit -->
                            <button data-modal-target="editModal{{ $item->id }}"
                              data-modal-toggle="editModal{{ $item->id }}"
                              class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-300 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-200">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                              </svg>
                           </button>
                           <button onclick="confirmDelete('{{ route('kategori.destroy', $item->id) }}')" 
                              class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                              </svg>
                           </button>
                            @endif
                        </div>
                     </td>  
                  </tr>
                  @endforeach
               </tbody>
            </table>
            <!-- Improved Pagination -->
            <div class="px-6 py-4">
               @if ($kategori->hasPages())
                  <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                     <div class="flex justify-between flex-1 sm:hidden">
                        @if ($kategori->onFirstPage())
                           <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-lg">
                              Previous
                           </span>
                        @else
                           <a href="{{ $kategori->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-700">
                              Previous
                           </a>
                        @endif

                        @if ($kategori->hasMorePages())
                           <a href="{{ $kategori->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-700">
                              Next
                           </a>
                        @else
                           <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-lg">
                              Next
                           </span>
                        @endif
                     </div>

                     <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                           <p class="text-sm text-gray-700 leading-5">
                              Showing
                              <span class="font-medium">{{ $kategori->firstItem() }}</span>
                              to
                              <span class="font-medium">{{ $kategori->lastItem() }}</span>
                              of
                              <span class="font-medium">{{ $kategori->total() }}</span>
                              results
                           </p>
                        </div>

                        <div>
                           <span class="relative z-0 inline-flex shadow-sm rounded-md">
                              {{-- Previous Page Link --}}
                              @if ($kategori->onFirstPage())
                                 <span aria-disabled="true">
                                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-lg leading-5">
                                       <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                          <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                       </svg>
                                    </span>
                                 </span>
                              @else
                                 <a href="{{ $kategori->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                       <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                 </a>
                              @endif

                              {{-- Pagination Elements --}}
                              @foreach ($kategori->getUrlRange(1, $kategori->lastPage()) as $page => $url)
                                 @if ($page == $kategori->currentPage())
                                    <span aria-current="page">
                                       <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-green-600 bg-green-50 border border-gray-300 cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                 @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                       {{ $page }}
                                    </a>
                                 @endif
                              @endforeach

                              {{-- Next Page Link --}}
                              @if ($kategori->hasMorePages())
                                 <a href="{{ $kategori->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                       <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                 </a>
                              @else
                                 <span aria-disabled="true">
                                    <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-lg leading-5">
                                       <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                          <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
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
<div id="createModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden" data-modal-backdrop="static">
   <!-- Backdrop with higher z-index -->
   <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="createModal"></div>
   <div class="relative w-full max-w-2xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Tambah Kategori
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createModal">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <form id="categoryForm" action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis</label>
                  <input type="text" name="jenis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                  <textarea name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500"></textarea>
               </div>
            </div>
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
               <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
               <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" data-modal-hide="createModal">Batal</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Edit Modals -->
@foreach($kategori as $item)
<div id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden" data-modal-backdrop="static">
   <!-- Backdrop with higher z-index -->
   <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="editModal{{ $item->id }}"></div>
   <div class="relative w-full max-w-2xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Edit Kategori
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editModal{{ $item->id }}">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <form id="editCategoryForm" action="{{ route('kategori.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis</label>
                  <input type="text" name="jenis" value="{{ $item->jenis }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                  <textarea name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500">{{ $item->deskripsi }}</textarea>
               </div>
            </div>
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
               <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan</button>
               <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" data-modal-hide="editModal{{ $item->id }}">Batal</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Modal functionality script -->
<script>
 document.addEventListener('DOMContentLoaded', function() {
    initializeModals();
    initializeForms();
});

// Modal Management
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
            closeModal(modalId);
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', (event) => {
        if (event.target.matches('[id^="createModal"], [id^="editModal"]')) {
            closeModal(event.target.id);
        }
    });
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.add('hidden');
}

// Form Handling
function initializeForms() {
    // Handle create form
    const createForm = document.getElementById('categoryForm');
    if (createForm) {
        createForm.addEventListener('submit', handleFormSubmit);
    }

    // Handle all edit forms
    document.querySelectorAll('form[id^="editCategoryForm"]').forEach(form => {
        form.addEventListener('submit', handleFormSubmit);
    });
}

async function handleFormSubmit(e) {
    e.preventDefault();
    
    // Validate form
    const emptyFields = validateForm(this);
    if (emptyFields.length > 0) {
        await showValidationError(emptyFields);
        return;
    }

    // Confirm submission
    const confirmed = await confirmSubmission();
    if (!confirmed) return;

    // Submit form
    await submitForm(this);
}

function validateForm(form) {
    const emptyFields = [];
    const requiredFields = {
        'jenis': 'Jenis',
        'deskripsi': 'Deskripsi'
    };

    Object.entries(requiredFields).forEach(([fieldName, label]) => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (!field?.value?.trim()) {
            emptyFields.push(label);
        }
    });

    return emptyFields;
}

async function showValidationError(emptyFields) {
    await Swal.fire({
        title: 'Peringatan!',
        html: `Data berikut tidak boleh kosong:<br><strong>${emptyFields.join(', ')}</strong>`,
        icon: 'warning',
        confirmButtonColor: '#059669'
    });
}

async function confirmSubmission() {
    const result = await Swal.fire({
        title: 'Konfirmasi Data',
        text: 'Apakah Anda yakin data yang diisi sudah benar?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
    });
    return result.isConfirmed;
}

async function submitForm(form) {
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner">Menyimpan...</span>';
    }

    try {
        const formData = new FormData(form);
        const isEditForm = form.id.startsWith('editCategoryForm');
        if (isEditForm) {
            formData.append('_method', 'PUT');
        }

        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            credentials: 'same-origin'
        });

        const data = await response.json();

        if (!response.ok) throw new Error(data.message || 'Network response was not ok');

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });

            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Error:', error);
        await Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: error.message || 'Terjadi kesalahan saat menyimpan data',
            timer: 2000,
            showConfirmButton: false
        });
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = form.id === 'categoryForm' ? 'Simpan' : 'Simpan Perubahan';
        }
    }
}

async function confirmDelete(deleteUrl) {
    const result = await Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah Anda yakin ingin menonaktifkan kategori ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Nonaktifkan!',
        cancelButtonText: 'Batal'
    });

    if (!result.isConfirmed) return;

    try {
        const response = await fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();

        if (!response.ok) throw new Error(data.message || 'Network response was not ok');

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });

            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.reload();
            }
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error('Error:', error);
        await Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: error.message || 'Terjadi kesalahan saat menonaktifkan kategori',
            showConfirmButton: true
        });
    }
}
</script>
@endsection
