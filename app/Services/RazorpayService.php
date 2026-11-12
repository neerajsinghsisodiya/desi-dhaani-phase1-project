<?php

namespace App\Services;

use Razorpay\Api\Api;

class RazorpayService
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api(
            config('services.razorpay.key_id'),
            config('services.razorpay.key_secret')
        );
    }

    public function createOrder(int $amount, string $currency, string $receipt): array
    {
        $order = $this->api->order->create([
            'amount' => $amount,
            'currency' => $currency,
            'receipt' => $receipt,
        ]);

        return [
            'order_id' => $order->id,
            'amount' => (int) $order->amount,
            'currency' => $order->currency,
        ];
    }

    public function verifySignature(string $orderId, string $paymentId, string $signature): bool
    {
        $expected = hash_hmac('sha256', $orderId.'|'.$paymentId, config('services.razorpay.key_secret'));

        return hash_equals($expected, $signature);
    }
}
