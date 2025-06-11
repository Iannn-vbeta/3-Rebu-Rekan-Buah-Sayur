@extends('layouts.user-layouts')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Keranjang Belanja</h1>

        @if ($cart && $cart->cartItems->count() > 0)
            <table class="w-full border-collapse border border-gray-300 mb-6">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">Produk</th>
                        <th class="border border-gray-300 px-4 py-2">Harga</th>
                        <th class="border border-gray-300 px-4 py-2">Kuantitas</th>
                        <th class="border border-gray-300 px-4 py-2">Subtotal</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart->cartItems as $item)
                        @php
                            $subtotal = $item->quantity * $item->product->price;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->product->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">Rp
                                {{ number_format($item->product->price, 0, ',', '.') }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                    class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="action" value="decrement"
                                        class="bg-gray-300 text-black px-2 py-1 rounded hover:bg-gray-400">-</button>
                                    <span class="px-3">{{ $item->quantity }}</span>
                                    <button type="submit" name="action" value="increment"
                                        class="bg-gray-300 text-black px-2 py-1 rounded hover:bg-gray-400">+</button>
                                </form>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="font-bold bg-gray-100">
                        <td colspan="3" class="border border-gray-300 px-4 py-2 text-right">Total</td>
                        <td colspan="2" class="border border-gray-300 px-4 py-2">Rp
                            {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <a href="{{ route('checkout.form') }}"
                class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Lanjut ke Pembayaran</a>
        @else
            <p>Keranjang kosong.</p>
        @endif
    </div>
@endsection
