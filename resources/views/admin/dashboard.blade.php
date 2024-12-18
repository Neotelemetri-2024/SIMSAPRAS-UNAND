@extends('layouts.main')

@section('content')

<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <!-- Total Revenue Card -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">
                Total Revenue
            </p>
            <p class="text-lg font-semibold text-gray-700">
                $47,589
            </p>
            <p class="text-sm text-green-600">
                <span class="flex items-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    12% increase
                </span>
            </p>
        </div>
    </div>

    <!-- Total Orders Card -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">
                Total Orders
            </p>
            <p class="text-lg font-semibold text-gray-700">
                1,257
            </p>
            <p class="text-sm text-green-600">
                <span class="flex items-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    8.2% increase
                </span>
            </p>
        </div>
    </div>

    <!-- Active Users Card -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
        <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">
                Active Users
            </p>
            <p class="text-lg font-semibold text-gray-700">
                23,694
            </p>
            <p class="text-sm text-green-600">
                <span class="flex items-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    5.7% increase
                </span>
            </p>
        </div>
    </div>

    <!-- Customer Satisfaction Card -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs hover:bg-green-100">
        <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-7.536 5.879a1 1 0 001.415 0 3 3 0 014.242 0 1 1 0 001.415-1.415 5 5 0 00-7.072 0 1 1 0 000 1.415z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">
                Customer Satisfaction
            </p>
            <p class="text-lg font-semibold text-gray-700">
                98%
            </p>
            <p class="text-sm text-green-600">
                <span class="flex items-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    2.5% increase
                </span>
            </p>
        </div>
    </div>
</div>

<div class="grid gap-6">
    <!-- Monthly Revenue Chart Card -->
    <div class="bg-white rounded-lg shadow-xs p-4">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Monthly Revenue Trend</h2>
        <div class="h-64">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Three Charts Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Quarterly Sales Chart -->
        <div class="bg-white rounded-lg shadow-xs p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Quarterly Sales</h2>
            <div class="h-48">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Traffic Sources Chart -->
        <div class="bg-white rounded-lg shadow-xs p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Traffic Sources</h2>
            <div class="h-48">
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>

        <!-- Weekly Performance Chart -->
        <div class="bg-white rounded-lg shadow-xs p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Weekly Performance</h2>
            <div class="h-48">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Two Charts Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Product Distribution Chart -->
        <div class="bg-white rounded-lg shadow-xs p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Product Distribution</h2>
            <div class="h-64">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <!-- Income vs Expenses Chart -->
        <div class="bg-white rounded-lg shadow-xs p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Income vs Expenses</h2>
            <div class="h-64">
                <canvas id="stackedBarChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueChart = new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Monthly Revenue',
                data: [1200, 1900, 1500, 2100, 1800, 2500],
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgb(59, 130, 246)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Bar Chart
    const barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: [{
                label: 'Sales',
                data: [540, 650, 420, 780],
                backgroundColor: 'rgb(59, 130, 246)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Doughnut Chart
    const doughnutChart = new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Direct', 'Referral', 'Social'],
            datasets: [{
                data: [300, 150, 100],
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

    // Line Chart
    const lineChart = new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            datasets: [{
                label: 'Weekly Trend',
                data: [65, 59, 80, 81, 56],
                borderColor: 'rgb(34, 197, 94)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Pie Chart
    const pieChart = new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Product A', 'Product B', 'Product C', 'Product D'],
            datasets: [{
                data: [300, 200, 150, 100],
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

    // Stacked Bar Chart
    const stackedBarChart = new Chart(document.getElementById('stackedBarChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr'],
            datasets: [{
                label: 'Income',
                data: [300, 400, 350, 500],
                backgroundColor: 'rgb(59, 130, 246)'
            }, {
                label: 'Expenses',
                data: [200, 300, 250, 350],
                backgroundColor: 'rgb(249, 115, 22)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            }
        }
    });
});
</script>
@endpush
@endsection
