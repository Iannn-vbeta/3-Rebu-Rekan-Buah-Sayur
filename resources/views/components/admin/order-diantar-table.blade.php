<div class="overflow-x-auto">
    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Order ID</th>
                <th class="border p-2">Alamat</th>
                <th class="border p-2">Telepon</th>
                <th class="border p-2">Notes</th>
                <th class="border p-2">Status Barang</th>
                <th class="border p-2">Status Pembayaran</th>
                <th class="border p-2">Metode</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $item)
                <tr>
                    <td class="border p-2">{{ $item->order_id }}</td>
                    <td class="border p-2">{{ $item->address ?? '-' }}</td>
                    <td class="border p-2">{{ $item->phone }}</td>
                    <td class="border p-2">{{ $item->notes ?? '-' }}</td>
                    <td class="border p-2">
                        <form action="{{ route('order.diantar.update', $item->id) }}" method="POST"
                            class="flex items-center space-x-2 w-full">
                            @csrf
                            @method('PUT')
                            <select name="status_barang"
                                class="w-full rounded border-2 py-1 px-2 text-sm focus:outline-none focus:ring-2 
                                {{ $item->status_barang == 'selesai' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                onchange="this.form.submit()">
                                <option value="selesai" {{ $item->status_barang == 'selesai' ? 'selected' : '' }}>
                                    Selesai</option>
                                <option value="belum selesai"
                                    {{ $item->status_barang == 'belum selesai' ? 'selected' : '' }}>
                                    Belum selesai</option>
                            </select>
                        </form>
                    </td>
                    <td class="border p-2 text-center">
                        <span
                            class="{{ $item->order && $item->order->status == 'lunas' ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                            {{ ucfirst($item->order->status ?? '-') }}
                        </span>
                    </td>
                    <td class="border p-2">{{ ucfirst($item->method) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border p-2 text-center text-gray-500">Tidak ada data order diantar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
