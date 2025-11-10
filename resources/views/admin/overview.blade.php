@extends('layouts.main')
@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .fc {
        height: 100%;
        background-color: white;
        border-radius: 0.5rem;
    }

    .fc-header-toolbar {
        padding: 1rem;
    }

    .fc-event {
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .fc-event:hover {
        transform: scale(1.02);
    }

    #calendar-container {
        height: 750px !important;
        margin-bottom: 2rem;
    }

    .calendar-wrapper {
        background-color: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-right: 1.5rem;
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s ease;
    }

    .legend-item:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .legend-color {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 0.375rem;
        margin-right: 0.75rem;
    }

    .filter-container select {
        transition: all 0.2s ease;
    }

    .filter-container select:hover {
        border-color: #3b82f6;
    }

    .modal-content {
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-content.show {
        transform: scale(1);
        opacity: 1;
    }

    .booked-date {
        background: #fbbf24 !important;
        color: #fff !important;
        border-radius: 50%;
    }
</style>
@endsection
@section('content')
<div class="p-4 sm:p-6">
    <h5 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Kalender Peminjaman</h5>
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <div class="flex flex-wrap gap-4">
                    <div class="legend-item">
                        <div class="legend-color bg-blue-500"></div>
                        <span class="text-sm font-medium">Diajukan</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color bg-yellow-300"></div>
                        <span class="text-sm font-medium">Diproses</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color bg-emerald-600"></div>
                        <span class="text-sm font-medium">Disetujui</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color bg-red-600"></div>
                        <span class="text-sm font-medium">Ditolak</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color bg-gray-600"></div>
                        <span class="text-sm font-medium">Dibatalkan</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color bg-purple-600"></div>
                        <span class="text-sm font-medium">Diajukan Batal</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color bg-[#D4A373]"></div>
                        <span class="text-sm font-medium">Selesai</span>
                    </div>
                </div>
                <div class="filter-container flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <select id="saranaFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 w-full sm:w-48">
                        <option value="">Semua Sarana</option>
                        @foreach($saranas as $sarana)
                        <option value="{{ $sarana->id }}">{{ $sarana->nama }}</option>
                        @endforeach
                    </select>
                    <select id="statusFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 w-full sm:w-48">
                        <option value="">Semua Status</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="diproses">Diproses</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="diajukan">Diajukan</option>
                        <option value="dibatalkan">Dibatalkan</option>
                        <option value="diajukanbatal">Diajukan Batal</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    @canany(['is-superadmin', 'is-pimpinan'])
    <div class="flex justify-end mb-4 mt-4">
        <button data-modal-toggle="bookingModal" data-modal-target="bookingModal"
            type="button" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Peminjaman
        </button>
    </div>
    @endcanany
    <div class="calendar-wrapper">
        <div id="calendar-container"></div>
    </div>
    <div id="bookingModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden flex items-center justify-center" data-modal-backdrop="static">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" data-modal-hide="bookingModal"></div>
        <div class="relative w-full max-w-lg max-h-full mt-0">
            <div class="relative bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">
                        Tambah Peminjaman Baru
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" data-modal-hide="bookingModal">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4">
                    <form id="adminBookingForm" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        <!-- Sarana -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sarana</label>
                            <select id="bookingSarana" name="idSarana" onchange="checkSaranaType()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih Sarana</option>
                                @foreach($saranas as $sarana)
                                <option value="{{ $sarana->id }}"
                                    data-kategori="{{ $sarana->isRoom }}"
                                    data-ruangan='@json($sarana->ruangan)'>
                                    {{ $sarana->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ruangan -->
                        <div id="ruanganSection" class="hidden">
                            <label class="block text-sm font-medium text-gray-700">Ruangan</label>
                            <select id="ruanganSelect" name="idRuangan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih Ruangan</option>
                            </select>
                        </div>

                        <!-- Kegiatan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kegiatan</label>
                            <input type="text" name="kegiatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <!-- Tanggal dan Jadwal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal dan Jadwal</label>
                            <div id="dateContainer" class="space-y-4">
                                <!-- Date entries will be added here dynamically -->
                            </div>
                            <button type="button" onclick="addDateEntry()" class="mt-2 px-4 py-2 text-sm font-medium text-green-600 hover:text-green-700">
                                + Tambah Tanggal
                            </button>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tarif (Opsional)</label>
                            <input type="number" name="totalTarif" inputmode="numeric" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Bukti Pembayaran (Opsional) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bukti Pembayaran (Opsional)</label>
                            <input type="file"
                                name="buktiPembayaran"
                                id="buktiPembayaran"
                                accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-md focus:border-green-500 focus:ring-green-500">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG (Max. 2MB)</p>
                            <div id="buktiPreview" class="mt-2 hidden">
                                <img id="buktiPreviewImg" src="" alt="Preview" class="max-w-xs rounded-lg border border-gray-300">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="flex justify-end px-4 py-3 bg-gray-50 rounded-b-lg">
                    <button type="button" data-modal-hide="bookingModal" class="mr-3 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                        Batal
                    </button>
                    <button onclick="submitBooking()" class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded hover:bg-green-700">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="eventModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-[60] hidden overflow-y-auto overflow-x-hidden flex items-center justify-center" data-modal-backdrop="static">
        <!-- Backdrop with higher z-index -->
        <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity" data-modal-hide="eventModal"></div>
        <div class="relative w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="modal-content relative bg-white rounded-lg shadow-lg">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">
                        Detail Peminjaman
                    </h3>
                    <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4">
                    <div class="space-y-4">
                        <!-- Status -->
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Status</span>
                            <div id="modalStatus"></div>
                        </div>
                        <!-- Kegiatan -->
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Nama Kegiatan</span>
                            <div id="modalKegiatan" class="text-sm text-gray-900 text-right"></div>
                        </div>
                        <!-- Peminjam -->
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Peminjam</span>
                            <div id="modalPeminjam" class="text-sm text-gray-900"></div>
                        </div>
                        <!-- Instansi -->
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Instansi</span>
                            <div id="modalInstansi" class="text-sm text-gray-900"></div>
                        </div>
                        <!-- Tanggal -->
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Tanggal</span>
                            <div id="modalTanggal" class="text-sm text-gray-900"></div>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Jadwal</span>
                            <div id="modalJadwal" class="text-sm text-gray-900"></div>
                        </div>
                        <!-- Sarana -->
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Sarana</span>
                            <div id="modalSarana" class="text-sm text-gray-900"></div>
                        </div>
                        <!-- Ruangan -->
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Ruangan</span>
                            <div id="modalRuangan" class="text-sm text-gray-900"></div>
                        </div>
                        <!-- Estimasi -->
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Estimasi Peserta</span>
                            <div id="modalPeserta" class="text-sm text-gray-900"></div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex justify-between px-4 py-3 bg-gray-50 rounded-b-lg">
                    <button id="kelolaPeminjamanBtn" onclick="navigateToPeminjamanDetail()" type="button" class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded hover:bg-green-700 hidden">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Kelola Peminjaman
                    </button>
                    <button onclick="closeModal()" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/id.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Data dari server (hanya untuk bulan saat ini)
    let bookedJadwals = @json($booked);
    const eventsData = @json($events);
    const jadwalsData = @json($jadwals);

    // Global variable untuk menyimpan data event yang sedang dipilih
    let currentEventData = null;
    let allEventsCache = []; // Cache untuk filter
    let currentSaranaFilter = '';
    let currentStatusFilter = '';
    let calendar = null; // Global calendar instance

    // Function untuk apply filter ke events (didefinisikan sebelum digunakan)
    const applyFiltersToEvents = (events) => {
        return events.filter(event => {
            const matchesSarana = currentSaranaFilter ? event.saranaId === parseInt(currentSaranaFilter) : true;
            const matchesStatus = currentStatusFilter ? event.status === currentStatusFilter : true;
            return matchesSarana && matchesStatus;
        });
    };

    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar-container');
        const modal = document.getElementById('eventModal');
        const modalContent = modal.querySelector('.modal-content');
        let currentView = 'all';

        // Initialize FullCalendar dengan event source dinamis
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            // Menggunakan function untuk lazy loading events
            events: function(info, successCallback, failureCallback) {
                // Tampilkan loading state
                calendarEl.style.opacity = '0.5';

                // Fetch events dari API berdasarkan rentang tanggal
                fetch(`/admin/overview/events?start=${info.startStr}&end=${info.endStr}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Pastikan data adalah array
                        if (!Array.isArray(data)) {
                            console.warn('Response is not an array, using empty array');
                            data = [];
                        }

                        // Update cache
                        allEventsCache = data;

                        // Apply filter jika ada
                        const filteredEvents = applyFiltersToEvents(data);

                        // Format events untuk FullCalendar
                        const formattedEvents = filteredEvents.map(event => ({
                            ...event,
                            title: currentSaranaFilter ? event.kegiatan : event.saranaName,
                            className: `status-${event.status}`
                        }));

                        // Sembunyikan loading state
                        calendarEl.style.opacity = '1';

                        successCallback(formattedEvents);
                    })
                    .catch(error => {
                        console.error('Error fetching events:', error);
                        calendarEl.style.opacity = '1';
                        // Return empty array instead of calling failureCallback
                        successCallback([]);
                    });
            },
            // Update booked dates saat view berubah
            datesSet: function(info) {
                // Fetch booked dates untuk rentang tanggal yang ditampilkan
                fetch(`/admin/overview/booked-dates?start=${info.startStr}&end=${info.endStr}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        bookedJadwals = data;
                    })
                    .catch(error => {
                        console.error('Error fetching booked dates:', error);
                    });
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            eventDidMount: function(info) {
                // Add tooltip
                const tooltip = document.createElement('div');
                tooltip.classList.add('bg-gray-900', 'text-white', 'p-2', 'rounded', 'shadow-lg', 'text-sm');
                tooltip.innerHTML = `
                   <div class="font-semibold">${info.event.extendedProps.kegiatan}</div>
                   <div>${info.event.extendedProps.status}</div>
               `;

                info.el.addEventListener('mouseover', function() {
                    document.body.appendChild(tooltip);
                    const rect = info.el.getBoundingClientRect();
                    tooltip.style.position = 'fixed';
                    tooltip.style.top = `${rect.bottom + 5}px`;
                    tooltip.style.left = `${rect.left}px`;
                    tooltip.style.zIndex = 1000;
                });

                info.el.addEventListener('mouseout', function() {
                    if (document.body.contains(tooltip)) {
                        document.body.removeChild(tooltip);
                    }
                });
            },
            eventClick: function(info) {
                // Store current event data for navigation
                currentEventData = {
                    peminjamanId: info.event.extendedProps.peminjamanId || null,
                    status: info.event.extendedProps.status,
                    kegiatan: info.event.extendedProps.kegiatan
                };

                console.log('Event clicked, currentEventData set to:', currentEventData);
                console.log('Event extendedProps:', info.event.extendedProps);

                // Validate required data
                if (!currentEventData.status) {
                    console.error('No status found in event data');
                    Swal.fire({
                        title: 'Error',
                        text: 'Data status tidak tersedia untuk acara ini.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                    return;
                }

                // Set status with appropriate styling
                const statusEl = document.getElementById('modalStatus');
                const statusMap = {
                    'disetujui': ['bg-green-100 text-green-800'],
                    'diproses': ['bg-yellow-100 text-yellow-800'],
                    'ditolak': ['bg-red-100 text-red-800'],
                    'diajukan': ['bg-blue-100 text-blue-800'],
                    'dibatalkan': ['bg-gray-100 text-gray-800'],
                    'diajukanbatal': ['bg-purple-100 text-purple-800'],
                    'selesai': ['bg-orange-100 text-orange-800']
                };
                const [statusClass] = statusMap[info.event.extendedProps.status] || ['bg-gray-100 text-gray-800', ''];

                statusEl.innerHTML = `
                   <span class="px-3 py-1.5 text-sm font-medium rounded-full inline-flex items-center gap-2 ${statusClass}">
                        ${info.event.extendedProps.status}
                   </span>
               `;

                // Update all modal fields
                document.getElementById('modalPeminjam').textContent = info.event.extendedProps.peminjam;
                document.getElementById('modalInstansi').textContent = info.event.extendedProps.instansi || '-';
                document.getElementById('modalKegiatan').textContent = info.event.extendedProps.kegiatan || '-';
                document.getElementById('modalSarana').textContent = info.event.extendedProps.sarana;
                document.getElementById('modalRuangan').textContent = info.event.extendedProps.ruangan || '-';
                document.getElementById('modalPeserta').textContent =
                    info.event.extendedProps.estimasiPeserta ?
                    `${info.event.extendedProps.estimasiPeserta} orang` : '-';
                document.getElementById('modalTanggal').textContent = info.event.start.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                document.getElementById('modalJadwal').textContent = info.event.extendedProps.jadwal || '-';

                // Show/hide Kelola Peminjaman button based on status
                const kelolaBtn = document.getElementById('kelolaPeminjamanBtn');
                const validStatuses = ['diajukan', 'diproses', 'disetujui', 'ditolak', 'dibatalkan', 'diajukanbatal', 'selesai'];

                if (validStatuses.includes(currentEventData.status)) {
                    kelolaBtn.classList.remove('hidden');
                } else {
                    kelolaBtn.classList.add('hidden');
                }

                // Show modal with animation
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modalContent.classList.add('show');
                }, 10);
            }
        });

        calendar.render();

        // Filter functionality with enhanced animation
        const applyFilters = () => {
            currentSaranaFilter = document.getElementById('saranaFilter').value;
            currentStatusFilter = document.getElementById('statusFilter').value;

            // Add loading state to calendar
            calendarEl.style.opacity = '0.5';
            calendarEl.style.transition = 'opacity 0.3s ease';

            // Refetch events dengan filter
            calendar.refetchEvents();

            // Remove loading state
            setTimeout(() => {
                calendarEl.style.opacity = '1';
            }, 300);
        };

        // Enhanced close modal function with animation
        window.closeModal = function() {
            modalContent.classList.remove('show');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        };

        // Add event listeners to filters with debounce
        let filterTimeout;
        const filters = ['saranaFilter', 'statusFilter'];
        filters.forEach(filter => {
            document.getElementById(filter).addEventListener('change', () => {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(applyFilters, 300);
            });
        });

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Add keyboard support for modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // currentEventData sudah dideklarasikan di global scope

        // Add custom CSS for event colors
        const styleSheet = document.createElement('style');
        styleSheet.textContent = `
        .status-dibatalkan { 
                background-color: #6b7280 !important;
                border-color: #4b5563 !important;
            }
            .status-diajukanbatal { 
                background-color: #8b5cf6 !important;
                border-color: #7c3aed !important;
            }
            .status-disetujui { 
                background-color: #059669 !important;
                border-color: #047857 !important;
            }
            .status-diproses { 
                background-color: #facc15 !important; /* kuning */
                border-color: #eab308 !important; /* kuning yang lebih gelap untuk border */
            }
            .status-ditolak { 
                background-color: #dc2626 !important;
                border-color: #b91c1c !important;
            }
            .status-diajukan { 
                background-color: #3b82f6 !important;
                border-color: #2563eb !important;
            }
            .fc .fc-button {
                background-color: #ffffff;
                border: 1px solid #e5e7eb;
                color: #374151;
            }
            .fc .fc-button:hover {
                background-color: #f9fafb;
                border-color: #d1d5db;
            }
            .fc .fc-button-primary:not(:disabled).fc-button-active,
            .fc .fc-button-primary:not(:disabled):active {
                background-color: #059669 !important;
                border-color: #047857 !important;
                color: #ffffff;
            }
            .fc .fc-button-primary:disabled {
                background-color: #f3f4f6;
                border-color: #e5e7eb;
                color: #9ca3af;
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
       `;
        document.head.appendChild(styleSheet);
    });
    // Function untuk mengecek tipe sarana dan menampilkan ruangan
    window.jadwals = jadwalsData;

    // Function untuk mengecek tipe sarana dan menampilkan ruangan
    function checkSaranaType() {
        const saranaSelect = document.getElementById('bookingSarana');
        const ruanganSection = document.getElementById('ruanganSection');
        const ruanganSelect = document.getElementById('ruanganSelect');
        const selectedOption = saranaSelect.selectedOptions[0];

        saranaSelect.classList.remove('bg-green-100', 'bg-gray-100');

        if (!selectedOption.value) {
            ruanganSection.classList.add('hidden');
            return;
        }

        const beruangan = selectedOption.getAttribute('data-kategori');

        if (beruangan === '1') {
            ruanganSection.classList.remove('hidden');
            ruanganSelect.innerHTML = '<option value="">Pilih Ruangan</option>';
            const ruangans = JSON.parse(selectedOption.getAttribute('data-ruangan'));

            ruangans.forEach(ruangan => {
                const option = document.createElement('option');
                option.value = ruangan.id;
                option.textContent = ruangan.nama;
                ruanganSelect.appendChild(option);
            });
            saranaSelect.classList.add('bg-green-100');
        } else {
            ruanganSection.classList.add('hidden');
            ruanganSelect.value = '';
            saranaSelect.classList.add('bg-green-100');
        }
    }

    const bookedDates = bookedJadwals.map(b => b.tanggal);

    function timeToMinutes(time) {
        const [h, m] = time.split(':').map(Number);
        return h * 60 + m;
    }

    function isOverlap(startA, endA, startB, endB) {
        return startA < endB && startB < endA;
    }

    function getAvailableJadwals(selectedDate, saranaId, ruanganId) {
        const booked = bookedJadwals || [];
        return jadwalsData.map(jadwal => {
            // Cek hanya jika jadwal_id sama pada tanggal & sarana/ruangan yang sama
            const isBooked = booked.some(b =>
                b.tanggal === selectedDate &&
                b.jadwal_id == jadwal.id &&
                (b.sarana_id == saranaId || (ruanganId && b.ruangan_id == ruanganId))
            );
            return {
                ...jadwal,
                disabled: isBooked // hanya untuk label, option tetap bisa dipilih
            };
        });
    }

    function getFilteredBookedDates(saranaId, ruanganId) {
        return (bookedJadwals || [])
            .filter(b => {
                // Jika ada ruanganId, filter berdasarkan ruangan_id
                if (ruanganId) {
                    return b.ruangan_id == ruanganId;
                }
                // Jika tidak ada ruanganId, filter berdasarkan sarana_id
                return b.sarana_id == saranaId;
            })
            .map(b => b.tanggal); // Ambil hanya tanggalnya
    }

    // Function untuk menambah entry tanggal dan jadwal
    // Ganti fungsi addDateEntry Anda dengan yang ini

    let dateCounter = 0;

    function addDateEntry() {
        const container = document.getElementById('dateContainer');
        const dateId = dateCounter++;
        const saranaId = document.getElementById('bookingSarana').value;
        const ruanganId = document.getElementById('ruanganSelect') ? document.getElementById('ruanganSelect').value : null;

        if (!saranaId) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Silakan pilih sarana terlebih dahulu.',
                confirmButtonColor: '#059669'
            });
            return;
        }

        const dateEntry = document.createElement('div');
        dateEntry.className = 'flex items-center gap-4 p-4 bg-gray-50 rounded-lg relative';
        dateEntry.id = `date_entry_${dateId}`;

        dateEntry.innerHTML = `
        <div class="flex-1">
            <input type="text" 
                   name="jadwal_dates[${dateId}][date]" 
                   class="datepicker block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   placeholder="Pilih Tanggal..."
                   required>
        </div>
        <div class="flex-1">
            <select name="jadwal_dates[${dateId}][jadwal_id]"
                    id="jadwalSelect_${dateId}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                <option value="">Pilih Jadwal</option>
                ${jadwalsData.map(jadwal => 
                    `<option value="${jadwal.id}">${jadwal.mulai} - ${jadwal.selesai}</option>`
                ).join('')}
            </select>
        </div>
        <button type="button" 
                onclick="removeDateEntry(${dateId})"
                class="text-red-600 hover:text-red-800 p-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
        container.appendChild(dateEntry);

        const filteredBookedDates = getFilteredBookedDates(saranaId, ruanganId);

        flatpickr(dateEntry.querySelector('.datepicker'), {
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                updateJadwalOptions(dateId, dateStr);
            },
            onDayCreate: function(dObj, dStr, fp, dayElem) {

                const year = dayElem.dateObj.getFullYear();
                const month = String(dayElem.dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dayElem.dateObj.getDate()).padStart(2, '0');
                const localDateString = `${year}-${month}-${day}`;

                if (filteredBookedDates.includes(localDateString)) {
                    dayElem.classList.add('booked-date');
                }
            }
        });
    }

    function updateJadwalOptions(dateId, selectedDate) {
        const jadwalSelect = document.getElementById(`jadwalSelect_${dateId}`);
        const saranaId = document.getElementById('bookingSarana').value;
        const ruanganId = document.getElementById('ruanganSelect').value;

        // Pastikan sarana sudah dipilih
        if (!saranaId) {
            jadwalSelect.innerHTML = '<option value="">Pilih Sarana terlebih dahulu</option>';
            return;
        }

        // Dapatkan jadwal yang tersedia menggunakan fungsi yang sudah ada
        const availableJadwals = getAvailableJadwals(selectedDate, saranaId, ruanganId);

        // Perbarui opsi pada elemen <select>
        let optionsHTML = '<option value="">Pilih Jadwal</option>';
        availableJadwals.forEach(jadwal => {
            // Selalu bisa dipilih, tapi beri label (Terisi) jika jadwal.disabled true
            const label = `${jadwal.mulai} - ${jadwal.selesai}${jadwal.disabled ? ' (Terisi)' : ''}`;
            optionsHTML += `<option value="${jadwal.id}">${label}</option>`;
        });
        jadwalSelect.innerHTML = optionsHTML;
    }

    document.getElementById('bookingSarana').addEventListener('change', function() {
        // Kosongkan container tanggal setiap kali sarana utama berubah
        document.getElementById('dateContainer').innerHTML = '';
    });

    document.getElementById('ruanganSelect').addEventListener('change', function() {
        // Kosongkan juga container tanggal jika ruangan berubah
        document.getElementById('dateContainer').innerHTML = '';
    });

    // Preview bukti pembayaran
    document.getElementById('buktiPembayaran').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('buktiPreview');
        const previewImg = document.getElementById('buktiPreviewImg');

        if (file) {
            // Validasi ukuran file (max 2MB)
            if (file.size > 2048 * 1024) {
                Swal.fire({
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal 2MB',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
                e.target.value = '';
                preview.classList.add('hidden');
                return;
            }

            // Validasi tipe file
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                Swal.fire({
                    title: 'Format File Tidak Valid',
                    text: 'Hanya file JPG, JPEG, atau PNG yang diperbolehkan',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
                e.target.value = '';
                preview.classList.add('hidden');
                return;
            }

            // Tampilkan preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
        }
    });

    // Function untuk menghapus entry tanggal
    function removeDateEntry(dateId) {
        const entry = document.getElementById(`date_entry_${dateId}`);
        if (entry) {
            entry.remove();
        }
    }

    // Function untuk submit booking
    async function submitBooking() {
        try {
            // Show confirmation dialog first
            const confirmResult = await Swal.fire({
                title: 'Konfirmasi Peminjaman',
                text: 'Apakah anda yakin ingin menambah peminjaman ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tambahkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#059669',
                cancelButtonColor: '#d33',
            });

            // If user confirms
            if (confirmResult.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const form = document.getElementById('adminBookingForm');
                const formData = new FormData(form);

                const response = await fetch('/admin/peminjaman', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                // Cek apakah response adalah JSON
                const contentType = response.headers.get('content-type');
                let result;

                if (contentType && contentType.includes('application/json')) {
                    result = await response.json();
                } else {
                    // Jika bukan JSON, berarti ada error validasi atau server error
                    const text = await response.text();
                    console.error('Non-JSON response:', text);

                    let errorMessage = 'Terjadi kesalahan saat memproses data';

                    // Coba extract error dari HTML jika ada
                    if (response.status === 422) {
                        errorMessage = 'Data yang diinput tidak valid. Pastikan semua field diisi dengan benar.';
                    } else if (response.status === 500) {
                        errorMessage = 'Terjadi kesalahan server. Silakan coba lagi.';
                    }

                    await Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                    return;
                }

                if (result.success) {
                    await Swal.fire({
                        title: 'Berhasil!',
                        text: result.message || 'Peminjaman berhasil ditambahkan',
                        icon: 'success',
                        confirmButtonColor: '#22c55e'
                    });
                    closeModal('bookingModal');
                    // Refetch events dan booked dates tanpa reload halaman
                    if (calendar) {
                        calendar.refetchEvents();
                    }
                    // Reset form
                    document.getElementById('adminBookingForm').reset();
                    document.getElementById('dateContainer').innerHTML = '';
                    // Reset preview bukti pembayaran
                    document.getElementById('buktiPreview').classList.add('hidden');
                    document.getElementById('buktiPreviewImg').src = '';
                } else {
                    // Tampilkan error validasi jika ada
                    let errorMessage = result.message || 'Terjadi kesalahan';

                    if (result.errors) {
                        // Format error messages
                        const errorMessages = [];
                        for (const [field, messages] of Object.entries(result.errors)) {
                            errorMessages.push(...messages);
                        }
                        errorMessage = errorMessages.join('<br>');
                    }

                    await Swal.fire({
                        title: 'Gagal!',
                        html: errorMessage,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            }
        } catch (error) {
            console.error('Error submitting booking:', error);
            await Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan sistem',
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
        }
    }

    // Modal Management
    function initializeModals() {
        // Toggle modal buttons
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                showModal(modalId);
            });
        });

        // Close modal buttons
        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-hide');
                closeModal(modalId);
            });
        });

        // Close modal when clicking outside
        window.addEventListener('click', (event) => {
            if (event.target.matches('[data-modal-backdrop="static"]')) {
                const modalId = event.target.closest('[id]').id;
                closeModal(modalId);
            }
        });
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeModals();
    });

    // Function to navigate to peminjaman detail page
    function navigateToPeminjamanDetail() {
        console.log('navigateToPeminjamanDetail called, currentEventData:', currentEventData);

        if (!currentEventData) {
            console.error('No event data available');
            Swal.fire({
                title: 'Error',
                text: 'Data event tidak tersedia. Silakan klik acara terlebih dahulu.',
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
            return;
        }

        const {
            status
        } = currentEventData;

        // Define routes based on status
        const statusRoutes = {
            'diajukan': '/admin/peminjaman-diajukan',
            'diproses': '/admin/peminjaman-diproses',
            'disetujui': '/admin/peminjaman-disetujui',
            'ditolak': '/admin/peminjaman-ditolak',
            'dibatalkan': '/admin/peminjaman-dibatalkan',
            'diajukanbatal': '/admin/peminjaman-diajukanbatal',
            'selesai': '/admin/peminjaman-selesai'
        };

        let targetRoute = statusRoutes[status];

        // Check if route exists for this status
        if (!targetRoute) {
            console.error('No route found for status:', status);
            Swal.fire({
                title: 'Error',
                text: `Tidak ada halaman yang tersedia untuk status "${status}".`,
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
            return;
        }

        // Add peminjaman ID as parameter for auto-opening modal
        if (currentEventData.peminjamanId) {
            targetRoute += `?open_modal=${currentEventData.peminjamanId}`;
        } else {
            console.warn('No peminjamanId available for navigation');
        }

        // Show confirmation dialog
        Swal.fire({
            title: 'Navigasi ke Halaman Peminjaman',
            text: `Anda akan diarahkan ke halaman ${status} untuk mengelola peminjaman ini.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#059669',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                // Close current modal first
                closeModal();

                // Navigate to target page
                window.location.href = targetRoute;
            }
        });
    }
</script>
@endsection