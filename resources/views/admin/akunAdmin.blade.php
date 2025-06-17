@extends('layouts.admin-layout')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Manajemen Akun Admin</h1>

        @if (session('success'))
            <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search -->
        <form id="searchForm" class="mb-4" onsubmit="return false;">
            <input type="text" id="searchInput" name="search" placeholder="Cari user..." class="border p-2 rounded w-1/3" />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Cari</button>
            <button type="button" onclick="openModal('addModal')"
                class="bg-green-500 text-white px-4 py-2 rounded ml-2">Tambah User</button>
        </form>

        <div id="userTable">
            @include('components.admin.adminTable', ['users' => $users])
        </div>
    </div>

    <!-- Modal Tambah -->
    <div id="addModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white w-1/2 p-6 rounded relative">
            <h2 class="text-xl font-bold mb-4">Tambah User</h2>
            <form method="POST" action="{{ route('admin.store') }}">
                @csrf
                <input type="text" name="username" placeholder="Username" class="w-full border p-2 mb-2" required>
                <input type="email" name="email" placeholder="Email" class="w-full border p-2 mb-2" required>
                <input type="password" name="password" placeholder="Password" class="w-full border p-2 mb-2" required>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                    class="w-full border p-2 mb-4" required>
                <button class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
                <button type="button" onclick="closeModal('addModal')" class="ml-2 text-gray-700">Batal</button>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white w-1/2 p-6 rounded relative">
            <h2 class="text-xl font-bold mb-4">Edit User</h2>
            <form method="POST" action="" id="editForm">
                @csrf
                @method('PUT')
                <input type="text" name="username" id="editUsername" class="w-full border p-2 mb-2" required>
                <input type="email" name="email" id="editEmail" class="w-full border p-2 mb-2" required>
                <input type="password" name="password" placeholder="Password (opsional)" class="w-full border p-2 mb-2">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password (opsional)"
                    class="w-full border p-2 mb-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
                <button type="button" onclick="closeModal('editModal')" class="ml-2 text-gray-700">Batal</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openEditModal(id, username, email) {
            document.getElementById('editUsername').value = username;
            document.getElementById('editEmail').value = email;
            document.getElementById('editForm').action = `{{ url('/admin') }}/${id}`;
            openModal('editModal');
        }

        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                let search = $(this).val();
                $.ajax({
                    url: "{{ route('admin.search') }}",
                    data: {
                        search: search
                    },
                    success: function(data) {
                        $('#userTable').html(data);
                    }
                });
            });
        });
    </script>
@endsection
