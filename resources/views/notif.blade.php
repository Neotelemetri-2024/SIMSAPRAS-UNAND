@extends('layouts.user')

@section('content')
<section class="bg-gray-50 pt-32 min-h-screen">
    <div class="max-w-screen-2xl px-4 mx-auto lg:px-6">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900">
                Notifikasi
            </h2>
            <p class="mt-2 text-gray-600">
                Pemberitahuan terkait peminjaman sarana dan prasarana di Universitas Andalas
            </p>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-gray-200">
                <ul class="flex text-sm font-medium">
                    <li class="flex-1">
                        <button class="relative inline-block p-4 w-full text-green-600 border-b-2 border-green-600 active group" id="unread-tab">
                            Belum Dibaca
                            @if($unreadNotifications->count() > 0)
                                <span class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>
                    </li>
                    <li class="flex-1">
                        <button class="relative inline-block p-4 w-full text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 group" id="read-tab">
                            Sudah Dibaca
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
                        class="p-4 bg-white rounded-lg border border-gray-200 hover:border-green-200 hover:shadow-sm transition-all duration-200 cursor-pointer"
                        onclick="markAsRead({{ $notification->id }})"
                        id="notification-{{ $notification->id }}"
                    >
                        <div class="flex items-start gap-4">
                            <!-- Status Icon -->
                            <div class="flex-shrink-0">
                                @if($notification->peminjaman->status == 'disetujui')
                                    <span class="inline-block p-2 bg-emerald-100 rounded-full">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                @elseif($notification->peminjaman->status == 'ditolak')
                                    <span class="inline-block p-2 bg-red-100 rounded-full">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </span>
                                @else
                                    <span class="inline-block p-2 bg-blue-100 rounded-full">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-900 mb-1">{{ $notification->judul }}</h3>
                                <p class="text-sm text-gray-600">{{ $notification->isi }}</p>
                                <span class="mt-2 inline-block text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <p class="mt-4 text-gray-500 text-lg">Tidak ada notifikasi baru</p>
                        <p class="mt-2 text-gray-400 text-sm">Semua notifikasi sudah dibaca</p>
                    </div>
                    @endforelse
                </div>

                <!-- Read Notifications -->
                <div id="read-content" class="hidden space-y-4">
                    @forelse($readNotifications as $notification)
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-start gap-4">
                            <!-- Status Icon -->
                            <div class="flex-shrink-0">
                                @if($notification->peminjaman->status == 'disetujui')
                                    <span class="inline-block p-2 bg-emerald-100 rounded-full">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                @elseif($notification->peminjaman->status == 'ditolak')
                                    <span class="inline-block p-2 bg-red-100 rounded-full">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </span>
                                @else
                                    <span class="inline-block p-2 bg-blue-100 rounded-full">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-900 mb-1">{{ $notification->judul }}</h3>
                                <p class="text-sm text-gray-600">{{ $notification->isi }}</p>
                                <span class="mt-2 inline-block text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <p class="mt-4 text-gray-500 text-lg">Tidak ada notifikasi yang sudah dibaca</p>
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

function switchTab(activeTab, inactiveTab, showContent, hideContent) {
    // Active tab
    activeTab.classList.remove('text-gray-500', 'border-transparent');
    activeTab.classList.add('text-green-600', 'border-green-600');
    
    // Inactive tab
    inactiveTab.classList.remove('text-green-600', 'border-green-600');
    inactiveTab.classList.add('text-gray-500', 'border-transparent');
    
    // Content
    showContent.classList.remove('hidden');
    hideContent.classList.add('hidden');
}

unreadTab.addEventListener('click', () => {
    switchTab(unreadTab, readTab, unreadContent, readContent);
});

readTab.addEventListener('click', () => {
    switchTab(readTab, unreadTab, readContent, unreadContent);
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