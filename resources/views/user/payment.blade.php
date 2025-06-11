@extends('layouts.user-layouts')

@section('content')
    <div class="container mx-auto p-4 max-w-lg">
        <h1 class="text-3xl font-bold mb-6">Pembayaran</h1>
        <p>Mohon selesaikan pembayaran Anda dengan klik tombol di bawah ini:</p>
        <button id="pay-button" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 mt-4">Bayar
            Sekarang</button>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert('Pembayaran berhasil!');
                    window.location.href = "{{ route('orders.user') }}";
                },
                onPending: function(result) {
                    alert('Pembayaran menunggu konfirmasi.');
                    window.location.href = "{{ route('orders.user') }}";
                },
                onError: function(result) {
                    alert('Pembayaran gagal, silakan coba lagi.');
                },
                onClose: function() {
                    alert('Anda menutup popup pembayaran tanpa menyelesaikan transaksi.');
                }
            });
        });
    </script>
@endsection
