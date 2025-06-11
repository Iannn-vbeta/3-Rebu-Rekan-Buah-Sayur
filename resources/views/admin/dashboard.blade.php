@extends('layouts.admin-layout')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="bg-blue-100 text-blue-600 rounded-full p-3 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 8v2a2 2 0 01-2 2h-4a2 2 0 01-2-2v-2m6 0a2 2 0 00-2-2h-4a2 2 0 00-2 2" />
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold">{{ $usersCount ?? 0 }}</div>
                <div class="text-gray-500">Total Users</div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="bg-green-100 text-green-600 rounded-full p-3 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold">{{ $productsCount ?? 0 }}</div>
                <div class="text-gray-500">Total Products</div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="bg-yellow-100 text-yellow-600 rounded-full p-3 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V6a2 2 0 012-2h12a2 2 0 012 2v8c0 2.21-3.582 4-8 4z" />
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold">{{ $ordersCount ?? 0 }}</div>
                <div class="text-gray-500">Total Orders</div>
            </div>
        </div>
    </div>
    <div class="mt-10 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Traffic Penjualan</h2>
        <canvas id="salesTrafficChart" height="100"></canvas>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('salesTrafficChart').getContext('2d');
            const salesTrafficChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesLabels ?? []) !!},
                    datasets: [{
                        label: 'Penjualan',
                        data: {!! json_encode($salesData ?? []) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
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
        </script>
    @endpush
@endsection
