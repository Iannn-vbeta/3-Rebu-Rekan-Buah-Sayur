@extends('layouts.admin-layout')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Daftar Masukan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border-b text-left">No</th>
                        <th class="px-4 py-2 border-b text-left">Nama User</th>
                        <th class="px-4 py-2 border-b text-left">Masukan</th>
                        <th class="px-4 py-2 border-b text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($masukans as $index => $masukan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border-b">{{ $masukan->user->username ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $masukan->pesan ?? '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $masukan->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">Tidak ada masukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
