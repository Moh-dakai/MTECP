<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderManager extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    // Modals
    public $viewingOrder = null;
    public $showOrderModal = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function viewOrder($id)
    {
        $this->viewingOrder = Order::with('items', 'user')->findOrFail($id);
        $this->showOrderModal = true;
    }

    public function updateOrderStatus($status)
    {
        if ($this->viewingOrder) {
            $this->viewingOrder->update(['status' => $status]);
            session()->flash('message', 'Order status updated successfully.');
        }
    }

    public function closeOrderModal()
    {
        $this->showOrderModal = false;
        $this->viewingOrder = null;
    }

    public function render()
    {
        $query = Order::query()->latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                    ->orWhere('shipping_first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('shipping_last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('shipping_email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.order-manager', [
            'orders' => $query->paginate(10)
        ]);
    }
}
