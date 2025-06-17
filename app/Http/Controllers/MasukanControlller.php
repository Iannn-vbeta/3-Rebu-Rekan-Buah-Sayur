<?php

namespace App\Http\Controllers;

use App\Models\Masukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasukanControlller extends Controller
{
    public function index()
    {
        return view('user.masukan');
    }
    public function store(Request $request)
    {
        $request->validate([
            'pesan' => 'required|string|max:500',
        ]);

        // Simpan masukan ke database
        Masukan::create([
            'user_id' => Auth::id(),
            'pesan' => $request->input('pesan'),
        ]);

        return redirect()->route('user.masukan')->with('success', 'Masukan Anda telah diterima kami dengan baik.');
    }

    public function showMasukan()
    {
        $masukans = Masukan::with('user')->paginate(10);
        return view('admin.masukan', compact('masukans'));
    }
}