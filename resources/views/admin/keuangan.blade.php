@extends('layouts.main')

@section('content')
<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">
                Total Pemasukan ({{ date('Y') }})
            </p>
            <p class="text-lg font-semibold text-gray-700">
                Rp {{ number_format($totalYearToDate, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">
                Pemasukan Bulan Ini
            </p>
            <p class="text-lg font-semibold text-gray-700">
                Rp {{ number_format($totalCurrentMonth, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
        <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">
                Total Transaksi
            </p>
            <p class="text-lg font-semibold text-gray-700">
                {{ $totalTransactions }}
            </p>
        </div>
    </div>

    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
        <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">
                Rata-rata Transaksi
            </p>
            <p class="text-lg font-semibold text-gray-700">
                Rp {{ number_format($averagePerTransaction, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>

<div class="grid gap-6">
    <div class="bg-white rounded-lg shadow-xs p-4">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Tren Pemasukan Bulanan</h2>
        <div class="h-64">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-xs p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Pemasukan per Sarana</h2>
            <div class="h-48">
                <canvas id="saranaChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-xs p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">UNAND vs UMUM</h2>
            <div class="h-48">
                <canvas id="customerTypeChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-xs p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Top 5 Ruangan</h2>
            <div class="h-48">
                <canvas id="topRoomsChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: @json($monthlyData->map(fn($item) => 
                (new DateTime($item->month))->format('M Y')
            )),
            datasets: [{
                label: 'Pemasukan',
                data: @json($monthlyData->pluck('total')),
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgb(59, 130, 246)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            }
        }
    });

    // Grafik per Sarana
    new Chart(document.getElementById('saranaChart'), {
        type: 'bar',
        data: {
            labels: @json($saranaData->pluck('sarana_name')),
            datasets: [{
                label: 'Pemasukan',
                data: @json($saranaData->pluck('total')),
                backgroundColor: 'rgb(59, 130, 246)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            }
        }
    });

    // Grafik UNAND vs UMUM
    new Chart(document.getElementById('customerTypeChart'), {
        type: 'doughnut',
        data: {
            labels: ['UNAND', 'UMUM'],
            datasets: [{
                data: @json($customerTypeData->pluck('total_income')),
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(249, 115, 22)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            }
        }
    });

        new Chart(document.getElementById('topRoomsChart'), {
        type: 'bar',
        data: {
            labels: @json($topRooms->pluck('room_name')),
            datasets: [{
                label: 'Pendapatan',
                data: @json($topRooms->pluck('total_income')),
                backgroundColor: 'rgb(34, 197, 94)',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const bookings = @json($topRooms->pluck('total_bookings'));
                            const kapasitas = @json($topRooms->pluck('kapasitas'));
                            return [
                                'Pendapatan: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw),
                                'Total Booking: ' + bookings[context.dataIndex],
                                'Kapasitas: ' + kapasitas[context.dataIndex] + ' orang'
                            ];
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection