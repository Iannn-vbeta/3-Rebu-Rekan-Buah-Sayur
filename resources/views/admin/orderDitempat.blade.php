@extends('layouts.admin-layout')
@section('content')
    <div class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold mb-6">Daftar Order Ambil Ditempat</h2>

        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <form id="live-search-form" class="mb-6">
            <div class="flex">
                <input type="text" id="search-input" name="search"
                    class="flex-1 rounded-l border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Cari nama, alamat, atau status...">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700 transition" type="submit">
                    Cari
                </button>
            </div>
        </form>

        <div id="search-results">
            @include('components.admin.order-diantar-table', ['orders' => $orders])
        </div>
    </div>

    <script>
        const form = document.getElementById('live-search-form');
        const input = document.getElementById('search-input');
        const resultContainer = document.getElementById('search-results');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            searchOrder();
        });

        input.addEventListener('keyup', function() {
            searchOrder();
        });

        function searchOrder() {
            const query = input.value;

            fetch(`{{ route('order.diantar.search') }}?search=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    resultContainer.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
