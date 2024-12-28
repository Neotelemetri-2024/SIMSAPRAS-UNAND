@extends('layouts.user')

@section('content')
<section class="bg-gray-50 pt-32 min-h-screen">
    <div class="max-w-screen-xl px-4 mx-auto lg:px-6">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900">
                Pengumuman
            </h2>
            <p class="mt-2 text-gray-600">
                Informasi dan berita terkini dari Universitas Andalas
            </p>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <form method="GET" action="{{ url()->current() }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Cari Pengumuman</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Masukkan kata kunci judul atau isi pengumuman" 
                           class="w-full py-2.5 px-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div class="sm:w-32 self-end">
                    <button type="submit" class="w-full h-[42px] text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 transition-colors duration-200">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="divide-y divide-gray-200">
                @forelse($pengumuman as $item)
                <div class="p-6 hover:bg-gray-50 transition duration-150 cursor-pointer" onclick="openPengumumanModal('{{ $item->id }}')">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $item->judul }}
                            </p>
                            <p class="text-sm text-gray-500 truncate">
                                {{ Str::limit(strip_tags($item->isi), 150) }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $item->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="ml-4">
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 text-lg">Tidak ada pengumuman</p>
                        <p class="text-gray-400 text-sm mt-1">Saat ini belum terdapat pengumuman</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t">
                {{ $pengumuman->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>

    <!-- Detail Pengumuman Modal -->
    @foreach($pengumuman as $item)
    <div id="pengumumanModal{{ $item->id }}" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full bg-black bg-opacity-50 flex items-center justify-center overflow-x-hidden overflow-y-auto">
        <div class="relative w-full max-w-2xl max-h-full mx-4">
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ $item->judul }}
                    </h3>
                    <button type="button" onclick="closePengumumanModal('{{ $item->id }}')"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <div class="text-sm text-gray-600">
                        <p class="mb-2 text-xs text-gray-500">
                            Dipublikasikan pada: {{ $item->created_at->translatedFormat('d F Y H:i') }}
                        </p>
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