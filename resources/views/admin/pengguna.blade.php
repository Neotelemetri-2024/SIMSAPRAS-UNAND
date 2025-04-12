@extends('layouts.main')
@section('content')
<div class="p-4 sm:p-6">
   <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
      <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
         <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Data Pengguna</h5>
         <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
         + Tambah Pengguna
         </button>
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

         <div class="mb-4">
            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px">
                    <li class="mr-2">
                        <button class="tab-button inline-block p-4 text-green-600 border-b-2 border-green-600 rounded-t-lg active dark:text-green-500 dark:border-green-500" data-role="user">
                            User
                        </button>
                    </li>
                    <li class="mr-2">
                        <button class="tab-button inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" data-role="admin">
                            Admin
                        </button>
                    </li>
                    <li class="mr-2">
                        <button class="tab-button inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" data-role="pimpinan">
                            Pimpinan
                        </button>
                    </li>
                </ul>
            </div>
        </div>

         <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col" class="px-6 py-3">No</th>
                     <th scope="col" class="px-6 py-3">Nama</th>
                     <th scope="col" class="px-6 py-3">Kontak</th>
                     <th scope="col" class="px-6 py-3">Email</th>
                     <th scope="col" class="px-6 py-3">Role</th>
                     <th scope="col" class="px-6 py-3">Akun Fakultas?</th>
                     <th scope="col" class="px-6 py-3">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  @php
                     $userCount = 1;
                     $adminCount = 1;
                     $superadminCount = 1;
                     $pimpinanCount = 1;
                  @endphp
                  @foreach($pengguna as $item)
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 role-row" data-role="{{ $item->role }}">
                     <td class="px-6 py-4">
                        @if($item->role == 'user')
                            {{ $userCount++ }}
                        @elseif($item->role == 'admin')
                            {{ $adminCount++ }}
                        @elseif($item->role == 'superadmin')
                            {{ $superadminCount++ }}
                        @elseif($item->role == 'pimpinan')
                            {{ $pimpinanCount++ }}
                        @endif
                    </td>
                     <td class="px-6 py-4">{{ $item->name }}</td>
                     <td class="px-6 py-4">{{ $item->kontak }}</td>
                     <td class="px-6 py-4">{{ $item->email }}</td>
                     <td class="px-6 py-4">{{ $item->role }}</td>
                     <td class="px-6 py-4">
                        @if($item->isFakultas)
                            <span class="text-gray-500">Ya</span>
                        @else
                            <span class="text-gray-500">Tidak</span>
                        @endif
                     </td>
                     <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            @if($item->role === 'admin')
                            <button data-modal-target="editModal{{ $item->id }}"
                                data-modal-toggle="editModal{{ $item->id }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-300 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<div id="createModal" tabindex="-1" aria-hidden="true"class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden" data-modal-backdrop="static">
   <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="createModal"></div>
   <div class="relative w-full max-w-2xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
         <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Tambah Pengguna
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createModal">
               <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
               </svg>
            </button>
         </div>
         <form action="{{ route('pengguna.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                  <input type="text" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kontak</label>
                  <input type="text" name="kontak" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                  <input type="text" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
               </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                  <select id="roleSelect" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                     <option value="" selected disabled>Pilih Role</option>
                     <option value="user">User</option>
                     <option value="admin">Admin</option>
                     <option value="superadmin">Superadmin</option>
                     <option value="pimpinan">Pimpinan</option>
                  </select>
               </div>
               <div id="fakultasSection" class="hidden">
                    <div class="flex items-center">
                    <input id="isFakultas" name="isFakultas" type="checkbox" value="1" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                    <label for="isFakultas" class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Akun Fakultas?</label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">*Centang jika akun digunakan untuk peminjaman dari Fakultas</p>
                </div>
               <div id="saranaSection" class="hidden">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Sarana yang Dapat Diakses</label>
                <div class="space-y-2 max-h-40 overflow-y-auto p-2 border border-gray-200 rounded-lg">
                    @foreach($sarana as $s)
                    @php
                        $isAssigned = \App\Models\AdminAccess::where('sarana_id', $s->id)->exists();
                        $assignedTo = $isAssigned ? \App\Models\AdminAccess::where('sarana_id', $s->id)->first()->user->name : null;
                    @endphp
                   <div class="flex items-center">
                    <input type="checkbox" 
                           name="sarana_ids[]" 
                           value="{{ $s->id }}" 
                           id="sarana_{{ $s->id }}"
                           {{ $isAssigned ? 'disabled' : '' }}
                           class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2 {{ $isAssigned ? 'opacity-50' : '' }}">
                    <label for="sarana_{{ $s->id }}" 
                           class="ml-2 text-sm font-medium {{ $isAssigned ? 'text-gray-400' : 'text-gray-900' }} dark:text-white">
                        {{ $s->nama }}
                        @if($isAssigned)
                            <span class="text-xs text-red-500 ml-2">(Ditugaskan ke: {{ $assignedTo }})</span>
                        @endif
                    </label>
                </div>
                   @endforeach
                </div>
                <p class="mt-1 text-sm text-gray-500">*Pilih sarana yang akan dikelola oleh admin</p>
             </div>
               <div>
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                  <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
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

