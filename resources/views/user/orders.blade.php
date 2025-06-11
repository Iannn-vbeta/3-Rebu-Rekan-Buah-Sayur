@extends('layouts.user-layouts')

@section('content')
    <div class="container mx-auto p-4 max-w-4xl">
        <h1 class="text-2xl font-bold mb-6">Riwayat Pembelian</h1>

        @if ($orders->count())
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 p-2">Order ID</th>
                        <th class="border border-gray-300 p-2">Tanggal</th>
                        <th class="border border-gray-300 p-2">Status</th>
                        <th class="border border-gray-300 p-2">Total</th>
                        <th class="border border-gray-300 p-2">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="border border-gray-300 p-2">{{ $order->id }}</td>
                            <td class="border border-gray-300 p-2">{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="border border-gray-300 p-2 capitalize">{{ $order->status }}</td>
                            <td class="border border-gray-300 p-2">Rp
                                {{ number_format($order->orderItems->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 p-2 text-center">
                                <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition"
                                    onclick="showModal({{ $order->id }})">Lihat</button>
                                <!-- Modal Invoice -->
                                <div id="modal-{{ $order->id }}"
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                    <div
                                        class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-8 relative animate-fade-in-down border-4 border-blue-500">
                                        <button
                                            class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 text-2xl font-bold"
                                            onclick="closeModal({{ $order->id }})" aria-label="Close">&times;</button>
                                        <div class="flex items-center gap-3 mb-6">
                                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="M12 8v4l3 3"></path>
                                            </svg>
                                            <div>
                                                <h2 class="text-2xl font-bold text-blue-700">Nota Pembelian</h2>
                                                <div class="text-xs text-gray-500">#{{ $order->id }}</div>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="flex justify-between text-sm text-gray-600">
                                                <span>Tanggal</span>
                                                <span>{{ $order->created_at->format('d M Y H:i') }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm text-gray-600">
                                                <span>Status</span>
                                                <span class="capitalize">{{ $order->status }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="bg-blue-50">
                                                        <th class="py-2 px-2 text-left">Produk</th>
                                                        <th class="py-2 px-2 text-center">Qty</th>
                                                        <th class="py-2 px-2 text-right">Harga</th>
                                                        <th class="py-2 px-2 text-right">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderItems as $item)
                                                        <tr class="border-b">
                                                            <td class="py-2 px-2">{{ $item->product->name }}</td>
                                                            <td class="py-2 px-2 text-center">{{ $item->quantity }}</td>
                                                            <td class="py-2 px-2 text-right">Rp
                                                                {{ number_format($item->price, 0, ',', '.') }}</td>
                                                            <td class="py-2 px-2 text-right">Rp
                                                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="flex justify-end mt-4">
                                            <div class="w-1/2">
                                                <div class="flex justify-between py-1 text-gray-700">
                                                    <span class="font-semibold">Total</span>
                                                    <span class="font-bold text-blue-700">
                                                        Rp
                                                        {{ number_format($order->orderItems->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-6 text-center">
                                            <span class="text-xs text-gray-400">Terima kasih telah berbelanja!</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $orders->links() }}
        @else
            <p>Belum ada riwayat pembelian.</p>
        @endif
    </div>

    <style>
        @keyframes fade-in-down {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.3s ease;
        }

        /* Custom scrollbar for modal */
        .modal-content::-webkit-scrollbar {
            width: 6px;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 6px;
        }
    </style>
    <script>
        function showModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        // Optional: close modal on ESC or background click
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                document.querySelectorAll('[id^="modal-"]').forEach(modal => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            }
        });
        document.querySelectorAll('[id^="modal-"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        });
    </script>
@endsection
