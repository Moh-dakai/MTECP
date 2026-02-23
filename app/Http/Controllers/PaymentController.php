<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request, $provider)
    {
        // Paystack uses 'reference' or 'trxref'
        // Flutterwave uses 'transaction_id' and 'tx_ref'
        // Some providers put the original reference in tx_ref and the processor reference in transaction_id
        $processorRef = $request->query('reference') ?? $request->query('transaction_id');
        $orderRef = $request->query('trxref') ?? $request->query('tx_ref') ?? $request->query('reference');

        if (!$processorRef && !$orderRef) {
            return redirect()->route('cart')->with('cart_error', 'Invalid payment callback parameters.');
        }

        // We use $orderRef to find the order because tx_ref/reference was sent as the order_number
        $order = Order::where('order_number', $orderRef)->first();

        if (!$order) {
            return redirect()->route('cart')->with('cart_error', 'Order not found or already verified.');
        }

        try {
            // For Paystack, we verify with the reference. For Flutterwave, transaction_id.
            $verifyRef = $provider === 'flutterwave' ? $request->query('transaction_id') : $processorRef;

            $isSuccessful = PaymentService::verifyTransaction($provider, $verifyRef);

            if ($isSuccessful) {
                $order->update([
                    'status' => Order::STATUS_PROCESSING,
                    'payment_status' => Order::PAYMENT_STATUS_PAID,
                    'payment_transaction_id' => $processorRef,
                ]);

                return redirect('/')->with('success', 'Payment successful! Order #' . $order->order_number . ' is now processing.');
            }
            else {
                $order->update([
                    'payment_status' => Order::PAYMENT_STATUS_FAILED,
                ]);
                // In a real app we would restore the cart, but for now we redirect back with error.
                return redirect()->route('cart')->with('cart_error', 'Payment verification failed.');
            }
        }
        catch (\Exception $e) {
            return redirect()->route('cart')->with('cart_error', 'Payment verification error: ' . $e->getMessage());
        }
    }
}
