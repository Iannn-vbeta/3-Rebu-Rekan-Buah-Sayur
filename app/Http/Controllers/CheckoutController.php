<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showForm()
    {
        $cart = Auth::user()->cart()->with('cartItems.product')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        return view('user.checkout', compact('cart'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'method' => 'required|in:ambil_di_tempat,antar',
            'address' => 'required_if:method,antar',
            'city' => 'required_if:method,antar',
            'phone' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        $cart = $user->cart()->with('cartItems.product')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        // Hitung total harga
        $totalPrice = 0;
        foreach ($cart->cartItems as $item) {
            $totalPrice += $item->quantity * $item->product->price;
        }

        // Buat order
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Simpan item yang di order
        foreach ($cart->cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Simpan pengiriman info bre
        ShippingInfo::create([
            'order_id' => $order->id,
            'method' => $request->method,
            'address' => $request->method == 'antar' ? $request->address : null,
            'city' => $request->method == 'antar' ? $request->city : null,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);

        // Konfigurasi Midtrans nyohh
        Config::$serverKey = env('MIDTRANS_SERVER_KEY', config('midtrans.server_key'));
        Config::$isProduction = env('MIDTRANS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $request->phone,
            ],'callback' => [
                'finish' => route('checkout.process'),
            ],'notification_url' => 'https://cfb8-103-160-182-90.ngrok-free.app/midtrans/callback',
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan payment dengan status pending
        Payment::create([
            'order_id' => $order->id,
            'payment_gateway' => 'midtrans',
            'payment_status' => 'pending', 
            'amount' => $totalPrice,
            'snap_token' => $snapToken, 
        ]);

        $cart->cartItems()->delete();

        return view('user.payment', compact('snapToken', 'order'));
    }

public function checkoutProcess(Request $request)
{
    // Ambil order berdasarkan ID dari request, atau lakukan validasi/simpan order di sini
    $order = Order::where('user_id', $request->user()->id)
        ->latest()
        ->with('orderItems.product')
        ->first();

    if (!$order) {
        return redirect()->route('cart.index')->with('error', 'Order tidak ditemukan.');
    }

    $totalPrice = $order->total_price;

    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production', false);
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $transaction_details = [
        'order_id' => $order->id,
        'gross_amount' => $totalPrice,
    ];

    $item_details = [];

    foreach ($order->orderItems as $item) {
        $item_details[] = [
            'id' => $item->product_id,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'name' => $item->product->name,
        ];
    }

    $customer_details = [
        'first_name' => $request->user()->username,
        'email' => $request->user()->email,
        'phone' => $request->phone,
        // alamat jika ada
    ];

    $params = [
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details,
    ];

    $snapToken = Snap::getSnapToken($params);

    // Simpan token di order/payment jika perlu

    return view('user.payment', compact('snapToken', 'order'));
}
}