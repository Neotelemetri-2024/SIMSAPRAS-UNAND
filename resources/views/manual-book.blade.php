@extends('layouts.user')

@section('content')
<div class="pt-24 px-4 max-w-screen-xl mx-auto min-h-screen">
    <div class="mb-8">
        <div class="flex flex-col items-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Manual Book SIMSAPRAS</h1>
            <p class="text-gray-600">Download panduan lengkap sesuai dengan role Anda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($manualBooks as $manual)
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                        PDF
                    </span>
                </div>
                
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    {{ $manual['title'] }}
                </h3>
                
                <p class="text-gray-600 text-sm mb-4">
                    {{ $manual['description'] }}
                </p>
                
                <div class="flex gap-2">
                    <a href="{{ route('panduan.manual-book.download', $manual['file']) }}" 
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download
                    </a>
                    
                    <button onclick="previewPdf('{{ $manual['file'] }}')" 
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    @if(empty($manualBooks))
    <div class="text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada manual book tersedia</h3>
        <p class="text-gray-600">Manual book untuk role Anda sedang dalam proses pembuatan.</p>
    </div>
    @endif

    <div class="mt-12 text-center">
        <a href="{{ route('panduan.index') }}" 
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Panduan
        </a>
    </div>
</div>

<!-- Modal Preview PDF -->
<div id="pdfModal" class="fixed inset-0 z-50 hidden overflow-hidden bg-black bg-opacity-50">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-6xl bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Preview Manual Book</h3>
                <button onclick="closePdfModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <iframe id="pdfViewer" src="" width="100%" height="600px" class="border-0"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
function previewPdf(filename) {
    const pdfUrl = `/panduan/manual-book/download/${filename}`;
    document.getElementById('pdfViewer').src = pdfUrl;
    document.getElementById('pdfModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closePdfModal() {
    document.getElementById('pdfModal').classList.add('hidden');
    document.getElementById('pdfViewer').src = '';
    document.body.classList.remove('overflow-hidden');
}

// Close modal when clicking outside
document.getElementById('pdfModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePdfModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePdfModal();
    }
});
</script>
@endsection
