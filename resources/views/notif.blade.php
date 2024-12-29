@extends('layouts.user')

@section('content')
<section class="bg-white pt-24 min-h-screen">
    <div class="max-w-screen-xl px-4 mx-auto lg:px-8">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-3">
                Notifikasi
            </h2>
            <p class="text-gray-600 text-lg">
                Pemberitahuan terkait peminjaman sarana dan prasarana di Universitas Andalas
            </p>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <ul class="flex text-sm font-medium">
                    <li class="flex-1">
                        <button class="relative inline-block p-6 w-full text-green-500 hover:text-green-600 border-b-2 border-green-500 active focus:outline-none transition-all duration-200" id="unread-tab">
                            <span class="font-semibold">Belum Dibaca</span>
                            @if($unreadNotifications->count() > 0)
                                <span class="ml-2 bg-green-100 text-green-600 text-xs font-semibold px-2.5 py-1 rounded-full border border-green-200">
                                    {{ $unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>
                    </li>
                    <li class="flex-1">
                        <button class="relative inline-block p-6 w-full text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-200 focus:outline-none transition-all duration-200" id="read-tab">
                            <span class="font-semibold">Sudah Dibaca</span>
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Notifications Content -->
            <div class="p-6">
                <!-- Unread Notifications -->
                <div id="unread-content" class="space-y-4">
                    @forelse($unreadNotifications as $notification)
                    <div 
                        class="p-6 bg-white rounded-xl border border-gray-200 hover:border-green-200 hover:shadow-md transition-all duration-200 cursor-pointer transform hover:-translate-y-0.5"
                        onclick="markAsRead({{ $notification->id }})"
                        id="notification-{{ $notification->id }}"
                    >
                        <div class="flex items-start gap-4">
                            <!-- Status Icon -->
                            <div class="flex-shrink-0">
                                @if($notification->peminjaman->status == 'disetujui')
                                    <span class="inline-block p-3 bg-emerald-50 rounded-xl border border-emerald-200">
                                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                @elseif($notification->peminjaman->status == 'ditolak')
                                    <span class="inline-block p-3 bg-red-50 rounded-xl border border-red-200">
                                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </span>
                                @else
                                    <span class="inline-block p-3 bg-blue-50 rounded-xl border border-blue-200">
                                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $notification->judul }}</h3>
                                <p class="text-gray-600">{{ $notification->isi }}</p>
                                <div class="mt-3 flex items-center gap-2 text-sm text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-16 text-center">
                        <div class="bg-gray-50 rounded-full p-4 w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <p class="text-xl font-medium text-gray-900 mb-2">Tidak ada notifikasi baru</p>
                        <p class="text-gray-500">Semua notifikasi sudah dibaca</p>
                    </div>
                    @endforelse
                </div>

                <!-- Read Notifications -->
                <div id="read-content" class="hidden space-y-4">
                    @forelse($readNotifications as $notification)
                    <div class="p-6 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="flex items-start gap-4">
                            <!-- Status Icon -->
                            <div class="flex-shrink-0">
                                @if($notification->peminjaman->status == 'disetujui')
                                    <span class="inline-block p-3 bg-emerald-50/50 rounded-xl border border-emerald-200">
                                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                @elseif($notification->peminjaman->status == 'ditolak')
                                    <span class="inline-block p-3 bg-red-50/50 rounded-xl border border-red-200">
                                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </span>
                                @else
                                    <span class="inline-block p-3 bg-blue-50/50 rounded-xl border border-blue-200">
                                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $notification->judul }}</h3>
                                <p class="text-gray-600">{{ $notification->isi }}</p>
                                <div class="mt-3 flex items-center gap-2 text-sm text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-16 text-center">
                        <div class="bg-gray-50 rounded-full p-4 w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <p class="text-xl font-medium text-gray-900 mb-2">Tidak ada notifikasi yang sudah dibaca</p>
                        <p class="text-gray-500">Notifikasi yang sudah dibaca akan muncul di sini</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<script>
 const unreadTab = document.getElementById('unread-tab');
    const readTab = document.getElementById('read-tab');
    const unreadContent = document.getElementById('unread-content');
    const readContent = document.getElementById('read-content');

    unreadTab.addEventListener('click', () => {
        // Update tab styles
        unreadTab.classList.add('text-green-500', 'border-green-500');
        unreadTab.classList.remove('text-gray-500', 'border-transparent');
        readTab.classList.remove('text-green-500', 'border-green-500');
        readTab.classList.add('text-gray-500', 'border-transparent');

        // Show/hide content
        unreadContent.classList.remove('hidden');
        readContent.classList.add('hidden');
    });

    readTab.addEventListener('click', () => {
        // Update tab styles
        readTab.classList.add('text-green-500', 'border-green-500');
        readTab.classList.remove('text-gray-500', 'border-transparent');
        unreadTab.classList.remove('text-green-500', 'border-green-500');
        unreadTab.classList.add('text-gray-500', 'border-transparent');

        // Show/hide content
        readContent.classList.remove('hidden');
        unreadContent.classList.add('hidden');
    });

function markAsRead(notifikasiId) {
    const notifikasi = document.getElementById(`notification-${notifikasiId}`);
    if (!notifikasi) return;
    
    const readNotifikasi = notifikasi.cloneNode(true);
    readNotifikasi.classList.remove('cursor-pointer', 'hover:border-green-200', 'hover:shadow-sm');
    readNotifikasi.classList.add('bg-gray-50');
    readNotifikasi.removeAttribute('onclick');

    const readContent = document.getElementById('read-content');
    readContent.insertBefore(readNotifikasi, readContent.firstChild);
    notifikasi.remove();

    // Update counter
    const unreadCount = document.querySelector('#unread-tab span');
    if (unreadCount) {
        const currentCount = parseInt(unreadCount.textContent);
        if (currentCount > 1) {
            unreadCount.textContent = currentCount - 1;
        } else {
            unreadCount.remove();
        }
    }

    // Check empty state
    if (unreadContent.children.length === 0) {
        unreadContent.innerHTML = `
            <div class="py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <p class="mt-4 text-gray-500 text-lg">Tidak ada notifikasi baru</p>
                <p class="mt-2 text-gray-400 text-sm">Semua notifikasi sudah dibaca</p>
            </div>
        `;
    }

    // Send request to server
    fetch(`/notifikasi/${notifikasiId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    }).catch(error => console.error('Error:', error));
}
</script>
@endsection