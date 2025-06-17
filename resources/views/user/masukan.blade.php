@extends('layouts.user-layouts')
@section('content')
    <div class="flex justify-center items-center min-h-screen bg-gray-50">
        <div class="flex flex-col md:flex-row gap-6 w-full max-w-6xl">
            <div class="md:w-1/2 w-full">
                <div class="w-full h-[700px] rounded-lg shadow overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.287047643091!2d113.69283027593683!3d-8.173809881927584!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6942520c45715%3A0x14af267fb6ac1e53!2sPasar%20Tanjung%20Jember!5e0!3m2!1sid!2sid!4v1750135258691!5m2!1sid!2sid"
                        width="100%" height="700" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            <div class="md:w-1/2 w-full flex items-center">
                <form class="w-full bg-white p-6 rounded-lg shadow space-y-4" method="POST"
                    action="{{ route('masukan.store') }}">
                    @csrf
                    <div>
                        <h2 class="text-2xl font-bold text-green-700 mb-2">Bagikan Masukan Anda!</h2>
                        <p class="text-gray-600 mb-4">Pendapat Anda sangat berarti bagi kami untuk terus berkembang dan
                            memberikan yang terbaik. Jangan ragu untuk menuliskan saran atau kritik Anda di bawah ini.</p>
                    </div>
                    @if (session('success'))
                        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div>
                        <label for="pesan" class="block text-gray-700 font-semibold mb-2">Masukkan</label>
                        <input type="text"
                            class="form-input w-full border-gray-300 rounded focus:ring focus:ring-blue-200" id="pesan"
                            name="pesan" placeholder="Tulis masukkan Anda di sini" value="{{ old('pesan') }}">
                    </div>
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">Kirim</button>
                </form>
            </div>
        </div>
    </div>
@endsection
