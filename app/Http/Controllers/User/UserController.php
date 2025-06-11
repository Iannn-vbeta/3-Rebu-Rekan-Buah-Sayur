<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
protected $middleware = [];

    public function __construct()
    {
        $this->middleware[] = function ($request, $next) {
            if (Auth::check() && Auth::user()->id_role == 2) {
                return redirect()->route('user.dashboard');
            }
            return $next($request);
        };
    }
    public function index()
    {
        return view('user.dashboard');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'current_password' => 'required|string',
        ]);

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.'])->withInput();
        }

        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}