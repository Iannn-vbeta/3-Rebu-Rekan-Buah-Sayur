<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
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
        $totalUsers = User::where('id_role', 2)->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        $salesTraffic = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'salesTraffic' => $salesTraffic,
        ]);
    }
}