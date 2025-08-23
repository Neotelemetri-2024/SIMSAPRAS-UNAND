@extends('layouts.user')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet">
<!-- Updated styles -->
<style>
   .carousel-container {
        display: flex;
        transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        will-change: transform;
    }
    
    .carousel-item {
        flex: 0 0 100%;
        will-change: transform;
    }
    
    .carousel-item img {
        will-change: transform;
        transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .carousel-item.sliding {
        transition: none;
    }
    
    @keyframes progressBar {
        from { width: 0; }
        to { width: 100%; }
    }
    
    .progress-bar {
        animation: progressBar 5s linear;
    }
   .fc { 
   height: 100%;
   background-color: white;
   border-radius: 0.5rem;
   }
   .fc .fc-view-harness {
   height: auto !important;
   margin-bottom: 0 !important;
   }
   .fc-daygrid-body {
   height: auto !important;
   }
   .fc-header-toolbar {
   padding: 1rem;
   }
   #calendar {
   height: auto !important;
   /* height: 7px; */
   min-height: 600px !important;
   margin-bottom: 0 !important;
   }
   .calendar-wrapper {
   background-color: white;
   padding: 1.5rem;
   border-radius: 0.75rem;
   box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
   }
   /* Changed button colors to green */
   .fc .fc-button {
   background-color: #ffffff !important;
   border: 1px solid #e5e7eb !important;
   color: #374151 !important;
   }
   .fc .fc-button:hover {
   background-color: #f9fafb !important;
   border-color: #16a34a !important;
   }
   .fc .fc-button-primary:not(:disabled).fc-button-active,
   .fc .fc-button-primary:not(:disabled):active {
   background-color: #16a34a !important;
   border-color: #15803d !important;
   color: #ffffff !important;
   }
   .fc .fc-button-primary:disabled {
   background-color: #f3f4f6 !important;
   border-color: #e5e7eb !important;
   color: #9ca3af !important;
   }
   .fc .fc-toolbar-title {
   font-size: 1.25rem;
   font-weight: 600;
   color: #111827;
   }
   .fc-theme-standard td, 
   .fc-theme-standard th {
   border-color: #f3f4f6;
   }
   .fc .fc-day-today {
   background-color: #f0f9ff !important;
   }
   .fc-event {
   padding: 2px 4px;
   font-size: 0.875rem;
   border-radius: 4px;
   color: white !important;
   }
   /* Remove blue dot from events */
   .fc-daygrid-event-dot {
   display: none !important;
   }
   /* Remove any default event styles */
   .fc-event, .fc-event-dot {
   background-color: transparent !important;
   border: none !important;
   }
   .selected-date {
   background-color: rgba(34, 197, 94, 0.2) !important;
   }
   /* .fc-day.fc-disabled-date {
   background-color: rgba(239, 68, 68, 0.1) !important;
   cursor: not-allowed !important;
   } */
   .fc-has-event {
   background-color: rgba(203, 213, 225, 0.3) !important;
   cursor: not-allowed !important;
   }
   .fc-day.fc-holiday, .fc-daygrid-day.fc-holiday {
        background-color: #fee2e2 !important; /* merah muda */
        position: relative;
    }
    .fc-day.fc-holiday .fc-daygrid-day-number,
    .fc-daygrid-day.fc-holiday .fc-daygrid-day-number {
        color: #dc2626 !important; /* merah tua untuk angka tanggal */
        font-weight: bold;
    }
    .fc-holiday-event, .fc-event.fc-holiday-event {
        color: #dc2626 !important;
        background: transparent !important;
        border: none !important;
        font-weight: bold;
    }
   /* Centered warning popup with close button */
   .warning-popup {
   position: fixed !important;
   top: 50% !important;
   left: 50% !important;
   transform: translate(-50%, -50%) !important;
   z-index: 1000 !important;
   }
   .warning-content {
   background-color: #ef4444 !important;
   color: white !important;
   padding: 1.5rem !important;
   border-radius: 8px !important;
   text-align: center !important;
   max-width: 300px !important;
   display: flex !important;
   flex-direction: column !important;
   gap: 1rem !important;
   }
   .warning-close-btn {
   background-color: white !important;
   color: #ef4444 !important;
   border: none !important;
   padding: 0.5rem 1rem !important;
   border-radius: 6px !important;
   font-weight: 500 !important;
   cursor: pointer !important;
   }
   /* Event status colors */
    .status-disetujui { 
        background-color: #059669 !important;
        border-color: #047857 !important;
    }

    .status-diproses { 
        background-color: #f97316 !important;
        border-color: #ea580c !important;
    }

    .status-diajukan { 
        background-color: #f97316 !important;
        border-color: #ea580c !important;
    }

    .status-diajukanbatal { 
        background-color: #f97316 !important;
        border-color: #ea580c !important;
    }

    /* Update the legend colors to match */
    .legend-approved {
        background-color: #059669;
    }

    .legend-pending {
        background-color: #f97316;
    }

   @media (max-width: 640px) {
   .fc .fc-toolbar {
   flex-direction: column;
   gap: 1rem;
   }
   .fc .fc-toolbar-title {
   font-size: 1.2em;
   }
   }
