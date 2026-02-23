<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    /**
     * Initialize a payment transaction with the selected provider
     */
    public static function initializeTransaction(Order $order, string $callbackUrl)
    {
        $tenant = tenant();
        $provider = $order->payment_method;

        if ($provider === 'paystack') {
            $secretKey = $tenant->paystack_secret_key ?? env('PAYSTACK_SECRET_KEY');
            if (!$secretKey) {
                throw new \Exception("Paystack is not configured for this store.");
            }

            $response = Http::withToken($secretKey)
                ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $order->shipping_email,
                // Paystack amounts are in kobo/cents
                'amount' => (int)($order->total * 100),
                'reference' => $order->order_number,
                'callback_url' => $callbackUrl,
            ]);

            if ($response->successful()) {
                return $response->json('data.authorization_url');
            }

            throw new \Exception("Paystack Initialization Failed: " . $response->body());
        }

        if ($provider === 'flutterwave') {
            $secretKey = $tenant->flutterwave_secret_key ?? env('FLW_SECRET_KEY');
            if (!$secretKey) {
                throw new \Exception("Flutterwave is not configured for this store.");
            }

            $response = Http::withToken($secretKey)
                ->post('https://api.flutterwave.com/v3/payments', [
                'tx_ref' => $order->order_number,
                'amount' => $order->total,
                'currency' => $order->currency,
                'redirect_url' => $callbackUrl,
                'customer' => [
                    'email' => $order->shipping_email,
                    'name' => $order->shipping_first_name . ' ' . $order->shipping_last_name,
                    'phonenumber' => $order->shipping_phone,
                ],
            ]);

            if ($response->successful()) {
                return $response->json('data.link');
            }

            throw new \Exception("Flutterwave Initialization Failed: " . $response->body());
        }

        throw new \Exception("Unsupported payment provider: {$provider}");
    }

    /**
     * Verify a transaction after callback
     */
    public static function verifyTransaction(string $provider, string $reference)
    {
        $tenant = tenant();

        if ($provider === 'paystack') {
            $secretKey = $tenant->paystack_secret_key ?? env('PAYSTACK_SECRET_KEY');
            $response = Http::withToken($secretKey)
                ->get("https://api.paystack.co/transaction/verify/{$reference}");

            if ($response->successful() && $response->json('data.status') === 'success') {
                return true;
            }
            return false;
        }

        if ($provider === 'flutterwave') {
            // Flutterwave passes transaction_id in query string for verification
            $secretKey = $tenant->flutterwave_secret_key ?? env('FLW_SECRET_KEY');
            $response = Http::withToken($secretKey)
                ->get("https://api.flutterwave.com/v3/transactions/{$reference}/verify");

            if ($response->successful() && $response->json('data.status') === 'successful') {
                return true;
            }
            return false;
        }

        return false;
    }
}
