<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
        public function userOrders(Request $request)
        {
        $orders = $request->user()->orders()->with('orderItems.product', 'payment')->orderBy('id', 'desc')->paginate(10);
        return view('user.orders', compact('orders'));
        }


}