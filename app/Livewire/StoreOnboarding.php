<?php

namespace App\Livewire;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class StoreOnboarding extends Component
{
    public $store_name = '';
    public $subdomain = '';
    public $admin_name = '';
    public $admin_email = '';
    public $admin_password = '';
    public $password_confirmation = '';

    protected function rules()
    {
        return [
            'store_name' => ['required', 'string', 'max:255'],
            'subdomain' => [
                'required', 'string', 'min:3', 'max:50', 'alpha_dash',
                Rule::unique('domains', 'domain')->where(function ($query) {
            return $query->where('domain', $this->subdomain . '.mtecp.test');
        }),
            ],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'admin_password' => ['required', 'string', 'min:8', 'same:password_confirmation'],
        ];
    }

    public function submit()
    {
        $this->validate();

        $tenantId = strtolower($this->subdomain);

        if (Tenant::where('id', $tenantId)->exists()) {
            $this->addError('subdomain', 'This subdomain is already taken.');
            return;
        }

        $tenant = Tenant::create([
            'id' => $tenantId,
            'name' => $this->store_name,
            'color_primary' => '#4f46e5', // Default Indigo
            'color_secondary' => '#4338ca', // Default Indigo Dark
        ]);

        $domainStr = $tenantId . '.mtecp.test';
        $tenant->domains()->create(['domain' => $domainStr]);

        // Tenancy starts here natively via BelongsToTenant scoping
        // Initialize the tenant context to create user and assign role
        tenancy()->initialize($tenant);

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => $this->admin_name,
            'email' => $this->admin_email,
            'password' => Hash::make($this->admin_password),
        ]);

        setPermissionsTeamId($tenant->id);
        $user->assignRole('Store Administrator');

        tenancy()->end();

        return redirect()->to('http://' . $domainStr . '/login');
    }

    public function render()
    {
        return view('livewire.store-onboarding');
    }
}
