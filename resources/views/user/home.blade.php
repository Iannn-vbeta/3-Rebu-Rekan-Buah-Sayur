@extends('layouts.user-layouts')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-green-100 to-lime-100 flex flex-col justify-center items-center">
        <div class="flex flex-col md:flex-row items-center justify-center w-full max-w-5xl gap-10 py-16">
            <!-- Kiri -->
            <div class="flex-1 flex justify-center items-center">
                <img src="{{ asset('img/flat-people-order-food-online-grocery-shopping-from-mobile-application-internet-purchases-with-home-delivery-from-supermarket-store-smartphone-screen-with-buy-button-basket-full-products.png') }}"
                    alt="Buah dan Sayur" class="w-[30rem] h-[30rem] object-contain drop-shadow-xl animate-fade-in-up" />
            </div>

            <!-- Kanan -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold text-green-700 drop-shadow-lg mb-4 animate-fade-in-down">
                    Selamat Datang di <span class="text-lime-600">3-REBU</span>
                </h1>
                <p class="text-lg md:text-xl text-green-800 mb-6 animate-fade-in-up">
                    Temukan beragam buah dan sayur segar pilihan, langsung dari kebun ke meja makan Anda. Nikmati kemudahan
                    belanja online dengan harga terjangkau, kualitas terjamin, dan pengiriman cepat setiap hari!
                </p>
                <a href={{ route('user.dashboard') }}
                    class="inline-block px-8 py-3 bg-lime-500 text-white font-semibold rounded-full shadow-lg hover:bg-lime-600 transition transform hover:scale-105 animate-pulse">
                    Belanja Sekarang
                </a>
            </div>


        </div>
    @endsection
