@extends('layouts.user')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet">
<!-- Updated styles -->
<style>
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
   .fc-day.fc-disabled-date {
   background-color: rgba(239, 68, 68, 0.1) !important;
   cursor: not-allowed !important;
   }
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
   /* Event status colors - adjusted to match legend */
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
   background-color: #f97316 !important; /* Changed to match legend (orange) */
   border-color: #ea580c !important;
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
<section class="bg-white pt-24 pb-12">
   <div class="max-w-screen-xl mx-auto px-4 lg:px-6">
      <!-- Header Section -->
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
         <h1 class="text-4xl font-bold mb-6">{{ $ruangan->nama }}</h1>
         <!-- Image Carousel -->
         <!-- Image Carousel -->
         <div id="carousel" class="relative">
            <div class="relative h-[500px] overflow-hidden rounded-xl">
               @foreach($ruangan->gambarRuangan as $index => $gambar)
               <div class="carousel-item absolute w-full h-full transition-opacity duration-500 
                  {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                  style="display: {{ $index === 0 ? 'block' : 'none' }}">
                  <img src="{{ Storage::url($gambar->gambar) }}" 
                     alt="{{ $ruangan->nama }}" 
                     class="w-full h-full object-cover">
               </div>
               @endforeach
            </div>
            <!-- Navigation Buttons -->
            @if($ruangan->gambarRuangan->count() > 1)
            <button onclick="moveSlide(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
               </svg>
            </button>
            <button onclick="moveSlide(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
               </svg>
            </button>
            <!-- Indicators -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
               @foreach($ruangan->gambarRuangan as $index => $gambar)
               <button onclick="goToSlide({{ $index }})" 
                  class="w-3 h-3 rounded-full transition-colors duration-300
                  {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}">
               </button>
               @endforeach
            </div>
            @endif
         </div>
      </div>
      <!-- Content Grid -->
      <div class="grid grid-cols-1 gap-8">
         <!-- Info Grid -->
         <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Deskripsi & Info -->
            <div class="lg:col-span-2">
               <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                  <h2 class="text-2xl font-semibold mb-4">Deskripsi</h2>
                  <p class="text-gray-600 mb-6">{{ $ruangan->deskripsi }}</p>
                  <!-- Informasi Ruangan -->
                  <div class="grid grid-cols-2 gap-6">
                     <div>
                        <h3 class="font-semibold text-lg mb-2">Kapasitas</h3>
                        <p class="text-gray-600">{{ $ruangan->kapasitas }} orang</p>
                     </div>
                     <div>
                        <h3 class="font-semibold text-lg mb-2">Lantai</h3>
                        <p class="text-gray-600">{{ $ruangan->lantai }}</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Informasi Penjaga -->
            <div class="lg:col-span-1">
               <div class="bg-white rounded-lg shadow-md p-6">
                  <h2 class="text-xl font-semibold mb-4">Informasi Penjaga</h2>
                  @forelse($ruangan->sarana->penjaga as $penjaga)
                  <div class="mb-4 pb-4 border-b border-gray-200 last:border-0 last:pb-0 last:mb-0">
                     <h3 class="font-medium mb-2">{{ $penjaga->nama }}</h3>
                     <p class="text-gray-600 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                           <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        {{ $penjaga->kontak }}
                     </p>
                  </div>
                  @empty
                  <p class="text-gray-500">Tidak ada informasi penjaga</p>
                  @endforelse
               </div>
            </div>
         </div>
         <!-- Kalender Peminjaman Section -->
         <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
               <h2 class="text-2xl font-semibold">Jadwal Peminjaman</h2>
               <!-- Legend -->
               <div class="flex items-center gap-4">
                  <div class="flex items-center gap-2">
                     <div class="w-4 h-4 rounded bg-[#059669]"></div>
                     <span class="text-sm text-gray-600">Disetujui</span>
                  </div>
                  <div class="flex items-center gap-2">
                     <div class="w-4 h-4 rounded bg-[#F97316]"></div>
                     <span class="text-sm text-gray-600">Diajukan</span>
                  </div>
               </div>
            </div>
            <div id="calendar" class="min-h-[700px]"></div>
            <div class="mt-8">
               <form action="{{ route('peminjaman.create') }}" method="GET" id="peminjamanForm">
                  <input type="hidden" name="ruangan_id" value="{{ $ruangan->id }}">
                  <input type="hidden" name="selected_dates" id="selectedDates">
                  <div class="mb-4">
                     <h3 class="text-lg font-medium mb-2">Tanggal Yang Dipilih:</h3>
                     <div id="selectedDatesDisplay" class="p-4 bg-gray-50 rounded-lg min-h-[50px]">
                        <p class="text-gray-500">Belum ada tanggal yang dipilih</p>
                     </div>
                  </div>
                  <div class="text-center">
                     <button type="submit" 
                        class="inline-flex items-center px-6 py-3 text-lg font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 disabled:bg-gray-400"
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
       const slides = document.querySelectorAll('.carousel-item');
       const indicators = document.querySelectorAll('.bottom-4 button');
       
       if (!slides.length) return;
   
       function showSlide(n) {
           currentSlide = n;
           
           slides.forEach((slide, index) => {
               if (index === n) {
                   slide.style.opacity = '1';
                   slide.style.display = 'block';
               } else {
                   slide.style.opacity = '0';
                   slide.style.display = 'none';
               }
           });
           
           indicators.forEach((indicator, index) => {
               if (index === n) {
                   indicator.classList.add('bg-white');
                   indicator.classList.remove('bg-white/50');
               } else {
                   indicator.classList.remove('bg-white');
                   indicator.classList.add('bg-white/50');
               }
           });
       }
   
       function moveSlide(direction) {
           let newSlide = (currentSlide + direction + slides.length) % slides.length;
           showSlide(newSlide);
       }
   
       function startAutoplay() {
           if (autoplayInterval) clearInterval(autoplayInterval);
           
           autoplayInterval = setInterval(() => {
               moveSlide(1);
           }, 2000);
       }
   
       function stopAutoplay() {
           if (autoplayInterval) {
               clearInterval(autoplayInterval);
               autoplayInterval = null;
           }
       }
   
       window.moveSlide = moveSlide;
       window.goToSlide = showSlide;
   
       showSlide(0);
       startAutoplay();
   
       const carousel = document.getElementById('carousel');
       if (carousel) {
           carousel.addEventListener('mouseenter', stopAutoplay);
           carousel.addEventListener('mouseleave', startAutoplay);
       }
   
       window.addEventListener('beforeunload', stopAutoplay);
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
       
       var calendar = new FullCalendar.Calendar(calendarEl, {
           initialView: 'dayGridMonth',
           locale: 'id',
           headerToolbar: {
               left: 'prev,next today',
               center: 'title',
               right: 'dayGridMonth,timeGridWeek,timeGridDay'
           },
           events: @json($events).map(event => {
               const start = new Date(event.start);
               const end = new Date(event.end);
               return {
                   ...event,
                   title: `${start.getHours().toString().padStart(2, '0')}:${start.getMinutes().toString().padStart(2, '0')}-${end.getHours().toString().padStart(2, '0')}:${end.getMinutes().toString().padStart(2, '0')}`,
                   className: `status-${event.status}`
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
               
               // Check if date has existing events
               const hasEvent = calendar.getEvents().some(event => {
                   const eventDate = new Date(event.start);
                   return eventDate.toDateString() === clickedDate.toDateString();
               });
               
               if (hasEvent) {
                   showWarning('Tanggal ini sudah ada peminjaman yang diajukan atau disetujui');
                   return;
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
@endpush
@endsection