</style>
@endpush
@section('content')
<section class="bg-white pt-32 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Content Grid -->
        <div class="space-y-8 mb-12">
            <!-- Title Section -->
            <div class="text-center">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">{{ $sarana->nama }}</h1>
            </div>

            <!-- Carousel Section - Full Width -->
            <div id="carousel" class="relative group rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                <div class="relative h-[500px] lg:h-[600px]">
                    <!-- Progress bar -->
                    <div class="absolute top-0 left-0 w-full h-1 bg-white/20 z-10">
                        <div class="progress-bar h-full bg-white/60 transition-all duration-[5000ms] w-0"></div>
                    </div>

                    <div class="carousel-container absolute w-full h-full flex">
                        @foreach($sarana->gambarSarana as $index => $gambar)
                        <div class="carousel-item w-full h-full flex-shrink-0">
                            <img src="{{ asset('storage/' . $gambar->gambar) }}" 
                                 alt="{{ $sarana->nama }}" 
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        </div>
                        @endforeach
                    </div>

                    <!-- Navigation Buttons -->
                    <button onclick="moveSlide(-1)" 
                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 text-white p-3 rounded-full
                                   transform transition-all duration-300 ease-out opacity-0 group-hover:opacity-100 hover:scale-110
                                   hover:bg-black/60 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button onclick="moveSlide(1)" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 text-white p-3 rounded-full
                                   transform transition-all duration-300 ease-out opacity-0 group-hover:opacity-100 hover:scale-110
                                   hover:bg-black/60 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <!-- Indicators -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-3 z-10">
                        @foreach($sarana->gambarSarana as $index => $gambar)
                        <button onclick="goToSlide({{ $index }})" 
                                class="w-2.5 h-2.5 rounded-full transition-all duration-300 ease-out transform
                                       {{ $index === 0 ? 'bg-white scale-125' : 'bg-white/50 hover:scale-110 hover:bg-white/70' }}">
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Detail Information Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Kolom Kiri: Deskripsi & Fasilitas -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Detail Informasi
                    </h2>
                    
                    <!-- Kapasitas -->
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-gray-700 mb-3">Kapasitas</h3>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="font-medium text-lg">{{ $sarana->kapasitas }} orang</span>
                        </div>
                    </div>
                    
                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-gray-700 mb-3">Deskripsi</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $sarana->deskripsi }}</p>
                    </div>

                    <!-- Fasilitas -->
                    <div>
                        <h3 class="text-md font-semibold text-gray-700 mb-3">Fasilitas</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $sarana->fasilitas }}</p>
                    </div>
                </div>

                <!-- Kolom Kanan: Admin & Penjaga -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Kontak & Pengelola
                    </h2>
                    
                    <!-- Admin -->
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-gray-700 mb-3">Admin</h3>
                        @if($admin)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 mb-1">{{ $admin->name }}</h4>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $admin->kontak }}</span>
                                </div>
                            </div>
                        </div>
                        @else
                        <p class="text-gray-500 py-2">Tidak ada informasi admin</p>
                        @endif
                    </div>

                    <!-- Penjaga -->
                    <div>
                        <h3 class="text-md font-semibold text-gray-700 mb-3">Penjaga</h3>
                        @forelse($sarana->penjaga as $penjaga)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 mb-1">{{ $penjaga->nama }}</h4>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $penjaga->kontak }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 py-2">Tidak ada informasi penjaga</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Jam Lembur Section - Compact for Mobile -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-blue-800 mb-4">Informasi Jam Lembur Tahun {{ now()->year }}</h3>
                
                <!-- Jam Lembur Bulan Berjalan - Prominent -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h4 class="text-md font-semibold text-blue-700 mb-3">{{ $bulanIni }} (Bulan Berjalan)</h4>
                    <div class="flex items-center mb-2">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full" style="width: {{ min(100, ($jamLemburBulanIni / 40) * 100) }}%"></div>
                        </div>
                        <span class="ml-3 text-sm font-medium text-blue-700">{{ min(100, round(($jamLemburBulanIni / 40) * 100)) }}%</span>
                    </div>
                    <p class="text-sm text-blue-700">
                        <span class="font-medium">Terpakai:</span> {{ $jamLemburBulanIni }} jam | 
                        <span class="font-medium">Sisa:</span> {{ max(0, 40 - $jamLemburBulanIni) }} jam dari 40 jam
                    </p>
                </div>
                
                <!-- Toggle untuk Data Bulan Lain -->
                <div class="text-center">
                    <button id="toggleJamLembur" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <span id="toggleText">Lihat Data Bulan Lainnya</span>
                    </button>
                </div>
                
                <!-- Data Bulan Lain - Tersembunyi by Default -->
                <div id="dataJamLembur" class="hidden mt-6">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        @foreach($dataJamLembur as $data)
                            @if(!$data['is_current'])
                            <div class="p-3 bg-white rounded-lg border border-gray-200 text-center">
                                <h5 class="text-xs font-semibold text-gray-700 mb-2">{{ substr($data['bulan'], 0, 3) }}</h5>
                                <div class="flex items-center justify-center mb-1">
                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                        <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $data['persentase'] }}%"></div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600">{{ $data['jam_terpakai'] }}/40</p>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <p class="text-xs text-blue-600">
                        <i>Jam lembur: Sabtu/Minggu atau setelah pukul 16:00 | Maks: 40 jam/bulan</i>
                    </p>
                </div>
            </div>
        </div>

        <!-- Calendar/Room Section -->
        @if($sarana->isRoom == 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900">Jadwal Peminjaman</h2>
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded bg-[#ef4444]/50 border border-red-400"></div>
                                <span class="text-sm text-gray-600">Libur Nasional</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded bg-[#059669]"></div>
                                <span class="text-sm text-gray-600">Disetujui</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded bg-[#F97316]"></div>
                                <span class="text-sm text-gray-600">Diajukan/Diproses/Pengajuan Batal</span>
                            </div>
                        </div>
                    </div>

                    <div id="calendar" class="min-h-[700px]"></div>

                    <div class="mt-8">
                        <form action="{{ route('peminjaman.create') }}" method="GET" id="peminjamanForm">
                            <input type="hidden" name="sarana_id" value="{{ $sarana->id }}">
                            <input type="hidden" name="selected_dates" id="selectedDates">
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Tanggal Yang Dipilih:</h3>
                                <div id="selectedDatesDisplay" class="p-4 bg-gray-50 rounded-xl min-h-[50px]">
                                    <p class="text-gray-500">Belum ada tanggal yang dipilih</p>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" 
                                    class="inline-flex items-center px-8 py-4 text-lg font-medium text-white bg-green-500 rounded-xl hover:bg-green-600 focus:ring-4 focus:ring-green-300 disabled:bg-gray-400 disabled:cursor-not-allowed transition-all duration-200 shadow-sm hover:shadow-md"
                                    id="submitBtn" disabled>
                                    Ajukan Peminjaman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- Room Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900">Daftar Ruangan</h2>
                        <form action="{{ route('user.sarana.show', $sarana) }}" method="GET" class="flex">
                            <input type="text" name="search" value="{{ $search }}" 
                                   placeholder="Cari ruangan..." 
                                   class="px-4 py-3 border border-gray-200 rounded-l-xl focus:ring-2 focus:ring-green-300 focus:outline-none w-64">
                            <button type="submit" 
                                    class="px-6 py-3 bg-green-500 text-white rounded-r-xl hover:bg-green-600 focus:ring-4 focus:ring-green-300 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                            </button>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($ruangan as $room)
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-green-200 hover:shadow-md transition-all duration-200">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $room->nama }}</h3>
                            <p class="text-gray-600 mb-6">{{ \Illuminate\Support\Str::words($room->deskripsi, 18, '...') }}</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span>{{ $room->kapasitas }} orang</span>
                                </div>
                                <a href="{{ route('ruangan.show', $room) }}" 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 transition-all duration-200">
                                    Lihat Detail
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 py-12 text-center">
                            <div class="bg-gray-50 rounded-full p-4 w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <p class="text-xl font-medium text-gray-900 mb-2">Tidak ada ruangan yang ditemukan</p>
                            <p class="text-gray-500">Silakan coba dengan kata kunci lain</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $ruangan->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentSlide = 0;
        let autoplayInterval = null;
        let progressInterval = null;
        const carouselContainer = document.querySelector('.carousel-container');
        const slides = document.querySelectorAll('.carousel-item');
        const indicators = document.querySelectorAll('.bottom-4 button');
        const progressBar = document.querySelector('.progress-bar');
        const totalSlides = slides.length;
        let isTransitioning = false;
        
        if (!slides.length) return;

        function updateSlidePosition(animate = true) {
            if (!animate) {
                carouselContainer.style.transition = 'none';
                requestAnimationFrame(() => {
                    carouselContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
                    requestAnimationFrame(() => {
                        carouselContainer.style.transition = '';
                    });
                });
            } else {
                carouselContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
            }
            
            // Update indicators with scale effect
            indicators.forEach((indicator, index) => {
                if (index === currentSlide) {
                    indicator.classList.add('bg-white', 'scale-125');
                    indicator.classList.remove('bg-white/50', 'scale-100');
                } else {
                    indicator.classList.remove('bg-white', 'scale-125');
                    indicator.classList.add('bg-white/50', 'scale-100');
                }
            });

            // Reset and start progress bar
            resetProgressBar();
        }

        function moveSlide(direction) {
            if (isTransitioning) return;
            isTransitioning = true;
            
            currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
            updateSlidePosition();
            
            setTimeout(() => {
                isTransitioning = false;
            }, 700); // Match transition duration
        }

        function goToSlide(index) {
            if (isTransitioning || currentSlide === index) return;
            
            currentSlide = index;
            updateSlidePosition();
        }

        function resetProgressBar() {
            progressBar.style.animation = 'none';
            progressBar.offsetHeight; // Trigger reflow
            progressBar.style.animation = '';
            progressBar.style.animationName = 'progressBar';
        }

        function startAutoplay() {
            if (autoplayInterval) clearInterval(autoplayInterval);
            
            autoplayInterval = setInterval(() => {
                moveSlide(1);
            }, 5000);

            // Start progress bar
            resetProgressBar();
        }

        function stopAutoplay() {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
                autoplayInterval = null;
            }
            // Pause progress bar animation
            progressBar.style.animationPlayState = 'paused';
        }

        // Make functions globally available
        window.moveSlide = moveSlide;
        window.goToSlide = goToSlide;

        // Initialize carousel
        updateSlidePosition(false);
        startAutoplay();

        // Enhanced touch handling
        let touchStartX = 0;
        let touchEndX = 0;
        let isDragging = false;
        let startTranslate = 0;
        let currentTranslate = 0;

        const carousel = document.getElementById('carousel');
        
        carousel.addEventListener('mouseenter', () => {
            stopAutoplay();
        });

        carousel.addEventListener('mouseleave', () => {
            startAutoplay();
        });

        carousel.addEventListener('touchstart', e => {
            touchStartX = e.touches[0].clientX;
            isDragging = true;
            startTranslate = currentSlide * -100;
            
            stopAutoplay();
        }, { passive: true });

        carousel.addEventListener('touchmove', e => {
            if (!isDragging) return;
            
            const currentX = e.touches[0].clientX;
            const diff = (currentX - touchStartX) / carousel.offsetWidth * 100;
            currentTranslate = startTranslate - diff;
            
            // Limit dragging to one slide at a time
            if (currentTranslate > (currentSlide + 1) * 100 || currentTranslate < (currentSlide - 1) * 100) return;
            
            carouselContainer.style.transform = `translateX(${-currentTranslate}%)`;
        }, { passive: true });

        carousel.addEventListener('touchend', e => {
            isDragging = false;
            touchEndX = e.changedTouches[0].clientX;
            
            const movePercentage = ((touchStartX - touchEndX) / carousel.offsetWidth) * 100;
            
            if (Math.abs(movePercentage) > 20) { // 20% threshold for slide change
                if (movePercentage > 0) {
                    moveSlide(1);
                } else {
                    moveSlide(-1);
                }
            } else {
                // Reset to current slide if threshold not met
                updateSlidePosition();
            }
            
            startAutoplay();
        });

        // Keyboard navigation
        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowLeft') {
                moveSlide(-1);
            } else if (e.key === 'ArrowRight') {
                moveSlide(1);
            }
        });

        // Cleanup
        window.addEventListener('beforeunload', () => {
            stopAutoplay();
            clearInterval(progressInterval);
        });

        // Visibility change handling
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopAutoplay();
            } else {
                startAutoplay();
            }
        });

        // Toggle Jam Lembur functionality
        const toggleBtn = document.getElementById('toggleJamLembur');
        const dataSection = document.getElementById('dataJamLembur');
        const toggleText = document.getElementById('toggleText');
        const toggleIcon = toggleBtn.querySelector('svg');
        
        if (toggleBtn && dataSection) {
            toggleBtn.addEventListener('click', function() {
                if (dataSection.classList.contains('hidden')) {
                    // Show data
                    dataSection.classList.remove('hidden');
                    toggleText.textContent = 'Sembunyikan Data Bulan Lainnya';
                    toggleIcon.style.transform = 'rotate(180deg)';
                } else {
                    // Hide data
                    dataSection.classList.add('hidden');
                    toggleText.textContent = 'Lihat Data Bulan Lainnya';
                    toggleIcon.style.transform = 'rotate(0deg)';
                }
            });
        }
    });
