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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Status Peminjaman</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-col items-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Status Peminjaman</h1>
                <p class="text-gray-600">Pahami berbagai status dalam proses peminjaman sarana dan prasarana</p>
            </div>
        </div>

        <!-- Status Cards -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($statuses as $status)
                <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-{{ $status['color'] }}-100 rounded-lg">
                            <svg class="w-6 h-6 text-{{ $status['color'] }}-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $status['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-xl font-semibold text-gray-900">{{ $status['status'] }}</h3>
                    </div>
                    <p class="text-gray-600">{{ $status['description'] }}</p>
                </div>
            @endforeach
        </div>

        <!-- Additional Info -->
        <div class="mt-12 p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Tambahan</h2>
            <ul class="space-y-4 text-gray-600">
                <li class="flex items-start">
                    <svg class="w-4 h-4 mt-1 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>Status peminjaman akan diperbarui secara otomatis oleh sistem sesuai dengan proses yang sedang
                        berlangsung.</p>
                </li>
                <li class="flex items-start">
                    <svg class="w-4 h-4 mt-1 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>Anda akan menerima notifikasi setiap kali status peminjaman berubah.</p>
                </li>
            </ul>
        </div>
    </div>
@endsection
