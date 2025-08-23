@extends('layouts.user')

@section('content')
    <section class="bg-white pt-24 min-h-screen">
        <div class="max-w-screen-xl px-4 mx-auto lg:px-8">

            <!-- Header Section -->
            <div class="mb-12 text-center">
                <h2 class="text-4xl font-bold text-gray-900 mb-3">
                    Pengumuman
                </h2>
                <p class="text-gray-600 text-lg">
                    Informasi dan berita terkini dari Universitas Andalas
                </p>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Integrated Search -->
                <div class="border-b border-gray-200">
                    <form method="GET" action="{{ url()->current() }}" class="p-6">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <label class="text-sm font-medium text-gray-700 mb-2 block">Cari Pengumuman</label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Masukkan kata kunci judul atau isi pengumuman"
                                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="sm:w-32 self-end">
                                <button type="submit"
                                    class="w-full h-12 text-white bg-green-500 hover:bg-green-600 font-medium rounded-xl text-sm px-6 transition-all duration-200 shadow-sm hover:shadow-md">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Announcements List -->
                <div class="divide-y divide-gray-100">
                    @forelse($pengumuman as $item)
                        <div class="p-6 hover:bg-gray-50 transition-all duration-200 cursor-pointer group"
                            onclick="openPengumumanModal('{{ $item->hashed_id }}')">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0 pr-6">
                                    <h3
                                        class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                        {{ $item->judul }}
                                    </h3>
                                    <p class="text-gray-600 mb-2 line-clamp-2">
                                        {{ Str::limit(strip_tags($item->isi), 200) }}
                                    </p>
                                    <div class="flex items-center gap-2 text-sm text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $item->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="text-gray-400 group-hover:text-green-500 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-gray-50 rounded-full p-3 mb-4">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-gray-900 text-xl font-medium">Tidak ada pengumuman</p>
                                <p class="text-gray-500 mt-2">Saat ini belum terdapat pengumuman</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-100">
                    {{ $pengumuman->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>

        <!-- Detail Pengumuman Modal -->
        @foreach ($pengumuman as $item)
            <div id="pengumumanModal{{ $item->hashed_id }}" tabindex="-1" aria-hidden="true"
                class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full bg-black bg-opacity-50 flex items-center justify-center overflow-x-hidden overflow-y-auto">
                <div class="relative w-full max-w-2xl max-h-full mx-4">
                    <div class="relative bg-white rounded-2xl shadow-lg">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-6 border-b">
                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $item->judul }}
                            </h3>
                            <button type="button" onclick="closePengumumanModal('{{ $item->hashed_id }}')"
                                class="text-gray-400 bg-gray-50 hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm p-2 inline-flex items-center transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal body -->
                        <div class="p-6">
                            <div class="mb-6 flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Dipublikasikan pada: {{ $item->created_at->translatedFormat('d F Y H:i') }}
                            </div>
                            <div class="prose max-w-none text-gray-600">
                                {!! $item->isi !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>


    <script>
        function openPengumumanModal(id) {
            const modal = document.getElementById('pengumumanModal' + id);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closePengumumanModal(id) {
            const modal = document.getElementById('pengumumanModal' + id);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('[id^="pengumumanModal"]');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
@endsection