@foreach($pengguna as $item)
    <div id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true" 
        tabindex="-1" aria-hidden="true"class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden" data-modal-backdrop="static">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="editModal{{ $item->id }}"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-lg shadow dark:bg-gray-700 m-4">
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Admin
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editModal{{$item->id}}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                       <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                 </button>
            </div>

            <form action="{{ route('pengguna.update', $item->id) }}" method="POST" class="edit-form">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" name="name" value="{{ $item->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kontak</label>
                        <input type="text" name="kontak" value="{{ $item->kontak }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" value="{{ $item->email }}" class="bg-gray-200 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 disabled:opacity-70" disabled>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <input type="hidden" name="role" value="{{ $item->role }}">
                        <input type="text" value="{{ ucfirst($item->role) }}" class="bg-gray-200 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5" disabled>
                    </div>
                    <div class="sarana-section {{ $item->role !== 'admin' ? 'hidden' : '' }}">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Sarana yang Dapat Diakses</label>
                        <div class="space-y-2 max-h-40 overflow-y-auto p-2 border border-gray-200 rounded-lg">
                            @foreach($sarana as $s)
                            @php
                                $isAssigned = \App\Models\AdminAccess::where('sarana_id', $s->id)->exists();
                                $assignedToCurrentUser = $item->saranaAccess->contains($s->id);
                                $assignedTo = $isAssigned && !$assignedToCurrentUser ? 
                                            \App\Models\AdminAccess::where('sarana_id', $s->id)->first()->user->name : 
                                            null;
                            @endphp
                            <div class="flex items-center">
                                <input type="checkbox" 
                                    name="sarana_ids[]" 
                                    value="{{ $s->id }}" 
                                    {{ $assignedToCurrentUser ? 'checked' : '' }}
                                    {{ ($isAssigned && !$assignedToCurrentUser) ? 'disabled' : '' }}
                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                                <label class="ml-2 text-sm font-medium {{ ($isAssigned && !$assignedToCurrentUser) ? 'text-gray-400' : 'text-gray-900' }} dark:text-white">
                                    {{ $s->nama }}
                                    @if($isAssigned && !$assignedToCurrentUser)
                                        <span class="text-xs text-red-500 ml-2">(Ditugaskan ke: {{ $assignedTo }})</span>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan</button>
                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" data-modal-hide="editModal{{ $item->id }}">Batal</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function closeModal(modalId) {
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
            modalElement.classList.add('hidden');
            const form = modalElement.querySelector('form');
            if (form) form.reset();
        }
    }

    function initializeModals() {
        // Modal toggle buttons
        document.querySelectorAll('[data-modal-toggle]').forEach(modal => {
            modal.addEventListener('click', function() {
                const target = this.getAttribute('data-modal-target');
                const modalElement = document.getElementById(target);
                
                if (modalElement) {
                    modalElement.classList.remove('hidden');
                }
            });
        });

        // Close buttons
        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', function() {
                const target = this.getAttribute('data-modal-hide');
                closeModal(target);
            });
        });

        // Close on outside click
        window.addEventListener('click', function(event) {
            document.querySelectorAll('[id^="createModal"]').forEach(modal => {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        });
    }

    // Tab handling functions
    function initializeTabs() {
        function showRoleData(role) {
            // Hide all rows
            document.querySelectorAll('.role-row').forEach(row => {
                row.style.display = 'none';
            });

            // Show rows for selected role
            document.querySelectorAll(`.role-row[data-role="${role}"]`).forEach(row => {
                row.style.display = 'table-row';
            });

            // Update active tab styling
            const tabClasses = {
                active: ['text-green-600', 'border-green-600', 'active', 'dark:text-green-500', 'dark:border-green-500'],
                inactive: ['border-transparent']
            };

            document.querySelectorAll('.tab-button').forEach(tab => {
                tab.classList.remove(...tabClasses.active);
                tab.classList.add(...tabClasses.inactive);
            });

            const activeTab = document.querySelector(`.tab-button[data-role="${role}"]`);
            if (activeTab) {
                activeTab.classList.add(...tabClasses.active);
                activeTab.classList.remove(...tabClasses.inactive);
            }
        }

        // Set up tab click handlers
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                const role = button.getAttribute('data-role');
                if (role) showRoleData(role);
            });
        });

        // Show default tab
        showRoleData('user');
    }

    // Form handling
    function handleFormSubmission(e, form, additionalValidation = () => true) {
        e.preventDefault();

        if (!additionalValidation()) return;

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin data yang diinput sudah benar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15803d',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: data.success ? 'success' : 'error',
                        title: data.success ? 'Berhasil!' : 'Gagal!',
                        text: data.message,
                        confirmButtonColor: data.success ? '#15803d' : '#dc2626',
                    }).then(() => {
                        if (data.success && data.redirect) {
                            window.location.href = data.redirect;
                        }
                    });
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan pada server',
                        confirmButtonColor: '#dc2626',
                    });
                });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initializeModals();
        initializeTabs();

        // Handle role selection for admin
        const roleSelect = document.getElementById('roleSelect');
        const saranaSection = document.getElementById('saranaSection');
        const fakultasSection = document.getElementById('fakultasSection');
        
        if (roleSelect && saranaSection && fakultasSection) {
            roleSelect.addEventListener('change', function() {
                const selectedRole = this.value;
                const isAdmin = selectedRole === 'admin';
                const isUser = selectedRole === 'user';
                
                // Show/hide sections based on role
                saranaSection.classList.toggle('hidden', !isAdmin);
                fakultasSection.classList.toggle('hidden', !isUser);
                
                if (!isAdmin) {
                    document.querySelectorAll('input[name="sarana_ids[]"]')
                        .forEach(checkbox => checkbox.checked = false);
                }
                
                if (!isUser) {
                    document.getElementById('isFakultas').checked = false;
                }
            });
        }

        // Initialize form handling
        const form = document.querySelector('form[action*="pengguna"]');
        if (form) {
            form.addEventListener('submit', (e) => {
                const additionalValidation = () => {
                    if (roleSelect?.value === 'admin') {
                        const checkedSarana = document.querySelectorAll('input[name="sarana_ids[]"]:checked');
                        if (checkedSarana.length === 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Admin harus memilih minimal satu sarana untuk dikelola',
                                confirmButtonColor: '#dc2626',
                            });
                            return false;
                        }
                    }
                    return true;
                };

                handleFormSubmission(e, form, additionalValidation);
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
    // Event handler untuk form edit
        document.querySelectorAll('.edit-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Konfirmasi sebelum update
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyimpan perubahan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#15803d',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData(this);
                        
                        fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    confirmButtonColor: '#15803d',
                                }).then(() => {
                                    if(data.redirect) {
                                        window.location.href = data.redirect;
                                    }
                                });
                            } else {
                                throw new Error(data.message || 'Terjadi kesalahan');
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: error.message,
                                confirmButtonColor: '#dc2626',
                            });
                        });
                    }
                });
            });

            // Handle role change di form edit
            const roleSelect = form.querySelector('.role-select');
            const saranaSection = form.querySelector('.sarana-section');
            
            if(roleSelect && saranaSection) {
                roleSelect.addEventListener('change', function() {
                    saranaSection.classList.toggle('hidden', this.value !== 'admin');
                });
            }
        });
    });
</script>
@endsection
