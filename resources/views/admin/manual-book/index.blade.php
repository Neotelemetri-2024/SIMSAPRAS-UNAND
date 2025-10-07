@extends('layouts.main')

@section('content')
<div class="p-4 sm:p-6">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Manual Book - {{ ucfirst(auth()->user()->role) }}</h5>
        </div>

        <div class="p-5">
            @if($manualBook)
            <div class="mb-4">
                <a href="{{ route('panduan.manual-book.download', $manualBook['filename']) }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download Manual Book
                </a>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <div class="bg-white rounded-lg overflow-hidden shadow-sm">
                    <iframe
                        src="{{ route('panduan.manual-book.download', $manualBook['filename']) }}?preview=1"
                        class="w-full border-0"
                        style="height: 1000px; min-height: 1000px;"
                        title="Preview Manual Book">
                    </iframe>
                </div>
            </div>
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Manual Book Tidak Tersedia</h3>
                <p class="text-gray-600">Tidak ada manual book yang tersedia untuk role Anda saat ini.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection