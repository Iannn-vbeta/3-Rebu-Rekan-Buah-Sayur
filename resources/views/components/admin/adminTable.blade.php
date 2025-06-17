<table class="w-full border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="border p-2">Username</th>
            <th class="border p-2">Email</th>
            <th class="border p-2">Role</th>
            <th class="border p-2">Tanggal Dibuat</th>
            <th class="border p-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr>
                <td class="border p-2">{{ $user->username }}</td>
                <td class="border p-2">{{ $user->email }}</td>
                <td class="border p-2 text-center">{{ $user->id_role }}</td>
                <td class="border p-2 text-center">{{ $user->created_at->format('d-m-Y ') }}</td>
                <td class="border p-2 text-center">
                    <button
                        onclick="openEditModal(
                            '{{ $user->id }}',
                            '{{ addslashes($user->username) }}',
                            '{{ addslashes($user->email) }}',
                            '{{ $user->role }}'
                        )"
                        class="bg-yellow-500 text-white px-2 py-1 rounded">
                        Edit
                    </button>

                    <form method="POST" action="{{ route('admin.destroy', $user->id) }}" class="inline-block"
                        onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="border p-2 text-center">Tidak ada akun ditemukan.</td>
            </tr>
        @endforelse
    </tbody>

</table>

<div class="mt-2">
    {{ $users->links() }}
</div>
