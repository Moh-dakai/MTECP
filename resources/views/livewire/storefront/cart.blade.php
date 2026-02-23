<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>

    @if (session()->has('cart_message'))
        <div class="mt-4 p-4 text-green-700 bg-green-100 rounded-md">
            {{ session('cart_message') }}
        </div>
    @endif

    <div class="mt-8">
        @if(count($items) > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($items as $item)
                        <li class="p-6 flex py-6">
                            <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden bg-gray-100 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>

                            <div class="ml-4 flex-1 flex flex-col justify-center">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <h3>{{ $item['product']->name }}</h3>
                                        <p class="ml-4">${{ number_format($item['subtotal'], 2) }}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Price: ${{ number_format($item['product']->price_cents / 100, 2) }}</p>
                                </div>
                                <div class="flex-1 flex items-end justify-between mt-2">
                                    <div class="flex items-center space-x-2">
                                        <label for="quantity-{{ $item['product']->id }}" class="text-sm text-gray-700">Qty:</label>
                                        <input type="number" 
                                               id="quantity-{{ $item['product']->id }}" 
                                               wire:change="updateQuantity({{ $item['product']->id }}, $event.target.value)" 
                                               value="{{ $item['quantity'] }}" 
                                               min="1" 
                                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-16 sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="flex">
                                        <button wire:click="removeItem({{ $item['product']->id }})" type="button" class="font-medium text-red-600 hover:text-red-500">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
                <div class="flex justify-between text-base font-medium text-gray-900">
                    <p>Subtotal</p>
                    <p>${{ number_format($subtotal, 2) }}</p>
                </div>
                <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                <div class="mt-6">
                    <a href="{{ route('checkout') }}" class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Checkout
                    </a>
                </div>
                <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                    <p>
                        or <a href="{{ url('/') }}" class="text-indigo-600 font-medium hover:text-indigo-500">Continue Shopping<span aria-hidden="true"> &rarr;</span></a>
                    </p>
                </div>
            </div>
        @else
            <div class="text-center py-16 bg-white shadow rounded-lg">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Your cart is empty</h3>
                <p class="mt-1 text-sm text-gray-500">Looks like you haven't added anything yet.</p>
                <div class="mt-6">
                    <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Start Shopping
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
