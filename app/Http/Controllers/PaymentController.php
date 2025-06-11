<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{
public function handleCallback(Request $request)
{
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $notif = new Notification();

    $transaction = $notif->transaction_status;
    $orderId = $notif->order_id;
    $paymentType = $notif->payment_type;
    $fraudStatus = $notif->fraud_status;

    // Logging debug
    Log::info('MIDTRANS CALLBACK RECEIVED', [
        'transaction_status' => $transaction,
        'order_id' => $orderId,
        'payment_type' => $paymentType,
        'fraud_status' => $fraudStatus,
    ]);

    $order = Order::find($orderId);
    $payment = Payment::where('order_id', $orderId)->first();

    if (!$order || !$payment) {
        Log::error('Order/Payment tidak ditemukan untuk order_id ' . $orderId);
        return response()->json(['message' => 'Order not found'], 404);
    }

    if ($transaction == 'capture') {
        if ($paymentType == 'credit_card') {
            if ($fraudStatus == 'challenge') {
                $order->status = 'pending';
                $payment->payment_status = 'pending';
            } else {
                $order->status = 'paid';
                $payment->payment_status = 'paid';
            }
        }
    } elseif ($transaction == 'settlement') {
        $order->status = 'paid';
        $payment->payment_status = 'paid';
    } elseif ($transaction == 'pending') {
        $order->status = 'pending';
        $payment->payment_status = 'pending';
    } elseif (in_array($transaction, ['deny', 'cancel', 'expire'])) {
        $order->status = 'cancelled';
        $payment->payment_status = 'failed';
    }

    $order->save();
    $payment->save();

    return response()->json(['message' => 'Callback handled'], 200);
}
}