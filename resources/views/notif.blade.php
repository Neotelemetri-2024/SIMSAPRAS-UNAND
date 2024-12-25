@extends('layouts.user')

@section('content')
    <div class="py-24 px-4 mx-auto max-w-screen-xl">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Notifikasi</h2>
                <p class="mt-1 text-sm text-gray-500">Pemberitahuan terkait peminjaman sarana dan prasarana</p>
            </div>

            <!-- Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <ul class="flex -mb-px text-sm font-medium text-center">
                    <li class="flex-1">
                        <button class="relative inline-block p-4 w-full text-blue-600 border-b-2 border-blue-600 active" id="unread-tab">
                            Belum Dibaca
                            @if($unreadNotifications->count() > 0)
                                <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>
                    </li>
                    <li class="flex-1">
                        <button class="relative inline-block p-4 w-full text-gray-500 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" id="read-tab">
                            Sudah Dibaca
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Notifications Content -->
            <div class="space-y-4">
                <!-- Unread Notifications -->
                <div id="unread-content">
                    @forelse($unreadNotifications as $notification)
                        <div class="p-4 bg-white rounded-lg border border-gray-100 hover:border-gray-200 transition-all duration-200">
                            <div class="flex justify-between items-start gap-4">
                                <!-- Status Icon -->
                                <div class="flex-shrink-0">
                                    @if($notification->peminjaman->status == 'disetujui')
                                        <span class="inline-block p-2 bg-green-100 rounded-full">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </span>
                                    @elseif($notification->peminjaman->status == 'ditolak')
                                        <span class="inline-block p-2 bg-red-100 rounded-full">
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="inline-block p-2 bg-blue-100 rounded-full">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $notification->judul }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $notification->isi }}</p>
                                    <span class="mt-2 inline-block text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            Tidak ada notifikasi baru
                        </div>
                    @endforelse
                </div>

                <!-- Read Notifications -->
                <div id="read-content" class="hidden">
                    @forelse($readNotifications as $notification)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="flex justify-between items-start gap-4">
                                <!-- Status Icon -->
                                <div class="flex-shrink-0">
                                    @if($notification->peminjaman->status == 'disetujui')
                                        <span class="inline-block p-2 bg-green-100 rounded-full">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </span>
                                    @elseif($notification->peminjaman->status == 'ditolak')
                                        <span class="inline-block p-2 bg-red-100 rounded-full">
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="inline-block p-2 bg-blue-100 rounded-full">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $notification->judul }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $notification->isi }}</p>
                                    <span class="mt-2 inline-block text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            Tidak ada notifikasi yang sudah dibaca
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        const unreadTab = document.getElementById('unread-tab');
        const readTab = document.getElementById('read-tab');
        const unreadContent = document.getElementById('unread-content');
        const readContent = document.getElementById('read-content');

        unreadTab.addEventListener('click', () => {
            unreadTab.classList.add('text-blue-600', 'border-blue-600');
            unreadTab.classList.remove('text-gray-500', 'border-transparent');
            readTab.classList.remove('text-blue-600', 'border-blue-600');
            readTab.classList.add('text-gray-500', 'border-transparent');
            unreadContent.classList.remove('hidden');
            readContent.classList.add('hidden');
        });

        readTab.addEventListener('click', () => {
            readTab.classList.add('text-blue-600', 'border-blue-600');
            readTab.classList.remove('text-gray-500', 'border-transparent');
            unreadTab.classList.remove('text-blue-600', 'border-blue-600');
            unreadTab.classList.add('text-gray-500', 'border-transparent');
            readContent.classList.remove('hidden');
            unreadContent.classList.add('hidden');
        });
    </script>
@endsection