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
    <div class="max-w-screen-2xl mx-auto px-4 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <div class="flex items-center gap-2 text-gray-500 mb-2">
                <a href="{{ route('user.sarana.show', $ruangan->sarana) }}" class="hover:text-green-600">
                    {{ $ruangan->sarana->nama }}
                </a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span>{{ $ruangan->nama }}</span>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
            <!-- Left Column - Carousel -->
            <div class="sticky top-24 h-fit">
                <div id="carousel" class="relative group rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                    <div class="relative h-[600px]">
                        <!-- Progress bar -->
                        <div class="absolute top-0 left-0 w-full h-1 bg-white/20 z-10">
                            <div class="progress-bar h-full bg-white/60 transition-all duration-[5000ms] w-0"></div>
                        </div>

                        <div class="carousel-container absolute w-full h-full flex">
                            @foreach($ruangan->gambarRuangan as $index => $gambar)
                            <div class="carousel-item w-full h-full flex-shrink-0">
                                <img src="{{ Storage::url($gambar->gambar) }}"
                                     alt="{{ $ruangan->nama }}"
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
                            @foreach($ruangan->gambarRuangan as $index => $gambar)
                            <button onclick="goToSlide({{ $index }})"
                                    class="w-2.5 h-2.5 rounded-full transition-all duration-300 ease-out transform
                                           {{ $index === 0 ? 'bg-white scale-125' : 'bg-white/50 hover:scale-110 hover:bg-white/70' }}">
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Details -->
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-6">{{ $ruangan->nama }}</h1>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="p-8 space-y-8">
                        <!-- Description -->
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Deskripsi
                            </h2>
                            <p class="text-gray-600 leading-relaxed">{{ $ruangan->deskripsi }}</p>
                        </div>

                        <!-- Facilities -->
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Fasilitas
                            </h2>
                            <p class="text-gray-600 leading-relaxed">{{ $ruangan->fasilitas }}</p>
                        </div>

                        <!-- Capacity -->
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Kapasitas
                            </h2>
                            <p class="text-gray-600 leading-relaxed">{{ $ruangan->kapasitas }} orang</p>
                        </div>

                        <!-- Keeper Info -->
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                Informasi Penjaga
                            </h2>
                            <div class="space-y-4">
                                @forelse($ruangan->sarana->penjaga as $penjaga)
                                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl transition-all hover:bg-gray-100">
                                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 mb-1">{{ $penjaga->nama }}</h3>
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
                                <div class="p-4 bg-gray-50 rounded-xl text-gray-500 text-center">
                                    Tidak ada informasi penjaga
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900">Jadwal Peminjaman</h2>
                    <div class="flex items-center gap-6">
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
                        <input type="hidden" name="ruangan_id" value="{{ $ruangan->id }}">
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
});
</script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var selectedDates = new Set();
    var selectedDatesDisplay = document.getElementById('selectedDatesDisplay');
    var submitBtn = document.getElementById('submitBtn');
    var selectedDatesInput = document.getElementById('selectedDates');
    
    // Get date 1 week from now
    var minDate = new Date();
    minDate.setDate(minDate.getDate() + 7);
    
    // Check if room is a classroom
    const isClassroom = {{ $ruangan->kelas ? 'true' : 'false' }};
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        firstDay: 1,
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: @json($events).map(event => {
                const start = new Date(event.start);
                const end = new Date(event.end);
                
                // Set the appropriate class based on status
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
            return selectInfo.start >= minDate;
        },
        dateClick: function(info) {
            const clickedDate = new Date(info.dateStr);
            
            // Check if date is before minimum date
            if (clickedDate < minDate) {
                showWarning('Peminjaman harus dilakukan minimal 7 hari sebelum jadwal yang diinginkan');
                return;
            }
            
            // Check if it's a classroom and not weekend
            if (isClassroom) {
                const day = clickedDate.getDay();
                if (day !== 0 && day !== 6) { // 0 = Sunday, 6 = Saturday
                    showWarning('Ruangan kelas hanya dapat dipinjam pada hari Sabtu dan Minggu');
                    return;
                }
            }

            // Handle date selection
            if (selectedDates.has(info.dateStr)) {
                selectedDates.delete(info.dateStr);
                info.dayEl.classList.remove('selected-date');
            } else {
                selectedDates.add(info.dateStr);
                info.dayEl.classList.add('selected-date');
            }
            updateSelectedDatesDisplay();
        },
        dayCellDidMount: function(arg) {
            // Disable weekday selection for classrooms
            if (isClassroom) {
                const day = arg.date.getDay();
                if (day !== 0 && day !== 6) {
                    arg.el.classList.add('fc-disabled-date');
                }
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

    // Add classroom warning if applicable
    if (isClassroom) {
        const warningDiv = document.createElement('div');
        warningDiv.className = 'bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4';
        warningDiv.innerHTML = `
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Ruangan ini merupakan ruangan kelas yang hanya dapat dipinjam pada hari Sabtu dan Minggu.
                    </p>
                </div>
            </div>
        `;
        calendar.el.parentNode.insertBefore(warningDiv, calendar.el);
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
@endpush
@endsection