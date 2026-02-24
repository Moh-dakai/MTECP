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
        // Instead of manually editing the JSON payload, treat `is_suspended`
        // as a virtual attribute. The tenant model will persist unknown
        // attributes into the `data` column automatically, so we can simply
        // toggle the property and save the model normally.
        $tenant = Tenant::findOrFail($tenantId);
        $isSuspended = $tenant->is_suspended ?? false;

        $tenant->is_suspended = ! $isSuspended;
        $tenant->save();

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
                ->orWhere('data->name', 'like', '%' . $this->search . '%');
        }

        return view('livewire.central.tenant-manager', [
            'tenants' => $query->paginate(15)
        ]);
    }
}
