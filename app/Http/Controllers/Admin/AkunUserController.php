<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AkunUserController extends Controller

{
    public function index(Request $request)
    {
        $users = User::where('id_role', 2)->latest()->paginate(10);
        return view('admin.akunUser', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['id_role'] = 2;
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);
        return redirect()->back()->with('success', 'Akun user berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id_role', 2)->findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Akun user berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::where('id_role', 2)->findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Akun user berhasil dihapus');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $users = User::where('id_role', 2)
            ->where(function($query) use ($search) {
                $query->where('username', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);
        return view('components.admin.userTable', compact('users'))->render();
    }
}