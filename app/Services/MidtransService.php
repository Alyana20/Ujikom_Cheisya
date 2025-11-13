<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MidtransService
{
    private $serverKey;
    private $clientKey;
    private $isProduction;
    private $apiUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->isProduction = config('midtrans.is_production');
        $this->apiUrl = $this->isProduction 
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    public function createTransaction($order)
    {
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->phone ?? $order->user->phone ?? '08123456789',
                'shipping_address' => [
                    'address' => $order->shipping_address,
                ],
            ],
            'item_details' => $this->getItemDetails($order),
            'enabled_payments' => ['credit_card', 'bca_va', 'bni_va', 'bri_va', 'mandiri_va', 'permata_va', 'other_va', 'gopay', 'shopeepay'],
        ];

        try {
            $response = Http::withoutVerifying()
                ->withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($this->apiUrl, $params);

            if ($response->successful()) {
                $result = $response->json();
                return $result['token'];
            } else {
                throw new \Exception('Midtrans API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            throw new \Exception('Error creating Midtrans transaction: ' . $e->getMessage());
        }
    }

    private function getItemDetails($order)
    {
        $items = [];
        
        foreach ($order->items as $item) {
            $items[] = [
                'id' => $item->product_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name ?? 'Product',
            ];
        }

        return $items;
    }

    public function getTransactionStatus($orderId)
    {
        $statusUrl = $this->isProduction
            ? "https://api.midtrans.com/v2/{$orderId}/status"
            : "https://api.sandbox.midtrans.com/v2/{$orderId}/status";

        try {
            $response = Http::withoutVerifying()
                ->withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->get($statusUrl);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception('Midtrans API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            throw new \Exception('Error getting transaction status: ' . $e->getMessage());
        }
    }
}

