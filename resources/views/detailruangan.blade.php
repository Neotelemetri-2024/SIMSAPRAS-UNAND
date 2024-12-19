@extends('layouts.user')
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
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js"></script>
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
           headerToolbar: {
               left: 'prev,next today',
               center: 'title',
               right: 'dayGridMonth,timeGridWeek,timeGridDay'
           },
           events: @json($events),
           eventColor: '#3788d8',
           selectable: true,
           selectConstraint: {
               start: minDate.toISOString().split('T')[0],
           },
           selectAllow: function(selectInfo) {
               return selectInfo.start >= minDate;
           },
           dateClick: function(info) {
               const clickedDate = new Date(info.dateStr);
               if (clickedDate < minDate) {
                   // Show warning message for disabled dates
                   const warningMessage = document.createElement('div');
                   warningMessage.className = 'warning-popup';
                   warningMessage.innerHTML = `
                       <div class="warning-content">
                           <p>Peminjaman harus dilakukan minimal 7 hari sebelum jadwal yang diinginkan</p>
                           <button type="button" class="close-warning">Tutup</button>
                       </div>
                   `;
                   document.body.appendChild(warningMessage);
   
                   // Add event listener to close button
                   warningMessage.querySelector('.close-warning').addEventListener('click', function() {
                       warningMessage.remove();
                   });
   
                   // Auto remove after 3 seconds
                   setTimeout(() => {
                       if (document.body.contains(warningMessage)) {
                           warningMessage.remove();
                       }
                   }, 3000);
                   return;
               }
   
               // Handle date selection for valid dates
               if (selectedDates.has(info.dateStr)) {
                   selectedDates.delete(info.dateStr);
                   info.dayEl.classList.remove('selected-date');
               } else {
                   selectedDates.add(info.dateStr);
                   info.dayEl.classList.add('selected-date');
               }
               updateSelectedDatesDisplay();
           },
           eventDidMount: function(info) {
               if (info.event.extendedProps.status === 'diajukan') {
                   info.el.style.backgroundColor = '#F97316';
               } else if (info.event.extendedProps.status === 'disetujui') {
                   info.el.style.backgroundColor = '#059669';
               }
           },
           dayCellDidMount: function(arg) {
               if (arg.date < minDate) {
                   arg.el.classList.add('fc-disabled-date');
               }
               if (selectedDates.has(arg.el.dataset.date)) {
                   arg.el.classList.add('selected-date');
               }
           },
           eventDisplay: 'block',
           height: 'auto',
           slotMinTime: '07:00:00',
           slotMaxTime: '18:00:00',
           allDaySlot: false,
           buttonText: {
               today: 'Hari Ini',
               month: 'Bulan',
               week: 'Minggu',
               day: 'Hari'
           },
           locale: 'id'
       });
       
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
<style>
   .fc {
   max-width: 100%;
   height: auto;
   }
   .fc .fc-toolbar.fc-header-toolbar {
   margin-bottom: 1.5em;
   }
   .fc .fc-toolbar-title {
   font-size: 1.5em;
   }
   .fc-event {
   cursor: pointer;
   }
   .fc-timegrid-slot-minor {
   border-top-style: none;
   }
   .fc-no-events {
   font-size: 1.2em;
   color: #666;
   padding: 20px;
   text-align: center;
   }
   /* Selected date styling */
   .selected-date {
   background-color: rgba(34, 197, 94, 0.2) !important;
   }
   /* Disabled dates styling */
   .fc-day.fc-disabled-date {
   background-color: rgba(239, 68, 68, 0.1) !important;
   cursor: pointer !important;
   }
   /* Warning popup styling */
   .warning-popup {
   position: fixed;
   top: 50%;
   left: 50%;
   transform: translate(-50%, -50%);
   z-index: 1000;
   animation: fadeIn 0.3s ease-out;
   }
   .warning-content {
   background-color: #ef4444;
   color: white;
   padding: 1rem 1.5rem;
   border-radius: 8px;
   box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
   text-align: center;
   max-width: 300px;
   }
   .close-warning {
   background-color: white;
   color: #ef4444;
   border: none;
   padding: 0.5rem 1rem;
   border-radius: 4px;
   margin-top: 0.75rem;
   cursor: pointer;
   font-weight: 500;
   transition: background-color 0.2s;
   }
   .close-warning:hover {
   background-color: #f3f4f6;
   }
   @keyframes fadeIn {
   from {
   opacity: 0;
   transform: translate(-50%, -40%);
   }
   to {
   opacity: 1;
   transform: translate(-50%, -50%);
   }
   }
   @media (max-width: 640px) {
   .fc .fc-toolbar {
   flex-direction: column;
   gap: 1rem;
   }
   .fc .fc-toolbar-title {
   font-size: 1.2em;
   }
   .warning-content {
   max-width: 250px;
   font-size: 14px;
   }
   }
</style>
@endpush
@endsection