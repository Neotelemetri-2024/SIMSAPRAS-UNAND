@extends('layouts.main')

@section('content')
    <div class="p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola semua pemberitahuan terkait peminjaman sarana dan prasarana</p>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow">
            <!-- Enhanced Tabs -->
            <div class="border-b border-gray-200">
                <div class="flex">
                    <button 
                        class="group relative min-w-0 flex-1 overflow-hidden py-4 px-6 text-center text-sm font-medium focus:z-10 focus:outline-none"
                        id="unread-tab"
                    >
                        <div class="flex items-center justify-center">
                            <span class="text-blue-600">Belum Dibaca</span>
                            @if($unreadNotifications->count() > 0)
                                <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $unreadNotifications->count() }}
                                </span>
                            @endif
                        </div>
                        <div class="absolute inset-x-0 bottom-0 h-0.5 bg-blue-600"></div>
                    </button>
                    <button 
                        class="group relative min-w-0 flex-1 overflow-hidden py-4 px-6 text-center text-sm font-medium focus:z-10 focus:outline-none"
                        id="read-tab"
                    >
                        <div class="flex items-center justify-center">
                            <span class="text-gray-500">Sudah Dibaca</span>
                        </div>
                        <div class="absolute inset-x-0 bottom-0 h-0.5 bg-transparent"></div>
                    </button>
                </div>
            </div>

            <!-- Notifications Content -->
            <div class="divide-y divide-gray-200">
                <!-- Unread Notifications -->
                <div id="unread-content" class="p-4 space-y-4">
                    @forelse($unreadNotifications as $notification)
                        <div 
                            class="group p-4 bg-white rounded-lg border border-gray-200 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                            onclick="markAsRead({{ $notification->id }})"
                            id="notification-{{ $notification->id }}"
                            data-notification-id="{{ $notification->id }}"
                        >
                            <div class="flex items-start gap-4">
                                <!-- Status Icon -->
                                <div class="flex-shrink-0">
                                    <span class="inline-flex p-2 bg-blue-100 group-hover:bg-blue-200 rounded-full transition-colors duration-200">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600">
                                            {{ $notification->judul }}
                                        </h3>
                                        <span class="ml-2 text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                        {{ $notification->isi }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="mt-4 text-sm text-gray-500">Tidak ada notifikasi baru</p>
                        </div>
                    @endforelse
                    @if($unreadNotifications->hasPages())
                        <div class="mt-4">
                            {{ $unreadNotifications->withQueryString()->links() }}
                        </div>
                    @endif
                </div>

                <div id="read-content" class="hidden p-4 space-y-4">
                    @forelse($readNotifications as $notification)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200" id="read-notification-{{ $notification->id }}">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex p-2 bg-blue-100 rounded-full">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <h3 class="text-sm font-semibold text-gray-800">
                                            {{ $notification->judul }}
                                        </h3>
                                        <span class="ml-2 text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                        {{ $notification->isi }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="mt-4 text-sm text-gray-500">Tidak ada notifikasi yang sudah dibaca</p>
                        </div>
                    @endforelse
                    @if($readNotifications->hasPages())
                        <div class="mt-4">
                            {{ $readNotifications->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const unreadTab = document.getElementById('unread-tab');
            const readTab = document.getElementById('read-tab');
            const unreadContent = document.getElementById('unread-content');
            const readContent = document.getElementById('read-content');

            // Keep track of notification states
            const readNotificationIds = new Set();

            function switchTab(activeTab, inactiveTab, showContent, hideContent) {
                // Update active tab styling
                activeTab.querySelector('span').classList.remove('text-gray-500');
                activeTab.querySelector('span').classList.add('text-blue-600');
                activeTab.querySelector('div:last-child').classList.remove('bg-transparent');
                activeTab.querySelector('div:last-child').classList.add('bg-blue-600');

                // Update inactive tab styling
                inactiveTab.querySelector('span').classList.remove('text-blue-600');
                inactiveTab.querySelector('span').classList.add('text-gray-500');
                inactiveTab.querySelector('div:last-child').classList.remove('bg-blue-600');
                inactiveTab.querySelector('div:last-child').classList.add('bg-transparent');

                // Show/hide content
                showContent.classList.remove('hidden');
                hideContent.classList.add('hidden');
            }

            unreadTab.addEventListener('click', () => {
                switchTab(unreadTab, readTab, unreadContent, readContent);
            });

            readTab.addEventListener('click', () => {
                switchTab(readTab, unreadTab, readContent, unreadContent);
            });
        });

        async function markAsRead(notifikasiId) {
            const notifikasi = document.getElementById(`notification-${notifikasiId}`);
            if (!notifikasi) return;

            try {
                // Send request to server first
                const response = await fetch(`/admin/notifikasi/${notifikasiId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const unreadContent = document.getElementById('unread-content');
                const readContent = document.getElementById('read-content');

                // Clone and modify the notification
                const readNotifikasi = notifikasi.cloneNode(true);
                
                // Remove interactive classes and attributes
                readNotifikasi.classList.remove(
                    'cursor-pointer', 
                    'hover:border-blue-200', 
                    'hover:bg-blue-50', 
                    'group'
                );
                readNotifikasi.classList.add('bg-gray-50');
                readNotifikasi.removeAttribute('onclick');
                readNotifikasi.id = `read-notification-${notifikasiId}`;

                // Update styling for read state
                const iconContainer = readNotifikasi.querySelector('.inline-flex');
                if (iconContainer) {
                    iconContainer.classList.remove(
                        'group-hover:bg-green-200', 
                        'group-hover:bg-red-200', 
                        'group-hover:bg-blue-200'
                    );
                }

                // Add to read tab and remove from unread
                readContent.insertBefore(readNotifikasi, readContent.firstChild);
                notifikasi.remove();

                // Update counter
                const unreadCount = document.querySelector('#unread-tab .rounded-full');
                if (unreadCount) {
                    const currentCount = parseInt(unreadCount.textContent);
                    if (currentCount > 1) {
                        unreadCount.textContent = currentCount - 1;
                    } else {
                        unreadCount.remove();
                    }
                }

                // Check if unread section is empty
                if (unreadContent.children.length === 0) {
                    unreadContent.innerHTML = `
                        <div class="flex flex-col items-center justify-center py-12">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="mt-4 text-sm text-gray-500">Tidak ada notifikasi baru</p>
                        </div>
                    `;
                }

                // Remove empty state in read section if it exists
                const emptyReadState = readContent.querySelector('.flex.flex-col.items-center');
                if (emptyReadState) {
                    emptyReadState.remove();
                }

            } catch (error) {
                console.error('Error marking notification as read:', error);
                // Optionally show error message to user
                alert('Gagal menandai notifikasi sebagai sudah dibaca. Silakan coba lagi.');
            }
        }
    </script>
@endsection