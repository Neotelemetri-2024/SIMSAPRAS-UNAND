@extends('layouts.main')
@section('content')
<div class="p-4 sm:p-6">
   <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
      <!-- Card Header -->
      <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
         <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Data Jadwal</h5>
         <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
         + Tambah Jadwal
         </button>
      </div>
      <!-- Card Body -->
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
                     <th scope="col" class="px-6 py-3">Shift</th>
                     <th scope="col" class="px-6 py-3">Jam Mulai</th>
                     <th scope="col" class="px-6 py-3">Jam Selesai</th>
                     <th scope="col" class="px-6 py-3">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($jadwal as $index => $item)
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                     <td class="px-6 py-4">{{ $index + 1 }}</td>
                     <td class="px-6 py-4">{{ $item->shift }}</td>
                     <td class="px-6 py-4">{{ $item->mulai }}</td>
                     <td class="px-6 py-4">{{ $item->selesai }}</td>
                     <td class="px-6 py-4">
                        @if($item->status === "aktif")
                        <div class="flex space-x-2">
                           <button data-modal-target="editModal{{ $item->hashed_id }}" 
                                   data-modal-toggle="editModal{{ $item->id }}" 
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-300 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-200">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                              </svg>
                           </button>
                           <button onclick="confirmDelete('{{ route('jadwal.destroy', $item->hashed_id) }}')"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                              </svg>
                           </button>
                        </div>
                        @else
                        <button onclick="activateJadwal('{{ route('jadwal.activate', $item->hashed_id) }}')"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                        @endif
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<div id="createModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden" data-modal-backdrop="static">    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="createModal"></div>
   <div class="relative w-full max-w-2xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Tambah Jadwal
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createModal">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <form id="jadwalForm" action="{{ route('jadwal.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shift</label>
                  <input type="text" name="shift" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Mulai</label>
                  <input type="time" name="mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Selesai</label>
                  <input type="time" name="selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
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
@foreach($jadwal as $item)
<div id="editModal{{ $item->hashed_id }}" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden" data-modal-backdrop="static">
    <!-- Backdrop with higher z-index -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="editModal{{ $item->hashed_id }}"></div>
   <div class="relative w-full max-w-2xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Edit Jadwal
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editModal{{ $item->hashed_id }}">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <form id="editJadwalForm" action="{{ route('jadwal.update', $item->hashed_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shift</label>
                  <input type="text" name="shift" value="{{ $item->shift }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Mulai</label>
                  <input type="time" name="mulai" value="{{ $item->mulai }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Selesai</label>
                  <input type="time" name="selesai" value="{{ $item->selesai }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
               </div>
            </div>
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
               <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan</button>
               <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" data-modal-hide="editModal{{ $item->hashed_id }}">Batal</button>
            </div>
         </form>
      </div>
   </div>
</div>
@endforeach

<!-- Modal functionality script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
   // Tambahkan ini di awal file JavaScript
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
    document.querySelectorAll('form').forEach(form => {
        if (form.id === 'jadwalForm' || form.id.startsWith('editJadwalForm')) {
            form.addEventListener('submit', handleFormSubmit);
        }
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

    // Validate time
    if (!validateTime(this)) {
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
        'shift': 'Shift',
        'mulai': 'Jam Mulai',
        'selesai': 'Jam Selesai'
    };

    Object.entries(requiredFields).forEach(([fieldName, label]) => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (!field?.value?.trim()) {
            emptyFields.push(label);
        }
    });

    return emptyFields;
}

function validateTime(form) {
    const mulai = form.querySelector('input[name="mulai"]').value;
    const selesai = form.querySelector('input[name="selesai"]').value;

    if (mulai >= selesai) {
        Swal.fire({
            title: 'Peringatan!',
            text: 'Jam selesai harus lebih besar dari jam mulai',
            icon: 'warning',
            confirmButtonColor: '#059669'
        });
        return false;
    }
    return true;
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
        const isEditForm = form.id.startsWith('editJadwalForm');
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
            submitBtn.innerHTML = form.id === 'jadwalForm' ? 'Simpan' : 'Simpan Perubahan';
        }
    }
}

async function confirmDelete(deleteUrl) {
    const result = await Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah Anda yakin ingin menonaktifkan jadwal ini?",
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
            text: error.message || 'Terjadi kesalahan saat menghapus data',
            showConfirmButton: true
        });
    }
}

async function activateJadwal(url) {
    const result = await Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah Anda yakin ingin mengaktifkan jadwal ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Aktifkan!',
        cancelButtonText: 'Batal'
    });

    if (!result.isConfirmed) return;

    try {
        const response = await fetch(url, {
            method: 'PATCH',
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
            text: error.message || 'Terjadi kesalahan saat mengaktifkan jadwal',
            showConfirmButton: true
        });
    }
}
</script>
@endsection