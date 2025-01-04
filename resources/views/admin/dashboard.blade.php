@extends('layouts.main')

@section('content')
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Total Sarana Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Total Sarana
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $sarana->count() }}
                </p>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Total Pengguna
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalUser }}
                </p>
            </div>
        </div>

        <!-- Total Instansi Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
            <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Total Instansi
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalInstansi }}
                </p>
            </div>
        </div>

        <!-- Total Peminjaman Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Total Peminjaman
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalPeminjaman }}
                </p>
            </div>
        </div>


        <!-- Peminjaman Masuk Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Peminjaman Masuk
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalPeminjamanMasuk }}
                </p>
            </div>
        </div>

        <!-- Peminjaman Diproses Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
            <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Peminjaman Diproses
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalPeminjamanDiproses }}
                </p>
            </div>
        </div>

        <!-- Peminjaman Disetujui Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Peminjaman Disetujui
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalPeminjamanDisetujui }}
                </p>
            </div>
        </div>

        <!-- Peminjaman Ditolak Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Peminjaman Ditolak
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalPeminjamanDitolak }}
                </p>
            </div>
        </div>

        {{-- Peminjaman Dibatalkan --}}
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100 xl:col-start-2">
            <div class="p-3 mr-4 text-gray-500 bg-gray-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Peminjaman Dibatalkan
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalPeminjamanDibatalkan }}
                </p>
            </div>
        </div>

        {{-- Peminjaman Diajukan Batal --}}

        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100 xl:col-start-3">
            <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Pengajuan Pembatalan
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $totalPeminjamanDiajukanBatal }}
                </p>
            </div>
        </div>
    </div>





    <div class="grid gap-6">
        <!-- Trend Peminjaman Bulanan -->
        <div class="bg-white rounded-lg shadow-xs p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Trend Peminjaman Bulanan</h2>
            <div class="h-64">
                <canvas id="statusTrendChart"></canvas>
            </div>
        </div>

        <!-- Three Charts Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Quarterly Sales Chart -->
            <div class="bg-white rounded-lg shadow-xs p-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Distribusi Status Peminjaman</h2>
                <div class="h-48">
                    <canvas id="statusDistributionChart"></canvas>
                </div>
            </div>

            <!-- Traffic Sources Chart -->
            <div class="bg-white rounded-lg shadow-xs p-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Sebaran Instansi Tertinggi</h2>
                <div class="h-48">
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>

            <!-- Weekly Performance Chart -->
            <div class="bg-white rounded-lg shadow-xs p-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Peminjaman Mingguan</h2>
                <div class="h-48">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Two Charts Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Product Distribution Chart -->
            <div class="bg-white rounded-lg shadow-xs p-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Sebaran Sarana Tertinggi</h2>
                <div class="h-64">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>

            <!-- Income vs Expenses Chart -->
            <div class="bg-white rounded-lg shadow-xs p-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Trend Peminjaman Sarana Bulanan</h2>
                <div class="h-64">
                    <canvas id="trendSaranaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Revenue Chart
                const statusTrendChart = new Chart(document.getElementById('statusTrendChart'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(
                            $monthlyStatusTrend->pluck('bulan')->map(function ($bulan) {
                                return date('F', mktime(0, 0, 0, $bulan, 1));
                            }),
                        ) !!},
                        datasets: [{
                                label: 'Diajukan',
                                data: {!! json_encode($monthlyStatusTrend->pluck('diajukan')) !!},
                                backgroundColor: 'rgb(59, 130, 246)', // blue
                                stack: 'stack0'
                            },
                            {
                                label: 'Diproses',
                                data: {!! json_encode($monthlyStatusTrend->pluck('diproses')) !!},
                                backgroundColor: 'rgb(234, 179, 8)', // yellow
                                stack: 'stack0'
                            },
                            {
                                label: 'Disetujui',
                                data: {!! json_encode($monthlyStatusTrend->pluck('disetujui')) !!},
                                backgroundColor: 'rgb(34, 197, 94)', // green
                                stack: 'stack0'
                            },
                            {
                                label: 'Ditolak',
                                data: {!! json_encode($monthlyStatusTrend->pluck('ditolak')) !!},
                                backgroundColor: 'rgb(239, 68, 68)', // red
                                stack: 'stack0'
                            },
                            {
                                label: 'Dibatalkan',
                                data: {!! json_encode($monthlyStatusTrend->pluck('dibatalkan')) !!},
                                backgroundColor: 'rgb(156, 163, 175)', // gray
                                stack: 'stack0'
                            },
                            {
                                label: 'Pembatalan Pengajuan',
                                data: {!! json_encode($monthlyStatusTrend->pluck('diajukanbatal')) !!},
                                backgroundColor: 'rgb(167, 139, 250)', // purple
                                stack: 'stack0'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: false,
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });

                // Status Distribution Chart
                const statusDistributionChart = new Chart(document.getElementById('statusDistributionChart'), {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode(
                            $statusDistribution->pluck('status')->map(function ($status) {
                                return ucfirst($status);
                            }),
                        ) !!},
                        datasets: [{
                            data: {!! json_encode($statusDistribution->pluck('total')) !!},
                            backgroundColor: [
                                'rgb(59, 130, 246)', // Diajukan - Biru
                                'rgb(234, 179, 8)', // Diproses - Kuning
                                'rgb(34, 197, 94)', // Disetujui - Hijau
                                'rgb(249, 115, 22)', // Ditolak - Oranye
                                'rgb(239, 68, 68)', // Dibatalkan - Merah
                                'rgb(156, 163, 175)' // Diajukan Batal - Abu-abu
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const value = context.raw;
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        label += value + ' (' + percentage + '%)';
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });

                // Sebaran Instansi
                const doughnutChart = new Chart(document.getElementById('doughnutChart'), {
                    type: 'doughnut',
                    data: {
                        labels: @json($instansi->pluck('instansi')),
                        datasets: [{
                            data: @json($instansi->pluck('jumlah')),
                            backgroundColor: [
                                'rgb(59, 130, 246)',
                                'rgb(34, 197, 94)',
                                'rgb(249, 115, 22)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                // Peminjaman Harian
                const lineChart = new Chart(document.getElementById('lineChart'), {
                    type: 'line',
                    data: {
                        labels: @json(
                            $weeklyPerformance->pluck('date')->map(function ($date) {
                                return date('D', strtotime($date));
                            })),
                        datasets: [{
                            label: 'Peminjaman Harian',
                            data: @json($weeklyPerformance->pluck('total')),
                            borderColor: 'rgb(34, 197, 94)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });

                // Sebaran Instansi
                const pieChart = new Chart(document.getElementById('pieChart'), {
                    type: 'pie',
                    data: {
                        labels: @json($grafikSarana->pluck('nama')),
                        datasets: [{
                            data: @json($grafikSarana->pluck('jumlah')),
                            backgroundColor: [
                                'rgb(59, 130, 246)',
                                'rgb(34, 197, 94)',
                                'rgb(249, 115, 22)',
                                'rgb(234, 179, 8)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                const chartColors = [
                    'rgb(59, 130, 246)',
                    'rgb(234, 179, 8)',
                    'rgb(34, 197, 94)',
                    'rgb(249, 115, 22)',
                    'rgb(239, 68, 68)',
                    'rgb(167, 139, 250)',
                    'rgb(14, 165, 233)',
                    'rgb(168, 85, 247)',
                    'rgb(236, 72, 153)',
                    'rgb(251, 146, 60)'
                ];

                const trendSaranaChart = new Chart(document.getElementById('trendSaranaChart'), {
                    type: 'line',
                    data: {
                        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                            'September', 'Oktober', 'November', 'Desember'
                        ],
                        datasets: {!! json_encode(
                            $trendSaranaData->map(function ($data, $namaSarana) {
                                    static $colorIndex = 0;
                                    return [
                                        'label' => $namaSarana,
                                        'data' => array_pad($data->pluck('total', 'bulan')->toArray(), 12, 0),
                                        'borderColor' => 'chartColors[' . $colorIndex++ % 10 . ']',
                                        'tension' => 0.1,
                                        'fill' => false,
                                    ];
                                })->values(),
                        ) !!}.map(dataset => ({
                            ...dataset,
                            borderColor: eval(dataset
                                .borderColor) // Evaluate string reference to chartColors array
                        }))
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: false,
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });


            });
        </script>
    @endpush
@endsection