@extends('layouts.admin-layout')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Manajemen Produk</h1>

        @if (session('success'))
            <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search -->
        <form id="searchForm" class="mb-4" onsubmit="return false;">
            <input type="text" id="searchInput" name="search" placeholder="Cari produk..."
                class="border p-2 rounded w-1/3" />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Cari</button>
            <button type="button" onclick="openModal('addModal')"
                class="bg-green-500 text-white px-4 py-2 rounded ml-2">Tambah Produk</button>
        </form>

        <div id="productTable">
            @include('components.admin.table', ['products' => $products])
        </div>
    </div>

    <!-- Modal Tambah -->
    <div id="addModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white w-1/2 p-6 rounded relative">
            <h2 class="text-xl font-bold mb-4">Tambah Produk</h2>
            <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="text" name="name" placeholder="Nama Produk" class="w-full border p-2 mb-2" required>
                <textarea name="description" rows="4" placeholder="Deskripsi" class="w-full border p-2 mb-2"></textarea>
                <input type="number" name="price" step="0.01" placeholder="Harga" class="w-full border p-2 mb-2"
                    required>
                <input type="number" name="stock" placeholder="Stok" class="w-full border p-2 mb-2" required>
                <input type="file" name="image" class="w-full border p-2 mb-4" accept="image/*">
                <button class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
                <button type="button" onclick="closeModal('addModal')" class="ml-2 text-gray-700">Batal</button>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white w-1/2 p-6 rounded relative">
            <h2 class="text-xl font-bold mb-4">Edit Produk</h2>
            <form method="POST" action="" id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" name="name" id="editName" class="w-full border p-2 mb-2" required>
                <textarea name="description" id="editDescription" rows="4" class="w-full border p-2 mb-2"></textarea>
                <input type="number" step="0.01" name="price" id="editPrice" class="w-full border p-2 mb-2" required>
                <input type="number" name="stock" id="editStock" class="w-full border p-2 mb-2" required>
                <input type="file" name="image" class="w-full border p-2 mb-4">
                <button class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
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

        function openEditModal(id, name, description, price, stock) {
            document.getElementById('editName').value = name;
            document.getElementById('editDescription').value = description;
            document.getElementById('editPrice').value = price;
            document.getElementById('editStock').value = stock;

            document.getElementById('editForm').action = `{{ url('admin/products') }}/${id}`;

            openModal('editModal');
        }

        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                let search = $(this).val();
                $.ajax({
                    url: "{{ route('product.search') }}",
                    data: {
                        search: search
                    },
                    success: function(data) {
                        $('#productTable').html(data);
                    }
                });
            });
        });
    </script>
@endsection
