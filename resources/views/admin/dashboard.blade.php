@extends('layouts.admin-layout')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ Auth::user() ? Auth::user()->username : 'Admin' }}
        </h1>
        <p class="text-gray-600 mt-2">Silakan kelola data dan pantau statistik di bawah ini.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="bg-blue-100 text-blue-600 rounded-full p-3 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 8v2a2 2 0 01-2 2h-4a2 2 0 01-2-2v-2m6 0a2 2 0 00-2-2h-4a2 2 0 00-2 2" />
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold">{{ $totalUsers ?? 0 }}</div>
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
                <div class="text-2xl font-bold">{{ $totalProducts ?? 0 }}</div>
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
                <div class="text-2xl font-bold">{{ $totalOrders ?? 0 }}</div>
                <div class="text-gray-500">Total Orders</div>
            </div>
        </div>
    </div>
    <div class="mt-10 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Grafik Penjualan 7 Hari Terakhir</h2>
        <canvas id="salesTrafficChart" height="100" width="400"></canvas>
    </div>

    @php
        $salesLabels = $salesTraffic->pluck('date')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        });
        $salesData = $salesTraffic->pluck('total');
    @endphp

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/wavesurfer.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('salesTrafficChart').getContext('2d');
                const salesTrafficChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($salesLabels) !!},
                        datasets: [{
                            label: 'Penjualan',
                            data: {!! json_encode($salesData) !!},
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.5, // tension tinggi untuk efek gelombang
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
            });
        </script>
    @endpush
@endsection
