<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Peminjaman {{ $ruangan }}</title>
    <!-- Update to use HTTPS and latest version -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
</head>
<body>
    <h1>Kalender Peminjaman: {{ $ruangan }}</h1>
    <div id="calendar"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        
        // Tambahkan pengecekan events
        var events = @json($events);
        console.log('Events:', events);

        if (!events || events.length === 0) {
            console.warn('Tidak ada event untuk ditampilkan');
            calendarEl.innerHTML = '<p>Tidak ada jadwal peminjaman untuk saat ini.</p>';
            return;
        }
        
        try {
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: events,
                eventColor: '#3788d8',
                eventDidMount: function(info) {
                    // Ubah warna berdasarkan status
                    if (info.event.extendedProps.status === 'diajukan') {
                        info.el.style.backgroundColor = 'orange';
                    } else if (info.event.extendedProps.status === 'disetujui') {
                        info.el.style.backgroundColor = 'green';
                    }
                },
                // Tambahkan error handling
                eventDisplay: 'block',
                height: 'auto'
            });
            
            calendar.render();
        } catch (error) {
            console.error('Kesalahan inisialisasi kalender:', error);
            calendarEl.innerHTML = '<p>Terjadi kesalahan saat memuat kalender.</p>';
        }
    });
    </script>
</body>
</html>