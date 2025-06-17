<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
      public function handleNotification(Request $request)
    {
        http_response_code(200);
        
        ignore_user_abort(true);
        set_time_limit(0);
        
        if (!$request->isJson()) {
            Log::channel('midtrans')->error('Invalid content type', [
                'headers' => $request->headers->all()
            ]);
            exit;
        }

        $payload = $request->json()->all();
        Log::channel('midtrans')->info('Raw Notification:', $payload);

        try {
            // Validate required fields
            $requiredFields = ['order_id', 'transaction_status', 'gross_amount', 'signature_key'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    Log::channel('midtrans')->error("Missing required field: $field", $payload);
                    exit;
                }
            }

            // Verify signature key
            $signatureKey = hash('sha512', 
                $payload['order_id'] . 
                $payload['status_code'] . 
                $payload['gross_amount'] . 
                config('midtrans.server_key')
            );

            if ($payload['signature_key'] !== $signatureKey) {
                Log::channel('midtrans')->error('Invalid signature', [
                    'received' => $payload['signature_key'],
                    'calculated' => $signatureKey,
                    'order_id' => $payload['order_id']
                ]);
                exit;
            }

            // Process order update
            $this->updateOrderStatus($payload);

            // For pending/settlement, verify with Midtrans API
            if (in_array($payload['transaction_status'], ['pending', 'settlement'])) {
                $this->verifyWithMidtransAPI($payload['transaction_id']);
            }

        } catch (\Exception $e) {
            Log::channel('midtrans')->error('Notification Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $payload
            ]);
        }
        
        exit;
    }

    protected function updateOrderStatus(array $payload)
    {
        $order = Order::find($payload['order_id']);
        if (!$order) {
            Log::channel('midtrans')->error('Order not found', ['order_id' => $payload['order_id']]);
            return;
        }

        $statusMap = [
            'capture' => 'paid',
            'settlement' => 'paid',
            'pending' => 'pending',
            'deny' => 'failed',
            'cancel' => 'failed',
            'expire' => 'failed'
        ];

        $status = $statusMap[$payload['transaction_status']] ?? 'pending';
        
        $order->status = $status;
        $order->save();

        $payment = Payment::where('order_id', $order->id)->first();
        if ($payment) {
            $payment->payment_status = $status;
            $payment->transaction_id = $payload['transaction_id'] ?? null;
            $payment->raw_response = json_encode($payload);
            $payment->save();
        }

        Log::channel('midtrans')->info('Order updated', [
            'order_id' => $order->id,
            'status' => $status,
            'transaction_status' => $payload['transaction_status']
        ]);
    }

    protected function verifyWithMidtransAPI($transactionId)
    {
        $authString = base64_encode(config('midtrans.server_key') . ':');
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Basic $authString",
            'Content-Type' => 'application/json'
        ])->get('https://api.sandbox.midtrans.com/v2/' . $transactionId . '/status');

        if ($response->successful()) {
            Log::channel('midtrans')->info('API Verification Success', $response->json());
        } else {
            Log::channel('midtrans')->error('API Verification Failed', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
        }
    }
}