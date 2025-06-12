<table class="w-full border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="border p-2">Nama</th>
            <th class="border p-2">Gambar</th>
            <th class="border p-2">Deskripsi</th>
            <th class="border p-2">Harga</th>
            <th class="border p-2">Stok</th>
            <th class="border p-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
            <tr>
                <td class="border p-2">{{ $product->name }}</td>
                <td class="border p-2 text-center">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-16 h-16 object-cover mx-auto">
                    @else
                        <span class="text-gray-500">Tidak ada gambar</span>
                    @endif
                </td>
                <td class="border p-2">{{ $product->description }}</td>
                <td class="border p-2">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="border p-2 text-center">{{ $product->stock }}</td>
                <td class="border p-2">
                    <button
                        onclick="openEditModal(
                            '{{ $product->id }}',
                            '{{ addslashes($product->name) }}',
                            '{{ addslashes($product->description) }}',
                            '{{ $product->price }}',
                            '{{ $product->stock }}'
                        )"
                        class="bg-yellow-500 text-white px-2 py-1 rounded">
                        Edit
                    </button>

                    <form method="POST" action="{{ route('product.destroy', $product->id) }}" class="inline-block"
                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="border p-2 text-center">Tidak ada produk ditemukan.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-2">
    {{ $products->links() }}
</div>
