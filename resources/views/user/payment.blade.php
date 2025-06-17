@extends('layouts.user-layouts')

@section('content')
    <div class="container mx-auto p-4 max-w-lg">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold mb-6 text-center">Pembayaran</h1>

            <div class="mb-6">
                <p class="text-lg mb-2">Order ID: <span class="font-semibold">{{ $order->id }}</span></p>
                <p class="text-lg">Total Pembayaran: <span class="font-semibold">Rp
                        {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
            </div>

            <div id="payment-status" class="hidden mb-4 p-4 rounded"></div>

            <button id="pay-button"
                class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                        clip-rule="evenodd" />
                </svg>
                Bayar Sekarang
            </button>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Pembayaran diproses oleh Midtrans</p>
                <img src="https://midtrans.com/img/logo-midtrans.png" alt="Midtrans" class="h-8 mx-auto mt-2">
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payButton = document.getElementById('pay-button');
            const statusDiv = document.getElementById('payment-status');

            payButton.addEventListener('click', function() {
                payButton.disabled = true;
                payButton.innerHTML = '<span class="animate-pulse">Memproses...</span>';

                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        showStatus('success',
                            'Pembayaran berhasil! Mengarahkan ke halaman order...');
                        setTimeout(() => {
                            window.location.href = "{{ route('orders.user') }}";
                        }, 2000);
                    },
                    onPending: function(result) {
                        showStatus('warning',
                            'Pembayaran menunggu konfirmasi. Mengarahkan ke halaman order...'
                            );
                        setTimeout(() => {
                            window.location.href = "{{ route('orders.user') }}";
                        }, 2000);
                    },
                    onError: function(result) {
                        showStatus('error', 'Pembayaran gagal: ' + (result.status_message ||
                            'Silakan coba lagi'));
                        payButton.disabled = false;
                        payButton.innerHTML = 'Coba Lagi';
                    },
                    onClose: function() {
                        showStatus('info', 'Anda menutup halaman pembayaran');
                        payButton.disabled = false;
                        payButton.innerHTML = 'Bayar Sekarang';
                    }
                });
            });

            function showStatus(type, message) {
                statusDiv.className = `p-4 rounded mb-4 ${getStatusClass(type)}`;
                statusDiv.innerHTML = message;
                statusDiv.classList.remove('hidden');
            }

            function getStatusClass(type) {
                const classes = {
                    'success': 'bg-green-100 text-green-800',
                    'error': 'bg-red-100 text-red-800',
                    'warning': 'bg-yellow-100 text-yellow-800',
                    'info': 'bg-blue-100 text-blue-800'
                };
                return classes[type] || 'bg-gray-100 text-gray-800';
            }
        });
    </script>
@endsection
