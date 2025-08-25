@extends('layouts.user')

@section('content')
<div class="pt-24 pb-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <!-- Header Section - Centered -->
            <div class="p-8 border-b border-gray-100 text-center">
                <h1 class="text-3xl font-bold text-gray-900">Form Pengajuan Peminjaman</h1>
                <p class="mt-2 text-gray-600">Silakan lengkapi form berikut untuk mengajukan peminjaman fasilitas.</p>
            </div>

            <form id="peminjamanForm" action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idSarana" value="{{ $sarana->id }}">
                <input type="hidden" name="selected_dates" value="{{ $selectedDates }}">

                <div class="p-8 space-y-0">
                    <!-- Informasi Fasilitas - Full Width -->
                    <div class="bg-white p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Informasi Fasilitas
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="border border-gray-200 p-6 rounded-xl hover:border-green-200 transition-all duration-200">
                                <p class="mb-3 flex items-center text-gray-700">
                                    <span class="font-medium w-24">Sarana:</span> 
                                    <span class="text-gray-900">{{ $sarana->nama }}</span>
                                </p>
                                @if(isset($ruangan))
                                    <input type="hidden" name="idRuangan" value="{{ $ruangan->id }}">
                                    <p class="mb-3 flex items-center text-gray-700">
                                        <span class="font-medium w-24">Ruangan:</span>
                                        <span class="text-gray-900">{{ $ruangan->nama }}</span>
                                    </p>
                                    <p class="flex items-center text-gray-700">
                                        <span class="font-medium w-24">Kapasitas:</span>
                                        <span class="text-gray-900">{{ $ruangan->kapasitas }} orang</span>
                                    </p>
                                @endif
                            </div>
                            <div class="border border-gray-200 p-6 rounded-xl hover:border-green-200 transition-all duration-200">
                                <h3 class="font-medium text-gray-900 mb-4">Tanggal Peminjaman:</h3>
                                <div class="space-y-3">
                                    @foreach(json_decode($selectedDates) as $date)
                                        <div class="bg-white px-4 py-3 rounded-lg border border-gray-100 text-gray-700">
                                            {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Garis Pembatas -->
                    <div class="border-t border-gray-200"></div>

                    <!-- Informasi Kegiatan - Full Width -->
                    <div class="bg-white p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Informasi Kegiatan
                            </h2>
                            <div class="space-y-6">
                                <!-- Kegiatan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kegiatan</label>
                                    <input type="text" name="kegiatan"
                                           class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                           placeholder="Masukkan nama kegiatan"
                                           value="{{ old('kegiatan') }}" required>
                                    @error('kegiatan')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Instansi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Instansi</label>
                                    <input type="text" name="instansi"
                                           class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                           placeholder="Masukkan nama instansi"
                                           value="{{ old('instansi') }}" required>
                                    @error('instansi')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estimasi Peserta -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Estimasi Jumlah Peserta
                                        @if(isset($ruangan))
                                            <span class="text-gray-500">(Maks. {{ $ruangan->kapasitas }} orang)</span>
                                        @endif
                                    </label>
                                    <input type="number" name="estimasiPeserta"
                                           class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                           placeholder="Masukkan jumlah peserta"
                                           value="{{ old('estimasiPeserta') }}"
                                           required
                                           @if(isset($ruangan)) max="{{ $ruangan->kapasitas }}" @endif>
                                    @error('estimasiPeserta')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    <!-- Garis Pembatas -->
                    <div class="border-t border-gray-200"></div>

                    <!-- Jadwal per Tanggal - Vertikal -->
                    <div class="bg-white p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Jadwal per Tanggal
                        </h2>
                        <div class="space-y-4">
                            @foreach(json_decode($selectedDates) as $date)
                                <div class="border border-gray-200 p-6 rounded-xl hover:border-green-200 transition-all duration-200">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                                        <div>
                                            <p class="font-medium text-gray-900 mb-2">
                                                {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                Pilih jadwal untuk tanggal ini
                                            </p>
                                        </div>
                                        <div>
                                            <select name="jadwal_dates[{{ $loop->index }}][jadwal_id]"
                                                    class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 py-3"
                                                    required>
                                                <option value="">Pilih Jadwal</option>
                                                @foreach($jadwals as $jadwal)
                                                    @if(!in_array($jadwal->id, $bookedJadwals[$date] ?? []))
                                                        <option value="{{ $jadwal->id }}">
                                                            {{ $jadwal->mulai }} - {{ $jadwal->selesai }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if(count($bookedJadwals[$date] ?? []) == $jadwals->count())
                                                <p class="mt-2 text-red-500 text-sm flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Semua jadwal telah dibooking untuk tanggal ini
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <input type="hidden" name="jadwal_dates[{{ $loop->index }}][date]" value="{{ $date }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Garis Pembatas -->
                    <div class="border-t border-gray-200"></div>

                    <!-- Dokumen Pendukung - 2 Kolom -->
                    <div class="bg-white p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Dokumen Pendukung
                            </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Surat Peminjaman -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Surat Peminjaman</label>
                                    <div class="mt-2">
                                        <div class="relative border-2 border-gray-200 border-dashed rounded-xl p-8 h-48 hover:border-green-200 transition-all duration-200 flex items-center justify-center">
                                            <input type="file" 
                                                   id="suratPeminjaman" 
                                                   name="suratPeminjaman" 
                                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                   required 
                                                   accept=".pdf,.doc,.docx"
                                                   onchange="updateFileInfo(this, 'suratFileInfo')">
                                            <div class="text-center" id="suratFileInfo">
                                                <svg class="mx-auto h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <p class="mt-4 text-base text-gray-600 font-medium">
                                                    Klik untuk upload atau drag and drop
                                                </p>
                                                <p class="mt-2 text-sm text-gray-500">PDF, DOC, DOCX (Maks. 2MB)</p>
                                            </div>
                                            <div id="suratFilePreview" class="hidden mt-3">
                                                <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200">
                                                    <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate" id="suratFileName"></p>
                                                        <p class="text-sm text-gray-500" id="suratFileSize"></p>
                                                        </div>
                                                    <button type="button" onclick="removeFile('suratPeminjaman', 'suratFileInfo', 'suratFilePreview')"
                                                            class="ml-3 text-sm font-medium text-red-500 hover:text-red-600 p-1">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @error('suratPeminjaman')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Rundown -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rundown Acara</label>
                                    <div class="mt-2">
                                        <div class="relative border-2 border-gray-200 border-dashed rounded-xl p-8 h-48 hover:border-green-200 transition-all duration-200 flex items-center justify-center">
                                            <input type="file" 
                                                   id="rundown" 
                                                   name="rundown" 
                                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                   required 
                                                   accept=".pdf,.doc,.docx"
                                                   onchange="updateFileInfo(this, 'rundownFileInfo')">
                                            <div class="text-center" id="rundownFileInfo">
                                                <svg class="mx-auto h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <p class="mt-4 text-base text-gray-600 font-medium">
                                                    Klik untuk upload atau drag and drop
                                                </p>
                                                <p class="mt-2 text-sm text-gray-500">PDF, DOC, DOCX (Maks. 2MB)</p>
                                            </div>
                                            <div id="rundownFilePreview" class="hidden mt-3">
                                                <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200">
                                                    <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate" id="rundownFileName"></p>
                                                        <p class="text-sm text-gray-500" id="rundownFileSize"></p>
                                                    </div>
                                                    <button type="button" onclick="removeFile('rundown', 'rundownFileInfo', 'rundownFilePreview')"
                                                            class="ml-3 text-sm font-medium text-red-500 hover:text-red-600 p-1">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @error('rundown')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Garis Pembatas -->
                    <div class="border-t border-gray-200"></div>

                    <!-- Informasi Tarif & Jam Lembur - Clean Layout -->
                    <div class="bg-white p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Tarif & Jam Lembur
                        </h2>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Kolom Kiri: Informasi Tarif -->
                            <div>
                                <h3 class="font-medium text-gray-900 mb-4">Informasi Tarif</h3>
                                
                                <!-- Status Peminjam -->
                                <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status Peminjam</label>
                                @if(auth()->user()->isFakultas)
                                    <input type="hidden" name="statusPeminjam" value="unit">
                                        <div class="border border-gray-200 rounded-lg px-4 py-3 text-gray-700 bg-white">
                                        <span class="font-medium">Fakultas/Unit</span>
                                    </div>
                                        <p class="mt-1 text-xs text-green-600">Status otomatis: Fakultas/Unit</p>
                                @else
                                    <select name="statusPeminjam" id="statusPeminjam" 
                                                class="w-full rounded-lg border-gray-200 focus:border-green-500 focus:ring-green-500 py-3"
                                            required>
                                        <option value="" disabled selected hidden>Pilih Status</option>
                                        <option value="ormawa">Ormawa</option>
                                        <option value="umum">Umum</option>
                                    </select>
                                @endif
                            </div>

                            <!-- Tariff Information -->
                                <div class="mb-6">
                                    <h4 class="font-medium text-gray-900 mb-3">Daftar Tarif:</h4>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center p-3 border border-gray-200 rounded-lg bg-white">
                                            <span class="text-gray-700">Fakultas/Unit:</span>
                                            <span class="font-medium">Rp{{ number_format(isset($ruangan) ? $ruangan->tarifunit : $sarana->tarifunit, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between items-center p-3 border border-gray-200 rounded-lg bg-white">
                                            <span class="text-gray-700">Ormawa:</span>
                                            <span class="font-medium">Rp{{ number_format(isset($ruangan) ? $ruangan->tariformawa : $sarana->tariformawa, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between items-center p-3 border border-gray-200 rounded-lg bg-white">
                                            <span class="text-gray-700">Umum:</span>
                                            <span class="font-medium">Rp{{ number_format(isset($ruangan) ? $ruangan->tarifumum : $sarana->tarifumum, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Catatan Tarif -->
                                <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                    <p class="text-sm text-yellow-800 font-medium mb-2">Catatan:</p>
                                    <ul class="text-sm text-yellow-700 space-y-1">
                                        <li>• Sabtu/Minggu atau setelah 16:00</li>
                                        <li>• Tanggal merah (hari libur nasional)</li>
                                        <li>• Status Umum selalu dikenakan tarif</li>
                                        @if(isset($ruangan) ? $ruangan->is_hourly_rate : $sarana->is_hourly_rate)
                                        <li>• Per {{ isset($ruangan) ? $ruangan->hours_per_unit : $sarana->hours_per_unit }} jam</li>
                                        @endif
                                    </ul>
                                </div>

                                <!-- Estimated Total -->
                                <div id="estimatedTotal" class="hidden mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
                                    <p class="text-sm font-medium text-green-800">
                                        Estimasi Total: <span id="totalTarif" class="text-lg font-bold">Rp0</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Informasi Jam Lembur -->
                            <div>
                                <h3 class="font-medium text-gray-900 mb-4">
                                    Jam Lembur {{ isset($ruangan) ? $ruangan->sarana->nama : $sarana->nama }}
                                </h3>
                                
                                @foreach($jamLemburPerBulan as $monthKey => $monthData)
                                    <div class="mb-4 {{ !$loop->last ? 'border-b border-gray-200 pb-4' : '' }}">
                                        <p class="text-sm text-gray-600 mb-3 font-medium">{{ $monthData['month_name'] }}</p>
                                        
                                    @php
                                            $jamTerpakai = $monthData['hours'];
                                            $totalJamPerBulan = 40;
                                            $sisaJam = max(0, $totalJamPerBulan - $jamTerpakai);
                                            $persen = max(0, min(100, ($jamTerpakai / $totalJamPerBulan) * 100));
                                    @endphp
                                        
                                        <!-- Info Jam Lembur dalam satu row -->
                                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg bg-white mb-3">
                                            <div class="flex items-center space-x-4">
                                                <span class="text-sm text-gray-700">Terpakai: <span class="font-medium">{{ $jamTerpakai }} jam</span></span>
                                                <span class="text-sm text-gray-700">Sisa: <span class="font-medium">{{ $sisaJam }} jam</span></span>
                                                <span class="text-sm text-gray-700">Limit: <span class="font-medium">{{ $totalJamPerBulan }} jam</span></span>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ number_format($persen, 1) }}%</span>
                                        </div>
                                        
                                        <!-- Progress Bar -->
                                        <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $persen }}%"></div>
                                        </div>
                                        
                                        @if($sisaJam <= 5)
                                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg mb-3">
                                                <p class="text-sm text-red-700 font-medium flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                                    </svg>
                                                    Peringatan: Sisa jam lembur hampir habis!
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="text-sm text-blue-700">
                                        <i>Jam lembur dihitung untuk peminjaman di hari Sabtu/Minggu, tanggal merah, atau setelah pukul 16:00</i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <button type="button" onclick="confirmCancel()"
                                class="px-6 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </span>
                        </button>
                        <button type="submit"
                                class="px-6 py-3 bg-green-500 text-white rounded-xl text-sm font-medium hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Ajukan Peminjaman
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function updateFileInfo(input, infoId) {
    const file = input.files[0];
    const fileInfo = document.getElementById(infoId);
    const filePreview = document.getElementById(infoId.replace('FileInfo', 'FilePreview'));
    const fileName = document.getElementById(infoId.replace('FileInfo', 'FileName'));
    const fileSize = document.getElementById(infoId.replace('FileInfo', 'FileSize'));

    if (file) {
        const size = (file.size / 1024).toFixed(2);
        const formattedSize = size > 1024 ? (size / 1024).toFixed(2) + ' MB' : size + ' KB';

        fileInfo.classList.add('hidden');
        filePreview.classList.remove('hidden');
        fileName.textContent = file.name;
        fileSize.textContent = formattedSize;
    } else {
        resetFileInput(input.id, infoId, filePreview.id);
    }
}

function removeFile(inputId, infoId, previewId) {
    resetFileInput(inputId, infoId, previewId);
}

function resetFileInput(inputId, infoId, previewId) {
    document.getElementById(inputId).value = '';
    document.getElementById(infoId).classList.remove('hidden');
    document.getElementById(previewId).classList.add('hidden');
}

document.getElementById('peminjamanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Konfirmasi Pengajuan',
        text: "Apakah Anda yakin ingin mengajukan peminjaman ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Ajukan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm(this);
        }
    });
});

function submitForm(form) {
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner">Mengirim...</span>';

    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = data.redirect;
            });
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: error.message,
            timer: 2000,
            showConfirmButton: false
        });
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = 'Ajukan Peminjaman';
    });
}

