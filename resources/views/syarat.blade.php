@extends('layouts.user')

@section('content')
    <div class="pt-24 px-4 max-w-screen-xl mx-auto min-h-screen">
        <!-- Header Section -->
        <div class="mb-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-gray-700 hover:text-green-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('panduan.index') }}"
                                class="ml-1 text-gray-700 hover:text-green-600 md:ml-2">Panduan Pengguna</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Syarat & Ketentuan</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-col items-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Syarat & Ketentuan Peminjaman</h1>
                <p class="text-gray-600">Pahami persyaratan dan ketentuan dalam peminjaman sarana dan prasarana</p>
            </div>
        </div>

        <!-- Requirements Sections -->
        <div class="space-y-6">
            @foreach ($requirements as $requirement)
                <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ $requirement['title'] }}</h2>
                    <ul class="space-y-3">
                        @foreach ($requirement['items'] as $item)
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mt-1 mr-3 flex-shrink-0 text-green-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-600">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <!-- Additional Info -->
        <div class="mt-8 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Penting untuk diperhatikan</h3>
                    <p class="mt-2 text-sm text-yellow-700">
                        Ketentuan ini dapat berubah sewaktu-waktu. Silakan hubungi admin untuk informasi lebih lanjut atau
                        jika Anda memiliki pertanyaan khusus.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
