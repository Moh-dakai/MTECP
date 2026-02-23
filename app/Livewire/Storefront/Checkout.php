<?php

namespace App\Livewire\Storefront;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Component;

class Checkout extends Component
{
    public $cart = [];
    public $items = [];
    public $subtotal = 0;
    public $tax = 0;
    public $shipping = 0;
    public $total = 0;

    // Shipping Forms
    public $shipping_first_name = '';
    public $shipping_last_name = '';
    public $shipping_email = '';
    public $shipping_phone = '';
    public $shipping_address = '';
    public $shipping_city = '';
    public $shipping_state = '';
    public $shipping_zip = '';
    public $shipping_country = '';

    // Payment Selection
    public $payment_method = 'paystack'; // or 'flutterwave'

    public function mount()
    {
        $this->loadCart();
        if (empty($this->items)) {
            return redirect()->route('cart');
        }
    }

    public function loadCart()
    {
        $tenantId = tenant('id');
        $this->cart = session()->get("cart.{$tenantId}", []);

        if (empty($this->cart))
            return;

        $products = Product::whereIn('id', array_keys($this->cart))->get();

        $total = 0;
        foreach ($products as $product) {
            $quantity = $this->cart[$product->id];
            $this->items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => ($product->price_cents * $quantity) / 100,
            ];
            $total += ($product->price_cents * $quantity) / 100;
        }

        $this->subtotal = $total;
        $this->tax = $total * 0.05; // 5% dummy tax
        $this->shipping = 10.00; // Flat dummy shipping
        $this->total = $this->subtotal + $this->tax + $this->shipping;
    }

    public function processCheckout()
    {
        $this->validate([
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_zip' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:255',
            'payment_method' => 'required|in:paystack,flutterwave',
        ]);

        // Create the core order
        $order = Order::create([
            'tenant_id' => tenant('id'),
            'user_id' => auth()->id(), // null if guest
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'status' => Order::STATUS_PENDING,
            'currency' => 'USD',
            'subtotal' => $this->subtotal,
            'tax_amount' => $this->tax,
            'shipping_amount' => $this->shipping,
            'discount_amount' => 0,
            'total' => $this->total,

            'shipping_first_name' => $this->shipping_first_name,
            'shipping_last_name' => $this->shipping_last_name,
            'shipping_email' => $this->shipping_email,
            'shipping_phone' => $this->shipping_phone,
            'shipping_address' => $this->shipping_address,
            'shipping_city' => $this->shipping_city,
            'shipping_state' => $this->shipping_state,
            'shipping_zip' => $this->shipping_zip,
            'shipping_country' => $this->shipping_country,

            // Mirroring billing to shipping for simplicity in this iteration
            'billing_first_name' => $this->shipping_first_name,
            'billing_last_name' => $this->shipping_last_name,
            'billing_email' => $this->shipping_email,
            'billing_phone' => $this->shipping_phone,
            'billing_address' => $this->shipping_address,
            'billing_city' => $this->shipping_city,
            'billing_state' => $this->shipping_state,
            'billing_zip' => $this->shipping_zip,
            'billing_country' => $this->shipping_country,

            'payment_method' => $this->payment_method,
            'payment_status' => Order::PAYMENT_STATUS_PENDING,
        ]);

        // Save order items
        foreach ($this->items as $item) {
            $product = $item['product'];
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->price_cents / 100,
                'quantity' => $item['quantity'],
                'total' => $item['subtotal'],
            ]);
        }

        // Clear cart
        $tenantId = tenant('id');
        session()->forget("cart.{$tenantId}");

        try {
            // Note: route('payment.callback') will need to be defined in tenant.php
            $callbackUrl = route('payment.callback', ['provider' => $this->payment_method]);
            $paymentUrl = \App\Services\PaymentService::initializeTransaction($order, $callbackUrl);
            return redirect()->away($paymentUrl);
        }
        catch (\Exception $e) {
            session()->flash('cart_error', $e->getMessage());
            return redirect()->route('cart');
        }
    }

    public function render()
    {
        return view('livewire.storefront.checkout');
    }
}
