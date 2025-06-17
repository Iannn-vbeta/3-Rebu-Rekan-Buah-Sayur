<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AkunAdminController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('id_role', 1)->latest()->paginate(10);
        return view('admin.akunAdmin', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['id_role'] = 1;
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);
        return redirect()->back()->with('success', 'Akun admin berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id_role', 1)->findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Akun admin berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::where('id_role', 1)->findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Akun admin berhasil dihapus');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $users = User::where('id_role', 1)
            ->where(function($query) use ($search) {
                $query->where('username', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);
        return view('components.admin.adminTable', compact('users'))->render();
    }
}