function confirmCancel() {
    Swal.fire({
        title: 'Konfirmasi Pembatalan',
        text: "Apakah Anda yakin ingin membatalkan pengajuan ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Batalkan!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            history.back();
        }
    });
}

@if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        html: '{!! implode("<br>", $errors->all()) !!}',
        confirmButtonColor: '#DC2626'
    });
@endif
</script>
<script>
    function calculateEstimatedTarif() {
        @if(auth()->user()->isFakultas)
        const statusPeminjam = 'unit';
        @else
        const statusPeminjam = document.getElementById('statusPeminjam').value;
        @endif
    
        const jadwalSelects = document.querySelectorAll('select[name^="jadwal_dates"][name$="[jadwal_id]"]');
        const dates = Array.from(document.querySelectorAll('input[name^="jadwal_dates"][name$="[date]"]')).map(input => input.value);
        
        const tarif = statusPeminjam === 'unit' ? 
            {{ isset($ruangan) ? $ruangan->tarifunit : $sarana->tarifunit }} :
            statusPeminjam === 'ormawa' ? 
            {{ isset($ruangan) ? $ruangan->tariformawa : $sarana->tariformawa }} :
            {{ isset($ruangan) ? $ruangan->tarifumum : $sarana->tarifumum }};
    
        const isHourlyRate = {{ isset($ruangan) ? ($ruangan->is_hourly_rate ? 'true' : 'false') : ($sarana->is_hourly_rate ? 'true' : 'false') }};
        const hoursPerUnit = {{ isset($ruangan) ? ($ruangan->hours_per_unit ?? 0) : ($sarana->hours_per_unit ?? 0) }};
    
        const isLapangan = "{{ isset($ruangan) ? strtolower($ruangan->sarana->kategoriSarana->jenis) : strtolower($sarana->kategoriSarana->jenis) }}" === "lapangan";

        if (!statusPeminjam && !isLapangan) return;

        let totalTarif = 0;
    
        // Ambil data tanggal merah dari server
        const holidayDates = @json($holidayDates ?? []);
        
        dates.forEach((date, index) => {
            const jadwalId = jadwalSelects[index].value;
            if (!jadwalId) return;
    
            const dayOfWeek = new Date(date).getDay();
            const isWeekend = dayOfWeek === 0 || dayOfWeek === 6;
            const isHoliday = holidayDates.includes(date);
            const isWeekendOrHoliday = isWeekend || isHoliday;
    
            const selectedOption = jadwalSelects[index].options[jadwalSelects[index].selectedIndex];
            const timeText = selectedOption.text;
            const timeRange = timeText.split(' - ');
            const startTime = timeRange[0];
            const endTime = timeRange[1];
            
            const startHour = parseInt(startTime.split(':')[0]);
            const startMinute = parseInt(startTime.split(':')[1]) || 0;
            const endHour = parseInt(endTime.split(':')[0]);
            const endMinute = parseInt(endTime.split(':')[1]) || 0;
            
            const isAfterHours = startHour > 16 || (startHour === 16 && startMinute > 0) || endHour > 16 || (endHour === 16 && endMinute > 0);
    
            if (isLapangan || isWeekendOrHoliday || isAfterHours || statusPeminjam === 'umum') {
                if (isHourlyRate && hoursPerUnit > 0) {
                    const startMinutes = parseInt(startTime.split(':')[1]) || 0;
                    const endMinutes = parseInt(endTime.split(':')[1]) || 0;
                    
                    const startTimeInMinutes = startHour * 60 + startMinutes;
                    const endTimeInMinutes = endHour * 60 + endMinutes;
                    
                    const durationHours = Math.ceil((endTimeInMinutes - startTimeInMinutes) / 60);
                    
                    const multiplier = Math.max(1, Math.ceil(durationHours / hoursPerUnit));
                    
                    totalTarif += tarif * multiplier;
                } else {
                    totalTarif += tarif;
                }
            }
        });
    
        document.getElementById('estimatedTotal').classList.remove('hidden');
        document.getElementById('totalTarif').textContent = `Rp${totalTarif.toLocaleString('id-ID')}`;
    }
    
    document.getElementById('statusPeminjam').addEventListener('change', calculateEstimatedTarif);
    document.querySelectorAll('select[name^="jadwal_dates"][name$="[jadwal_id]"]').forEach(select => {
        select.addEventListener('change', calculateEstimatedTarif);
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        calculateEstimatedTarif();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Validasi ukuran file maksimal 2MB pada input file (onchange)
function validateFileSize(input) {
    if (input.files && input.files[0]) {
        if (input.files[0].size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran file terlalu besar',
                text: 'Ukuran file maksimal 2MB!',
                confirmButtonColor: '#059669'
            });
            input.value = '';
            return false;
        }
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    var suratInput = document.getElementById('suratPeminjaman');
    if (suratInput) {
        suratInput.addEventListener('change', function() {
            validateFileSize(this);
        });
    }
    var rundownInput = document.getElementById('rundown');
    if (rundownInput) {
        rundownInput.addEventListener('change', function() {
            validateFileSize(this);
        });
    }

    // Validasi ukuran file pada submit form
    var form = document.getElementById('peminjamanForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            var surat = document.getElementById('suratPeminjaman');
            var rundown = document.getElementById('rundown');
            if ((surat.files[0] && surat.files[0].size > 2 * 1024 * 1024) ||
                (rundown.files[0] && rundown.files[0].size > 2 * 1024 * 1024)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran file terlalu besar',
                    text: 'Ukuran file maksimal 2MB!',
                    confirmButtonColor: '#059669'
                });
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>
@endpush
@endsection 
