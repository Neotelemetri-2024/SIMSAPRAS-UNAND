<div id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="editModal{{ $item->id }}"></div>
    <div class="relative w-full max-w-2xl bg-white rounded-lg shadow dark:bg-gray-700 m-4">
        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Edit Admin
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editModal{{ $item->id }}">
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
                    <input type="email" name="email" value="{{ $item->email }}" class="bg-gray-200 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 disabled:opacity-70" disabled>
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