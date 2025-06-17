@extends('layouts.user-layouts')

@section('content')
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8 text-center text-green-700 tracking-wide font-sans">Produk Sayur &amp; Buah
                Segar</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-7">
                @foreach ($products as $product)
                    <div
                        class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg hover:border-green-400 transition-all duration-200 flex flex-col">
                        <div class="w-full h-40 bg-green-50 flex items-center justify-center overflow-hidden rounded-t-xl">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/200x140?text=Produk' }}"
                                alt="{{ $product->name }}" class="object-cover h-full w-full" />
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1 font-sans">{{ $product->name }}</h2>
                            <p class="text-sm text-gray-600 mb-3 font-sans">{{ Str::limit($product->description, 50) }}</p>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-base font-bold text-green-700 font-sans">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span
                                    class="text-xs px-2 py-0.5 rounded-full font-medium {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-md shadow-sm transition-colors duration-150 flex items-center justify-center gap-2 text-sm disabled:opacity-60"
                                    {{ $product->stock < 1 ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m1-13h-6" />
                                    </svg>
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
