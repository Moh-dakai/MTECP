<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Tenant Management</h1>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="mb-4 w-full md:w-1/3">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search tenants..." class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Store ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Store Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domains</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($tenants as $tenant)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $tenant->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $tenant->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @foreach($tenant->domains as $domain)
                                        <a href="http://{{ $domain->domain }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 block">{{ $domain->domain }}</a>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(isset($tenant->data['is_suspended']) && $tenant->data['is_suspended'])
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Suspended</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $tenant->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2 flex justify-end">
                                    <button 
                                        wire:click="toggleSuspension('{{ $tenant->id }}')" 
                                        class="{{ (isset($tenant->data['is_suspended']) && $tenant->data['is_suspended']) ? 'text-green-600 hover:text-green-900' : 'text-yellow-600 hover:text-yellow-900' }}"
                                    >
                                        {{ (isset($tenant->data['is_suspended']) && $tenant->data['is_suspended']) ? 'Unsuspend' : 'Suspend' }}
                                    </button>
                                    <button 
                                        wire:click="deleteTenant('{{ $tenant->id }}')" 
                                        wire:confirm="Are you absolutely sure you want to permanently delete this tenant? This action cannot be undone."
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No tenants found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                {{ $tenants->links() }}
            </div>
        </div>
    </div>
</div>