</script>
@if($sarana->isRoom == 0)
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var selectedDates = new Set();
            var selectedDatesDisplay = document.getElementById('selectedDatesDisplay');
            var submitBtn = document.getElementById('submitBtn');
            var selectedDatesInput = document.getElementById('selectedDates');

            const holidayDates = @json($holidayDates);
            
            // Get date 1 week from now
            var minDate = new Date();
            minDate.setDate(minDate.getDate() + 4);
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                timeZone: 'Asia/Jakarta',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($events).map(event => {
                    // This part can be simplified since the controller now handles holidays
                    if (event.display === 'background') {
                        return event; // Return holiday events as is
                    }

                    const start = new Date(event.start);
                    const end = new Date(event.end);
                    
                    let statusClass;
                    switch(event.status) {
                        case 'disetujui':
                            statusClass = 'status-disetujui';
                            break;
                        case 'diproses':
                        case 'diajukan':
                        case 'diajukanbatal':
                            statusClass = 'status-' + event.status;
                            break;
                        default:
                            statusClass = '';
                    }
                    
                    return {
                        ...event,
                        title: `${start.getHours().toString().padStart(2, '0')}:${start.getMinutes().toString().padStart(2, '0')}-${end.getHours().toString().padStart(2, '0')}:${end.getMinutes().toString().padStart(2, '0')}`,
                        className: statusClass
                    };
                }),
                displayEventTime: false,
                selectable: true,
                selectConstraint: {
                    start: minDate.toISOString().split('T')[0],
                },
                selectAllow: function(selectInfo) {
                    const selectedDateStr = selectInfo.startStr.split('T')[0];
                    // // PREVENT SELECTION IF IT'S A HOLIDAY
                    // if (holidayDates.includes(selectedDateStr)) {
                    //     return false; 
                    // }
                    return selectInfo.start >= minDate;
                },
                dateClick: function(info) {
                    const clickedDate = new Date(info.dateStr);
                    const clickedDateStr = info.dateStr;

                    // // SHOW WARNING IF A HOLIDAY IS CLICKED
                    // if (holidayDates.includes(clickedDateStr)) {
                    //     showWarning('Anda tidak dapat memilih tanggal libur nasional.');
                    //     return;
                    // }

                    if (clickedDate < minDate) {
                        showWarning('Peminjaman harus dilakukan minimal 5 hari sebelum jadwal yang diinginkan');
                        return;
                    }

                    if (selectedDates.has(info.dateStr)) {
                        selectedDates.delete(info.dateStr);
                        info.dayEl.classList.remove('selected-date');
                    } else {
                        selectedDates.add(info.dateStr);
                        info.dayEl.classList.add('selected-date');
                    }
                    updateSelectedDatesDisplay();
                },
                // Add this to apply the disabled class to holiday dates
                dayCellDidMount: function(arg) {
                    const dateStr = arg.date.toISOString().split('T')[0];
                    if (holidayDates.includes(dateStr)) {
                        arg.el.classList.add('fc-holiday');
                    }
                },
                height: 'auto',
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari'
                }
            });
        
            function showWarning(message) {
                const warningMessage = document.createElement('div');
                warningMessage.className = 'warning-popup';
                warningMessage.innerHTML = `
                    <div class="warning-content">
                        <p>${message}</p>
                        <button class="warning-close-btn" onclick="this.closest('.warning-popup').remove()">Tutup</button>
                    </div>
                `;
                document.body.appendChild(warningMessage);
            }
            
            function updateSelectedDatesDisplay() {
                if (selectedDates.size === 0) {
                    selectedDatesDisplay.innerHTML = '<p class="text-gray-500">Belum ada tanggal yang dipilih</p>';
                    submitBtn.disabled = true;
                } else {
                    const datesList = Array.from(selectedDates)
                        .sort()
                        .map(date => {
                            const formattedDate = new Date(date).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            return `
                                <div class="flex items-center justify-between bg-white p-2 rounded mb-2">
                                    <span>${formattedDate}</span>
                                    <button type="button" onclick="removeDate('${date}')" 
                                            class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>`;
                        }).join('');
                    selectedDatesDisplay.innerHTML = datesList;
                    submitBtn.disabled = false;
                }
                selectedDatesInput.value = JSON.stringify(Array.from(selectedDates));
            }
            
            window.removeDate = function(date) {
                selectedDates.delete(date);
                const dateEl = calendar.el.querySelector(`[data-date="${date}"]`);
                if (dateEl) {
                    dateEl.classList.remove('selected-date');
                }
                updateSelectedDatesDisplay();
            };
            
            calendar.render();
        });
    </script>
@endif
@endpush
@endsection