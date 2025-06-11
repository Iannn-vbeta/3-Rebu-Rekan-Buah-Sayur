@extends('layouts.user-layouts')

@section('content')
    <div class="container mx-auto max-w-md p-6 bg-gradient-to-br from-blue-100 to-indigo-200 rounded-xl shadow-lg">
        <div class="flex flex-col items-center">
            <div class="w-full bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex flex-col items-center">
                    <div class="text-3xl font-bold text-indigo-700 mb-2">
                        {{ Auth::user()->username }}
                    </div>
                    <div class="text-gray-500 mb-4">
                        {{ Auth::user()->email }}
                    </div>
                    <button id="editProfileBtn"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-full shadow hover:bg-indigo-700 transition"
                        type="button">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="profileModal" style="display: none;"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-white rounded-2xl p-8 w-full max-w-md relative shadow-xl">
                <button class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 text-2xl" type="button"
                    id="closeProfileModal">&times;</button>
                <h2 class="text-xl font-semibold text-indigo-700 mb-4 text-center">Edit Profile</h2>
                <form action="{{ route('user.profile.update') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    @method('PUT')
                    <!-- Username & Email Section -->
                    <div class="bg-indigo-50 rounded-lg p-4 mb-2">
                        <label class="block mb-1 font-semibold text-indigo-700">Username</label>
                        <input type="text" name="username" value="{{ Auth::user()->username }}"
                            class="mb-3 border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            required>
                        <label class="block mb-1 font-semibold text-indigo-700">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}"
                            class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            required>
                    </div>
                    <!-- Password Section -->
                    <div class="bg-indigo-50 rounded-lg p-4 mb-2">
                        <label class="block mb-1 font-semibold text-indigo-700">Password Baru</label>
                        <input type="password" name="password"
                            class="mb-3 border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            placeholder="Kosongkan jika tidak ingin mengubah">
                        <label class="block mb-1 font-semibold text-indigo-700">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation"
                            class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            placeholder="Ulangi password baru">
                    </div>
                    <!-- Current Password Confirmation -->
                    <div class="bg-indigo-50 rounded-lg p-4">
                        <label class="block mb-1 font-semibold text-indigo-700">Konfirmasi Password Saat Ini</label>
                        <input type="password" name="current_password"
                            class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            required placeholder="Masukkan password Anda">
                    </div>
                    <button type="submit"
                        class="mt-2 px-6 py-2 bg-indigo-600 text-white rounded-full shadow hover:bg-indigo-700 transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
        <!-- End Modal -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('editProfileBtn');
            const modal = document.getElementById('profileModal');
            const closeBtn = document.getElementById('closeProfileModal');

            editBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
            });

            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
@endsection
