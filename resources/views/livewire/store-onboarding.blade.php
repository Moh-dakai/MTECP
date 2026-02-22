<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900">Create your Store</h2>
            <p class="text-sm text-gray-500 mt-1">Join the multi-tenant e-commerce platform.</p>
        </div>

        <form wire:submit.prevent="submit" class="space-y-4">
            <!-- Store Name -->
            <div>
                <label for="store_name" class="block text-sm font-medium text-gray-700">Store Name</label>
                <input wire:model="store_name" id="store_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="My Awesome Store" required autofocus>
                @error('store_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Subdomain -->
            <div>
                <label for="subdomain" class="block text-sm font-medium text-gray-700">Store Address (Subdomain)</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input wire:model="subdomain" id="subdomain" type="text" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="mystore" required>
                    <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                        .mtecp.test
                    </span>
                </div>
                @error('subdomain') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <hr class="my-4 border-gray-200">

            <div class="mb-4 text-center">
                <h3 class="text-lg font-medium text-gray-900">Admin Account</h3>
                <p class="text-xs text-gray-500 mt-1">This will be the store owner's account.</p>
            </div>

            <!-- Admin Name -->
            <div>
                <label for="admin_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input wire:model="admin_name" id="admin_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="John Doe" required>
                @error('admin_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Admin Email -->
            <div>
                <label for="admin_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input wire:model="admin_email" id="admin_email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="you@example.com" required>
                @error('admin_email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Admin Password -->
            <div>
                <label for="admin_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input wire:model="admin_password" id="admin_password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                @error('admin_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input wire:model="password_confirmation" id="password_confirmation" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <div class="pt-4 flex items-center justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <span wire:loading.remove wire:target="submit">Create Store</span>
                    <span wire:loading wire:target="submit">Creating...</span>
                </button>
            </div>
        </form>
    </div>
</div>
