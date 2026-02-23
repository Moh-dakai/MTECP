<?php

namespace App\Livewire\Central;

use App\Models\Tenant;
use Livewire\Component;
use Livewire\WithPagination;

class TenantManager extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleSuspension($tenantId)
    {
        // For a full implementation, you'd add a 'suspended' boolean to the tenants table.
        // For the scope of this MVP, we will simulate it via the JSON payload.
        $tenant = Tenant::findOrFail($tenantId);
        $currentData = is_array($tenant->data) ? $tenant->data : [];
        $isSuspended = $currentData['is_suspended'] ?? false;

        $currentData['is_suspended'] = !$isSuspended;

        $tenant->update(['data' => $currentData]);

        session()->flash('message', 'Tenant suspension toggled successfully.');
    }

    public function deleteTenant($tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);

        // stancl/tenancy handles cascading the isolated database dropping via jobs
        $tenant->delete();

        session()->flash('message', 'Tenant deleted permanently.');
    }

    public function render()
    {
        $query = Tenant::with('domains')->latest();

        if ($this->search) {
            $query->where('id', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%');
        }

        return view('livewire.central.tenant-manager', [
            'tenants' => $query->paginate(15)
        ]);
    }
}
