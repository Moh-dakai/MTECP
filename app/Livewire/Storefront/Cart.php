<?php

namespace App\Livewire\Storefront;

use App\Models\Product;
use Livewire\Component;

class Cart extends Component
{
    public $cart = []; // [product_id => quantity]
    public $items = []; // Hydrated product objects with quantity
    public $subtotal = 0;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $tenantId = tenant('id');
        $this->cart = session()->get("cart.{$tenantId}", []);
        $this->hydrateCart();
    }

    public function hydrateCart()
    {
        if (empty($this->cart)) {
            $this->items = [];
            $this->subtotal = 0;
            return;
        }

        $productIds = array_keys($this->cart);
        // Products are inherently scoped to the current tenant
        $products = Product::whereIn('id', $productIds)->get();

        $hydrated = [];
        $total = 0;

        foreach ($products as $product) {
            $quantity = $this->cart[$product->id];
            $hydrated[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => ($product->price_cents * $quantity) / 100,
            ];
            $total += ($product->price_cents * $quantity) / 100;
        }

        $this->items = $hydrated;
        $this->subtotal = $total;
    }

    public function updateQuantity($productId, $quantity)
    {
        $quantity = max(1, (int)$quantity); // Minimum 1
        $tenantId = tenant('id');

        $this->cart[$productId] = $quantity;
        session()->put("cart.{$tenantId}", $this->cart);

        $this->hydrateCart();
        $this->dispatch('cart-updated');
    }

    public function removeItem($productId)
    {
        $tenantId = tenant('id');

        unset($this->cart[$productId]);
        session()->put("cart.{$tenantId}", $this->cart);

        $this->hydrateCart();
        $this->dispatch('cart-updated');
        session()->flash('cart_message', 'Item removed from cart.');
    }

    public function render()
    {
        return view('livewire.storefront.cart');
    }
}
