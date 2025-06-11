@extends('layouts.user-layouts')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-8 text-center text-blue-700 drop-shadow-lg tracking-wide">Produk Kami</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <div
                    class="bg-white shadow-lg rounded-xl overflow-hidden flex flex-col hover:scale-105 transition-transform duration-300">
                    <div class="relative">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/200x140' }}"
                            alt="{{ $product->name }}" class="object-cover h-36 w-full">
                        <span
                            class="absolute top-2 right-2 bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full shadow">Baru</span>
                    </div>
                    <div class="p-3 flex flex-col flex-1">
                        <h2 class="text-lg font-semibold mb-1 text-gray-800">{{ $product->name }}</h2>
                        <p class="text-gray-500 mb-2 text-xs">{{ Str::limit($product->description, 60) }}</p>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-base font-bold text-blue-700">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-3 py-1.5 rounded-md shadow hover:from-blue-600 hover:to-blue-800 transition-colors duration-200 flex items-center gap-1 text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m1-13h-6" />
                                    </svg>
                                    Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
