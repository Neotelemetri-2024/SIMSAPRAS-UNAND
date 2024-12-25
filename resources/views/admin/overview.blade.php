{{-- resources/views/admin/overview.blade.php --}}
@extends('layouts.main')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet'>
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
</style>
@endsection

@section('content')
<div class="p-6 sm:p-8 space-y-8">
    <!-- Header Section -->
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-900">Kalender Peminjaman</h2>
            <div class="text-sm text-gray-500">
                {{ now()->format('l, d F Y') }}
            </div>
        </div>
        
        <!-- Header Controls: Legend and Filters -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                <!-- Calendar Legend -->
                <div class="flex flex-wrap gap-4">
                    <div class="legend-item">
                        <div class="legend-color bg-blue-500"></div>
                        <span class="text-sm font-medium">Diajukan</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color bg-orange-500"></div>
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
                </div>
                
                <!-- Filter Dropdowns -->
                <div class="filter-container flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <select id="saranaFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 w-full sm:w-48">
                        <option value="">Semua Sarana</option>
                        @foreach($saranas as $sarana)
                            <option value="{{ $sarana->id }}">{{ $sarana->nama }}</option>
                        @endforeach
                    </select>

                    <select id="statusFilter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 w-full sm:w-48">
                        <option value="">Semua Status</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="diproses">Diproses</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="diajukan">Diajukan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Container -->
    <div class="calendar-wrapper">
        <div id="calendar-container"></div>
    </div>

    <!-- Modal -->
    <div id="eventModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center min-h-screen bg-black bg-opacity-30 transition-opacity duration-200">
        <div class="relative w-full max-w-lg max-h-full mt-0">
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
                <div class="flex justify-end px-4 py-3 bg-gray-50 rounded-b-lg">
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar-container');
    const events = @json($events);
    const modal = document.getElementById('eventModal');
    const modalContent = modal.querySelector('.modal-content');
    let currentView = 'all';
    
    // Initialize FullCalendar
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: events.map(event => ({
            ...event,
            title: event.saranaName,
            className: `status-${event.status}`
        })),
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
            // Set status with appropriate styling
            const statusEl = document.getElementById('modalStatus');
            const statusMap = {
                'disetujui': ['bg-green-100 text-green-800'],
                'diproses': ['bg-yellow-100 text-yellow-800'],
                'ditolak': ['bg-red-100 text-red-800'],
                'diajukan': ['bg-blue-100 text-blue-800']
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

            // Show modal with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.add('show');
            }, 10);
        }
    });

    calendar.render();

    // Filter functionality with enhanced animation
    const applyFilters = () => {
        const saranaId = document.getElementById('saranaFilter').value;
        const status = document.getElementById('statusFilter').value;

        // Add loading state to calendar
        calendarEl.style.opacity = '0.5';
        calendarEl.style.transition = 'opacity 0.3s ease';

        const filteredEvents = events.filter(event => {
            const matchesSarana = saranaId ? event.saranaId === parseInt(saranaId) : true;
            const matchesStatus = status ? event.status === status : true;
            return matchesSarana && matchesStatus;
        }).map(event => ({
            ...event,
            title: saranaId ? event.kegiatan : event.saranaName,
            className: `status-${event.status}`
        }));

        calendar.removeAllEvents();
        calendar.addEventSource(filteredEvents);
        currentView = saranaId ? 'filtered' : 'all';

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

    // Add custom CSS for event colors
    const styleSheet = document.createElement('style');
    styleSheet.textContent = `
        .status-disetujui { 
            background-color: #059669 !important;
            border-color: #047857 !important;
        }
        .status-diproses { 
            background-color: #f97316 !important;
            border-color: #ea580c !important;
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
            background-color: #3b82f6;
            border-color: #2563eb;
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
</script>
@endsection