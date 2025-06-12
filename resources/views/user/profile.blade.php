@extends('layouts.user-layouts')

@section('content')
    <div class="max-w-xl mx-auto bg-green-50 rounded-lg shadow-md p-8 mt-8">
        <div class="mb-8 flex flex-col items-center justify-center">
            <h1 class="text-3xl font-extrabold text-green-800 mb-2 text-center drop-shadow">
                Selamat datang, {{ Auth::user()->username }}
            </h1>
            <div class="w-20 h-1 bg-green-400 rounded-full mb-2"></div>
            <p class="text-green-700 text-center">Senang bertemu kembali! </p>
        </div>
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-green-800 mb-2" for="username">Name</label>
                <input type="text" name="username" id="username"
                    value="{{ old('usernname', auth()->user()->username) }}"
                    class="w-full px-4 py-2 border border-green-200 rounded focus:outline-none focus:ring-2 focus:ring-green-300 bg-green-100 text-green-900">
            </div>
            <div class="mb-4">
                <label class="block text-green-800 mb-2" for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                    class="w-full px-4 py-2 border border-green-200 rounded focus:outline-none focus:ring-2 focus:ring-green-300 bg-green-100 text-green-900">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded shadow transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
