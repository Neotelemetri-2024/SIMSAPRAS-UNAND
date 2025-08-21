<div id="createModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden" data-modal-backdrop="static">
   <!-- Backdrop with higher z-index -->
   <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="createModal"></div>
    <!-- Modal content -->
    <div class="relative w-full max-w-2xl max-h-full mx-auto my-4">
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
            <form action="{{ route('pengguna.store') }}" method="POST" id="createForm">
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
                        <input type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <select id="roleSelect" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                            <option value="" selected disabled>Pilih Role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize modals
    const initializeModals = () => {
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.getElementById(button.dataset.modalTarget);
                if (target) target.classList.remove('hidden');
            });
        });
    };

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

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.add('hidden');
    }

    // Simplified form handling - removed excessive validation
    const handleFormSubmission = async (e, form) => {
        e.preventDefault();

        const result = await Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah data yang diinput sudah benar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#15803d',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                await Swal.fire({
                    icon: data.success ? 'success' : 'error',
                    title: data.success ? 'Berhasil!' : 'Gagal!',
                    text: data.message,
                    confirmButtonColor: data.success ? '#15803d' : '#dc2626'
                });

                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
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
    };

    // Role selection handling
    const roleSelect = document.getElementById('roleSelect');
    const saranaSection = document.getElementById('saranaSection');
    const fakultasSection = document.getElementById('fakultasSection');

    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            const isAdmin = this.value === 'admin';
            const isUser = this.value === 'user';
            saranaSection?.classList.toggle('hidden', !isAdmin);
            fakultasSection?.classList.toggle('hidden', !isUser);

            if (!isAdmin) {
                document.querySelectorAll('input[name="sarana_ids[]"]').forEach(cb => cb.checked = false);
            }
            if (!isUser) {
                const isFakultas = document.getElementById('isFakultas');
                if (isFakultas) isFakultas.checked = false;
            }
        });
    }

    // Initialize form handling
    document.querySelectorAll('form[id="createForm"], form.edit-form').forEach(form => {
        form.addEventListener('submit', (e) => handleFormSubmission(e, form));
    });

    initializeModals();
});
</script>
@endpush