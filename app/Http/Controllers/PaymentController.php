<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function success(Request $request)
    {
        $orderId = $request->order_id;
        $transactionId = $request->transaction_id;

        $order = Order::findOrFail($orderId);
        
        $order->update([
            'payment_status' => 'paid',
            'status' => 'paid',
            'midtrans_transaction_id' => $transactionId,
            'paid_at' => now(),
        ]);

        return view('customer.payment.success', compact('order'));
    }

    public function pending(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::findOrFail($orderId);

        return view('customer.payment.pending', compact('order'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            $orderId = explode('-', $request->order_id)[1];
            $order = Order::find($orderId);

            if ($order) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'paid',
                        'midtrans_transaction_id' => $request->transaction_id,
                        'midtrans_payment_type' => $request->payment_type,
                        'paid_at' => now(),
                    ]);
                } elseif ($request->transaction_status == 'pending') {
                    $order->update([
                        'payment_status' => 'pending',
                    ]);
                } elseif ($request->transaction_status == 'deny' || $request->transaction_status == 'expire' || $request->transaction_status == 'cancel') {
                    $order->update([
                        'payment_status' => 'failed',
                        'status' => 'cancelled',
                    ]);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
