<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $middleware = [];

    public function __construct()
    {
        $this->middleware[] = function ($request, $next) {
            if (Auth::check() && Auth::user()->id_role == 1) {
                return redirect()->route('admin.dashboard');
            }
            return $next($request);
        };
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}