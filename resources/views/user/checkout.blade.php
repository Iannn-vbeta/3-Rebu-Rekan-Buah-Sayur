@extends('layouts.user-layouts')

@section('content')
    <div class="container mx-auto p-4 max-w-lg">
        <h1 class="text-3xl font-bold mb-6">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Metode Pengambilan</label>
                <select name="method" id="method" class="border rounded px-3 py-2 w-full" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="ambil_di_tempat" {{ old('method') == 'ambil_di_tempat' ? 'selected' : '' }}>Ambil di
                        Tempat</option>
                    <option value="antar" {{ old('method') == 'antar' ? 'selected' : '' }}>Antar</option>
                </select>
            </div>

            <div id="shipping-fields" class="hidden">
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Alamat</label>
                    <textarea name="address" class="border rounded px-3 py-2 w-full">{{ old('address') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Kota</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="border rounded px-3 py-2 w-full" />
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="border rounded px-3 py-2 w-full"
                    required />
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Catatan (opsional)</label>
                <textarea name="notes" class="border rounded px-3 py-2 w-full">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 w-full">Bayar
                Sekarang</button>
        </form>
    </div>

    <script>
        document.getElementById('method').addEventListener('change', function() {
            var shippingFields = document.getElementById('shipping-fields');
            if (this.value === 'antar') {
                shippingFields.classList.remove('hidden');
            } else {
                shippingFields.classList.add('hidden');
            }
        });
    </script>
@endsection
