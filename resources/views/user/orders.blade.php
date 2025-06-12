@extends('layouts.user-layouts')

@section('content')
    <div class="container mx-auto p-4 max-w-4xl">
        <h1 class="text-3xl font-extrabold mb-8 text-green-700 flex items-center gap-2">
            Riwayat Pembelian
        </h1>

        @if ($orders->count())
            <div class="overflow-x-auto rounded-xl shadow-lg bg-white">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-lime-100 text-green-900">
                            <th class="p-3 font-semibold">Order ID</th>
                            <th class="p-3 font-semibold">Tanggal</th>
                            <th class="p-3 font-semibold">Status</th>
                            <th class="p-3 font-semibold">Total</th>
                            <th class="p-3 font-semibold">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="hover:bg-lime-50 transition">
                                <td class="p-3 text-center font-mono text-lime-700">#{{ $order->id }}</td>
                                <td class="p-3 text-center">{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td class="p-3 text-center">
                                    <span
                                        class="inline-block px-2 py-1 rounded-full text-xs font-bold
                                        @if ($order->status == 'pending') bg-orange-100 text-orange-700
                                        @elseif($order->status == 'completed') bg-lime-100 text-lime-700
                                        @elseif($order->status == 'cancelled') bg-pink-100 text-pink-700
                                        @else bg-gray-100 text-gray-700 @endif
                                    ">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="p-3 text-right font-semibold text-orange-700">Rp
                                    {{ number_format($order->orderItems->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}
                                </td>
                                <td class="p-3 text-center">
                                    <button
                                        class="bg-lime-400 text-white px-4 py-1.5 rounded-lg shadow hover:bg-lime-500 transition font-semibold"
                                        onclick="showModal({{ $order->id }})">
                                        <svg class="inline w-5 h-5 mr-1 -mt-1" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Lihat
                                    </button>
                                    <!-- Modal Invoice -->
                                    <div id="modal-{{ $order->id }}"
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                        <div
                                            class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 relative animate-fade-in-down border-4 border-lime-400 modal-content overflow-y-auto max-h-[90vh]">
                                            <button
                                                class="absolute top-3 right-4 text-gray-400 hover:text-lime-700 text-3xl font-bold"
                                                onclick="closeModal({{ $order->id }})"
                                                aria-label="Close">&times;</button>
                                            <div class="flex items-center gap-3 mb-6">
                                                <svg class="w-10 h-10 text-lime-500" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="M12 8v4l3 3"></path>
                                                </svg>
                                                <div>
                                                    <h2 class="text-2xl font-bold text-lime-700">Nota Pembelian</h2>
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
                                                        <tr class="bg-lime-50">
                                                            <th class="py-2 px-2 text-left">Produk</th>
                                                            <th class="py-2 px-2 text-center">Qty</th>
                                                            <th class="py-2 px-2 text-right">Harga</th>
                                                            <th class="py-2 px-2 text-right">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->orderItems as $item)
                                                            <tr class="border-b hover:bg-orange-50">
                                                                <td class="py-2 px-2">{{ $item->product->name }}</td>
                                                                <td class="py-2 px-2 text-center">{{ $item->quantity }}
                                                                </td>
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
                                                        <span class="font-bold text-orange-700">
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
            </div>
            <div class="mt-6 flex justify-center">
                {{ $orders->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16">
                <svg class="w-16 h-16 text-lime-200 mb-4" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9 12l2 2 4-4"></path>
                </svg>
                <p class="text-lime-600 text-lg">Belum ada riwayat pembelian.</p>
            </div>
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

        .modal-content::-webkit-scrollbar {
            width: 6px;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: #84cc16;
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
