<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
        <div>
            <div>
                <h2 class="text-lg font-medium text-gray-900">Contact/Shipping information</h2>
                
                <form wire:submit.prevent="processCheckout" class="mt-4">
                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div>
                            <label for="shipping_first_name" class="block text-sm font-medium text-gray-700">First name</label>
                            <input type="text" wire:model="shipping_first_name" id="shipping_first_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('shipping_first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="shipping_last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                            <input type="text" wire:model="shipping_last_name" id="shipping_last_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('shipping_last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="shipping_email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <input type="email" wire:model="shipping_email" id="shipping_email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('shipping_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" wire:model="shipping_address" id="shipping_address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('shipping_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="shipping_city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" wire:model="shipping_city" id="shipping_city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('shipping_city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="shipping_state" class="block text-sm font-medium text-gray-700">State / Province</label>
                            <input type="text" wire:model="shipping_state" id="shipping_state" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('shipping_state') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="shipping_zip" class="block text-sm font-medium text-gray-700">Postal code</label>
                            <input type="text" wire:model="shipping_zip" id="shipping_zip" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('shipping_zip') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="shipping_country" class="block text-sm font-medium text-gray-700">Country</label>
                            <select wire:model="shipping_country" id="shipping_country" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Select country</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="United States">United States</option>
                                <option value="Canada">Canada</option>
                                <option value="United Kingdom">United Kingdom</option>
                            </select>
                            @error('shipping_country') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="sm:col-span-2">
                            <label for="shipping_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" wire:model="shipping_phone" id="shipping_phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('shipping_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <h2 class="text-lg font-medium text-gray-900">Payment Processors</h2>

                        <fieldset class="mt-4">
                            <legend class="sr-only">Payment type</legend>
                            <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                <div class="flex items-center">
                                    <input id="paystack" wire:model="payment_method" type="radio" value="paystack" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="paystack" class="ml-3 block text-sm font-medium text-gray-700">
                                        Paystack
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="flutterwave" wire:model="payment_method" type="radio" value="flutterwave" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="flutterwave" class="ml-3 block text-sm font-medium text-gray-700">
                                        Flutterwave
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
                            Confirm Order
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order summary -->
        <div class="mt-10 lg:mt-0">
            <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

            <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h3 class="sr-only">Items in your cart</h3>
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($items as $item)
                        <li class="flex py-6 px-4 sm:px-6">
                            <div class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-md border border-gray-200 flex items-center justify-center">
                                <span class="text-xs text-gray-400">Img</span>
                            </div>
                            <div class="ml-4 flex-1 flex flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <h4>{{ $item['product']->name }}</h4>
                                        <p class="ml-4">${{ number_format($item['subtotal'], 2) }}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <dl class="border-t border-gray-200 py-6 px-4 space-y-6 sm:px-6">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">${{ number_format($subtotal, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-sm">Shipping</dt>
                        <dd class="text-sm font-medium text-gray-900">${{ number_format($shipping, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-sm">Taxes (5%)</dt>
                        <dd class="text-sm font-medium text-gray-900">${{ number_format($tax, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                        <dt class="text-base font-medium">Total</dt>
                        <dd class="text-base font-medium text-gray-900">${{ number_format($total, 2) }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
